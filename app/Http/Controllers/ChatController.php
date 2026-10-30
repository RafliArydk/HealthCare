<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\Chat;
use App\Models\AuditLog;
use App\Services\AIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function send(Request $request, Scan $scan = null, AIService $aiService)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:10240'
        ]);

        if (!$request->filled('message') && !$request->hasFile('image')) {
            return response()->json(['reply' => '⚠️ Silakan ketik pesan atau unggah gambar.'], 422);
        }

        $imageUrl = null;
        $newScan = $scan;
        $userText = $request->message ?? '';

        // 1. JIKA USER UPLOAD GAMBAR DI CHAT
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_chat_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('scans', $filename, 'public');
            $fullPath = storage_path('app/public/' . $path);

            // Panggil CNN Guardrail
            $cnnResult = $aiService->predictImage($fullPath);

            if (!$cnnResult['success']) {
                return response()->json(['reply' => '⚠️ Gagal menganalisis gambar: ' . $cnnResult['message']], 500);
            }

            $label = $cnnResult['label'];
            $confidence = $cnnResult['confidence'];

            // JIKA DITOLAK OLEH CNN
            if ($label === 'tidak_relevan' || $confidence <= 0.70) {
                return response()->json([
                    'reply' => "⚠️ Gambar ditolak. Sistem mendeteksi ini bukan luka atau obat (Keyakinan: " . round($confidence * 100) . "%). Silakan unggah gambar yang sesuai."
                ], 422);
            }

            // JIKA VALID, BUAT SCAN BARU (Agar masuk riwayat)
            $newScan = Scan::create([
                'user_id' => Auth::id(),
                'image_path' => $path,
                'type' => 'luka', // Default
                'cnn_label' => $label,
                'confidence_score' => $confidence,
                'model_version' => $cnnResult['model_version'],
                'status' => 'success',
                'initial_analysis' => 'Gambar diunggah via Chat',
                'consent_training' => true,
            ]);

            // Siapkan Base64 untuk Groq
            $base64 = base64_encode(file_get_contents($fullPath));
            $mime = $file->getMimeType();
            $imageUrl = "data:{$mime};base64,{$base64}";

            $userText = "Saya mengirim gambar ini. " . $userText;
        }

        // 2. SIMPAN PESAN USER KE DATABASE
        Chat::create([
            'scan_id' => $newScan ? $newScan->id : null,
            'sender' => 'user',
            'message' => $userText
        ]);

        // 3. SUSUN PROMPT UNTUK GROQ
        $systemPrompt = "Anda adalah CareBot, asisten kesehatan AI. Jawab pertanyaan user dengan ramah, singkat, dan edukatif. Jangan pernah memberi diagnosis pasti.";

        if ($newScan && $newScan->initial_analysis !== 'Gambar diunggah via Chat') {
            $systemPrompt .= " User telah melakukan scan {$newScan->type}. Hasil analisis awal: {$newScan->initial_analysis}.";
        }

        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        // Ambil history chat jika ada scan_id
        if ($newScan) {
            $history = Chat::where('scan_id', $newScan->id)->orderBy('created_at')->get();
            foreach ($history as $chat) {
                $messages[] = [
                    'role' => $chat->sender === 'user' ? 'user' : 'assistant',
                    'content' => $chat->message
                ];
            }
        } else {
            // Jika chat mandiri tanpa scan, minimal masukkan pesan terakhir
            $messages[] = ['role' => 'user', 'content' => $userText];
        }

        // Jika ada gambar, ubah pesan user terakhir menjadi multimodal
        if ($imageUrl) {
            $lastMsgIndex = count($messages) - 1;
            $messages[$lastMsgIndex]['content'] = [
                ['type' => 'text', 'text' => $userText],
                ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]]
            ];
        }

        // 4. TEMBAK GROQ API
        try {
            $response = Http::withToken(config('services.groq.key'))
                ->timeout(config('services.groq.timeout'))
                ->post(config('services.groq.base_url') . '/chat/completions', [
                    'model' => config('services.groq.model'),
                    'messages' => $messages,
                    'temperature' => 0.5,
                    'max_tokens' => 800,
                ]);

            $aiReply = $response->json('choices.0.message.content') ?? 'Maaf, saya tidak bisa menjawab saat ini.';
        } catch (\Exception $e) {
            Log::error('Groq Chat Error: ' . $e->getMessage());
            $aiReply = '⚠️ Gagal menghubungi AI. Silakan coba lagi.';
        }

        // 5. SIMPAN BALASAN AI
        Chat::create([
            'scan_id' => $newScan ? $newScan->id : null,
            'sender' => 'ai',
            'message' => $aiReply
        ]);

        return response()->json(['reply' => $aiReply]);
    }
}