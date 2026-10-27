<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'type' => 'required|in:obat,luka',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();

            // 1. Simpan gambar ke storage
            $path = $file->storeAs('scans', $filename, 'public');

            // 2. Konversi gambar ke Base64 untuk Groq
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $mime = $file->getMimeType();
            $imageUrl = "data:{$mime};base64,{$base64}";

            // 3. Siapkan Prompt
            $userText = "Tipe scan: " . $request->type . ". ";
            if ($request->filled('notes')) {
                $userText .= "Catatan tambahan dari user: " . $request->notes;
            }

            $systemPrompt = "Anda adalah HealthCare, asisten medis awal berbasis AI. Analisis gambar yang dikirim user secara detail.
- Jika gambar LUKA → sebutkan (1) jenis luka, (2) estimasi kondisi, (3) langkah P3K, (4) tanda bahaya.
- Jika gambar KEMASAN OBAT → sebutkan (1) nama obat, (2) fungsi & indikasi, (3) aturan pakai umum, (4) efek samping utama.
- Jika gambar tidak relevan → tolak dengan sopan.
Gunakan format Markdown yang rapi (bold, list). Jangan pernah memberi diagnosis pasti.";

            // 4. Tembak Groq API
            try {
                $response = Http::withToken(env('GROQ_API_KEY'))
                    ->timeout(30)
                    ->post('https://api.groq.com/openai/v1/chat/completions', [
                        'model' => env('GROQ_VISION_MODEL', 'qwen/qwen3.8-27b'),
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            [
                                'role' => 'user',
                                'content' => [
                                    ['type' => 'text', 'text' => $userText],
                                    ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]]
                                ]
                            ]
                        ],
                        'temperature' => 0.4,
                        'max_tokens' => 800,
                    ]);

                $aiResponse = $response->json('choices.0.message.content') ?? 'Maaf, AI tidak memberikan jawaban.';

            } catch (\Exception $e) {
                Log::error('Groq API Error: ' . $e->getMessage());
                $aiResponse = '⚠️ Gagal menghubungi AI. Pastikan koneksi internet stabil.';
            }

            // 5. Simpan ke Database
            $scan = Scan::create([
                'user_id' => Auth::id(),
                'image_path' => $path,
                'type' => $request->type,
                'initial_analysis' => $aiResponse,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Analisis berhasil!',
                'image_url' => asset('storage/' . $path),
                'analysis' => $aiResponse,
                'scan_id' => $scan->id
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengunggah gambar.'], 400);
    }
}