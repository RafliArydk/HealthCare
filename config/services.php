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

    // ===== TAMBAHAN GROQ AI =====
    'groq' => [
        'key'         => env('GROQ_API_KEY'),
        'model'       => env('GROQ_VISION_MODEL', 'llama-3.2-11b-vision-preview'),
        'timeout'     => (int) env('GROQ_TIMEOUT', 30),
        'max_tokens'  => (int) env('GROQ_MAX_TOKENS', 800),
        'temperature' => (float) env('GROQ_TEMPERATURE', 0.4),
        'base_url'    => 'https://api.groq.com/openai/v1',
    ],

];