<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Scan;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ScanController extends Controller
{
    public function store(Request $request, AIService $aiService): Response
    {
        // 1. Validasi Input (Tambahkan consent_training)
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'notes' => 'nullable|string|max:1000',
            'consent_training' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'_'.Auth::id().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('scans', $filename, 'public');
            $fullPath = storage_path('app/public/'.$path);

            // LANGKAH 1: Tembak ke Python API (CNN)
            $cnnResult = $aiService->predictImage($fullPath);

            if (! $cnnResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $cnnResult['message'],
                ], 500);
            }

            $label = $cnnResult['label'];
            $detectedType = in_array($label, ['obat', 'luka'], true) ? $label : null;
            $confidence = $cnnResult['confidence'];
            $modelVersion = $cnnResult['model_version'];

            // LANGKAH 2: GUARDRAIL GATE
            if ($label === 'tidak_relevan' || $confidence <= 0.70) {
                $errorMessage = 'Gambar ditolak. ';
                if ($label === 'tidak_relevan') {
                    $errorMessage .= 'Sistem mendeteksi gambar ini bukan luka atau obat. Silakan unggah gambar yang sesuai.';
                } else {
                    $errorMessage .= 'Sistem tidak yakin dengan gambar ini (Keyakinan AI: '.round($confidence * 100).'%). Pastikan foto jelas dan cukup cahaya.';
                }

                $scan = Scan::create([
                    'user_id' => Auth::id(),
                    'image_path' => $path,
                    'type' => $detectedType,
                    'cnn_label' => $label,
                    'confidence_score' => $confidence,
                    'model_version' => $modelVersion,
                    'status' => 'rejected',
                    'error_code' => 'LOW_CONFIDENCE_OR_IRRELEVANT',
                    'initial_analysis' => $errorMessage,
                    'consent_training' => $request->consent_training, // <-- SIMPAN CONSENT
                ]);

                AuditLog::create([
                    'user_id' => Auth::id(),
                    'scan_id' => $scan->id,
                    'event_type' => 'SCAN_REJECTED',
                    'metadata' => ['label' => $label, 'confidence' => $confidence],
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ], 422);
            }

            // ==========================================
            // LANGKAH 3: Tembak Groq API (LLM dengan Gambar)
            // ==========================================

            // 1. Konversi gambar ke Base64 agar bisa dibaca Groq
            $base64 = base64_encode(file_get_contents($fullPath));
            $mime = $file->getMimeType();
            $imageUrl = "data:{$mime};base64,{$base64}";

            // 2. Susun Teks Prompt
            $userText = 'Sistem CNN kami mendeteksi gambar ini sebagai: '.strtoupper($label).' dengan keyakinan '.round($confidence * 100).'%. ';
            if ($request->filled('notes')) {
                $userText .= 'Catatan tambahan dari user: '.$request->notes.'. ';
            }
            $userText .= 'Tolong analisis gambar ini secara mendetail dan berikan penjelasan yang spesifik.';

            // 3. System Prompt (Dibuat ketat agar spesifik seperti versi 1)
            $systemPrompt = 'Anda adalah HealthCare, asisten medis awal berbasis AI.
- Jika gambar LUKA, sebutkan secara spesifik: (1) Jenis luka (misal: bakar, sayat, lecet), (2) Estimasi kedalaman/kondisi, (3) Langkah P3K spesifik, (4) Tanda bahaya.
- Jika gambar KEMASAN OBAT, sebutkan: (1) Nama obat yang terlihat, (2) Fungsi & indikasi obat tersebut, (3) Aturan pakai umum, (4) Efek samping utama.
Berikan jawaban dengan format Markdown yang rapi. Jangan pernah memberi diagnosis pasti.';

            try {
                // 4. Tembak API dengan format Multimodal (Teks + Gambar)
                $response = Http::withToken(config('services.groq.key'))
                    ->connectTimeout(3)
                    ->timeout(config('services.groq.timeout'))
                    ->post(config('services.groq.base_url').'/chat/completions', [
                        'model' => config('services.groq.model'),
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            [
                                'role' => 'user',
                                'content' => [
                                    ['type' => 'text', 'text' => $userText],
                                    ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]], // <-- KIRIM GAMBAR KE GROQ
                                ],
                            ],
                        ],
                        'temperature' => config('services.groq.temperature'),
                        'max_tokens' => config('services.groq.max_tokens'),
                    ]);

                if (! $response->successful()) {
                    Log::error('Groq API returned an error.', ['status' => $response->status()]);
                    throw new \RuntimeException('Groq request failed.');
                }

                $aiResponse = $response->json('choices.0.message.content');
                if (! is_string($aiResponse) || trim($aiResponse) === '') {
                    throw new \RuntimeException('Groq returned an invalid response.');
                }
            } catch (\Throwable $e) {
                Log::error('Groq API request failed.', ['exception' => $e]);

                return response()->json([
                    'success' => false,
                    'message' => 'Layanan AI belum tersedia. Silakan coba lagi.',
                ], 502);
            }

            // LANGKAH 4: Simpan Hasil Akhir ke Database
            $scan = Scan::create([
                'user_id' => Auth::id(),
                'image_path' => $path,
                'type' => $detectedType,
                'cnn_label' => $label,
                'confidence_score' => $confidence,
                'model_version' => $modelVersion,
                'status' => 'accepted',
                'initial_analysis' => $aiResponse,
                'consent_training' => $request->consent_training, // <-- SIMPAN CONSENT
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'scan_id' => $scan->id,
                'event_type' => 'SCAN_SUCCESS',
                'metadata' => ['label' => $label, 'confidence' => $confidence],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Analisis berhasil!',
                'image_url' => asset('storage/'.$path),
                'analysis' => $aiResponse,
                'cnn_label' => $label,
                'type' => $detectedType,
                'confidence' => $confidence,
                'scan_id' => $scan->id,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah gambar.'], 400);
    }
}
