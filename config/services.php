<?php

return [

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'groq' => [
        'key'         => env('GROQ_API_KEY'),
        'model'       => env('GROQ_VISION_MODEL', 'qwen/qwen3.8-27b'),
        'timeout'     => (int) env('GROQ_TIMEOUT', 30),
        'max_tokens'  => (int) env('GROQ_MAX_TOKENS', 800),
        'temperature' => (float) env('GROQ_TEMPERATURE', 0.4),
        'base_url'    => 'https://api.groq.com/openai/v1',
    ],

    'ai_service' => [
        'url'     => env('AI_SERVICE_URL', 'http://127.0.0.1:8001'),
        'token'   => env('AI_SERVICE_TOKEN'),
        'timeout' => (int) env('AI_SERVICE_TIMEOUT', 15),
    ],

];