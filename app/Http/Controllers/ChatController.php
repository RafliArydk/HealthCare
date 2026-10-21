<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // System Prompt: Memberi tahu AI siapa dia dan apa tugasnya
    private $systemPrompt = "Anda adalah HealthCare, asisten medis awal berbasis AI.
Tugas: analisis gambar yang dikirim user.
- Jika gambar LUKA → sebutkan (1) jenis luka, (2) estimasi kondisi (lecet/bakar/sayat), (3) langkah P3K, (4) tanda bahaya kapan harus ke dokter.
- Jika gambar KEMASAN OBAT → sebutkan (1) nama obat, (2) fungsi & indikasi, (3) aturan pakai umum, (4) efek samping utama.
- Jika gambar tidak relevan → tolak dengan sopan dan minta gambar luka/obat.
Selalu jawab singkat, jelas, dalam Bahasa Indonesia, gunakan bullet/heading.
Jangan pernah memberi diagnosis pasti.";

    /**
     * Halaman utama chat (GET /)
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Endpoint kirim pesan ke AI (POST /chat)
     */
    public function send(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'text'  => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:4096', // max 4 MB
        ]);

        if (!$request->filled('text') && !$request->hasFile('image')) {
            return response()->json(['reply' => '⚠️ Silakan kirim teks atau gambar ya.']);
        }

        // 2. Siapkan Konten Multimodal (Teks + Gambar)
        $userContent = [];

        if ($request->filled('text')) {
            $userContent[] = ['type' => 'text', 'text' => $request->text];
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $mime = $file->getMimeType();
            
            $userContent[] = [
                'type' => 'image_url',
                'image_url' => ['url' => "data:{$mime};base64,{$base64}"]
            ];
        }

        // 3. Susun Payload untuk Groq API (Format OpenAI)
        $payload = [
            'model' => config('services.groq.model'),
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'user', 'content' => $userContent],
            ],
            'temperature' => config('services.groq.temperature'),
            'max_tokens'  => config('services.groq.max_tokens'),
        ];

        // 4. Tembak ke Groq API
        try {
            $response = Http::withToken(config('services.groq.key'))
                ->timeout(config('services.groq.timeout'))
                ->acceptJson()
                ->post(config('services.groq.base_url') . '/chat/completions', $payload);

            // Jika API Error (401, 429, 500, dll)
            if ($response->failed()) {
                return response()->json([
                    'reply' => '⚠️ Gagal menghubungi AI: ' . ($response->json('error.message') ?? 'Unknown Error')
                ]);
            }

            // 5. Ambil Jawaban AI
            $reply = $response->json('choices.0.message.content') ?? 'Maaf, AI tidak memberikan jawaban.';
            
            // JANGAN PAKAI nl2br ATAU e() LAGI!
            // Kirim teks mentahnya langsung
            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            return response()->json(['reply' => '⚠️ Error sistem: ' . $e->getMessage()]);
        }
    }
}