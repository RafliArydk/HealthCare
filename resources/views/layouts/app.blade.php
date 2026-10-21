<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HealthCare — Vision Chatbot</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/healthcare.css') }}" rel="stylesheet">
</head>
<body>

    <nav class="hc-navbar">
        <div class="container d-flex align-items-center">
            <i class="bi bi-heart-pulse-fill hc-logo-icon"></i>
            <div class="ms-2">
                <div class="hc-brand">HealthCare</div>
                <div class="hc-brand-sub">Vision Chatbot · Deteksi Luka & Obat</div>
            </div>
        </div>
    </nav>

    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.9/dist/purify.min.js"></script>
    @stack('scripts')
</body>
</html>