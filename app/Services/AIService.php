<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * Mengirim gambar ke Python FastAPI untuk klasifikasi CNN
     */
    public function predictImage($imagePath)
    {
        $url = config('services.ai_service.url') . '/api/v1/predict';
        $token = config('services.ai_service.token');

        try {
            $response = Http::withHeaders([
                'x-ai-service-token' => $token,
            ])
            ->timeout(20)
            ->attach('file', file_get_contents($imagePath), 'image.jpg')
            ->post($url);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'label' => $response->json('label'),
                    'confidence' => $response->json('confidence_score'),
                    'model_version' => $response->json('model_version'),
                ];
            }

            Log::error('AI Service Error: ' . $response->body());
            return ['success' => false, 'message' => 'Gagal dari Python API.'];

        } catch (\Exception $e) {
            Log::error('AI Service Connection Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Layanan AI sedang offline.'];
        }
    }
}