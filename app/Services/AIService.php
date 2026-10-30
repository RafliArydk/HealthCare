<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * Mengirim gambar ke Python FastAPI untuk klasifikasi CNN
     *
     * @return array{success: bool, label?: string, confidence?: float, model_version?: string, message?: string}
     */
    public function predictImage(string $imagePath): array
    {
        $url = config('services.ai_service.url').'/api/v1/predict';
        $token = config('services.ai_service.token');

        try {
            $response = Http::withHeaders([
                'x-ai-service-token' => $token,
            ])
                ->connectTimeout(3)
                ->timeout(config('services.ai_service.timeout'))
                ->attach('file', file_get_contents($imagePath), 'image.jpg')
                ->post($url);

            if ($response->successful()
                && is_string($response->json('label'))
                && is_numeric($response->json('confidence_score'))
                && is_string($response->json('model_version'))) {
                return [
                    'success' => true,
                    'label' => $response->json('label'),
                    'confidence' => (float) $response->json('confidence_score'),
                    'model_version' => $response->json('model_version'),
                ];
            }

            Log::error('AI Service returned an invalid response.', [
                'status' => $response->status(),
            ]);

            return ['success' => false, 'message' => 'Gagal dari Python API.'];

        } catch (\Throwable $e) {
            Log::error('AI Service connection failed.', [
                'exception' => $e,
            ]);

            return ['success' => false, 'message' => 'Layanan AI sedang offline.'];
        }
    }
}
