<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use App\Models\Chat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function send(Request $request, Scan $scan)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        // Simpan pesan user
        Chat::create([
            'scan_id' => $scan->id,
            'sender' => 'user',
            'message' => $request->message
        ]);

        // Ambil riwayat chat
        $history = Chat::where('scan_id', $scan->id)->orderBy('created_at')->get();

        $messages = [
            ['role' => 'system', 'content' => "Anda adalah CareBot, asisten kesehatan. User telah melakukan scan {$scan->type}. Hasil analisis awal: {$scan->initial_analysis}. Jawab pertanyaan lanjutan user dengan ramah, singkat, dan edukatif. Jangan memberi diagnosis pasti."]
        ];

        foreach ($history as $chat) {
            $messages[] = [
                'role' => $chat->sender === 'user' ? 'user' : 'assistant',
                'content' => $chat->message
            ];
        }

        // Tembak Groq API
        try {
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => env('GROQ_VISION_MODEL', 'qwen/qwen3.8-27b'),
                    'messages' => $messages,
                    'temperature' => 0.5,
                    'max_tokens' => 600,
                ]);

            if ($response->failed()) {
                Log::error('Groq Chat Failed: ' . $response->body());
                $aiReply = '⚠️ Gagal menghubungi AI. (Error API)';
            } else {
                $aiReply = $response->json('choices.0.message.content') ?? 'Maaf, saya tidak bisa menjawab saat ini.';
            }

        } catch (\Exception $e) {
            Log::error('Groq Chat Exception: ' . $e->getMessage());
            $aiReply = '⚠️ Gagal menghubungi AI. (Koneksi Timeout)';
        }

        // Simpan balasan AI
        Chat::create([
            'scan_id' => $scan->id,
            'sender' => 'ai',
            'message' => $aiReply
        ]);

        return response()->json(['reply' => $aiReply]);
    }
}