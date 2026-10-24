🗺️ IMPLEMENTATION PLAN (LENGKAP & DETAIL)
HealthCare — Vision Chatbot Deteksi Luka & Obat
Referensi: PRD v2.0 + TRD v1.0
Estimasi Total: 8–10 hari kerja
Metode: Iteratif per fase, dengan definition of done di setiap fase

📊 RINGKASAN FASE
Fase	Nama	Estimasi	Deliverable Utama
F0	Setup & Environment	0.5 hari	Proyek Laravel siap jalan
F1	Backend Foundation	1 hari	Route, Controller, Config
F2	Groq API Integration	1.5 hari	Endpoint /chat fungsional
F3	Frontend Layout & UI	1.5 hari	Halaman chat sky-blue
F4	Frontend JS Logic	1.5 hari	Interaksi kirim/terima pesan
F5	Security & Error Handling	1 hari	Rate limit, validasi, fallback
F6	Testing & QA	1.5 hari	Test suite + manual test
F7	Deployment & Go-Live	1 hari	Aplikasi live di server
F8	Post-Launch Monitoring	0.5 hari	Monitoring dashboard + log
TOTAL		~9.5 hari	
🚀 FASE 0 — SETUP & ENVIRONMENT
Durasi: 0.5 hari · Dependensi: —

🎯 Tujuan
Menyiapkan environment lokal dan kerangka proyek Laravel.

✅ Tasks
0.1 Prasyarat
□ Install PHP ≥ 8.2 → verifikasi: php -v
□ Install Composer terbaru → composer -V
□ Install Node.js ≥ 18 (opsional, hanya untuk asset build) → node -v
□ Install Git → git --version
□ Siapkan editor (VS Code) + extension: PHP Intelephense, Laravel Blade, Laravel Snippets
□ Daftar akun Groq Console (https://console.groq.com) → generate API Key
□ Simpan API Key di password manager (jangan share)
0.2 Inisialisasi Proyek
bash
composer create-project laravel/laravel healthcare-app
cd healthcare-app
□ Proyek ter-create
□ php artisan serve berjalan → cek http://127.0.0.1:8000
0.3 Konfigurasi .env
□ Salin .env.example → .env (otomatis dari composer)
□ Set APP_NAME=HealthCare
□ Set APP_ENV=local, APP_DEBUG=true
□ Generate key: php artisan key:generate
□ Tambahkan:
env
GROQ_API_KEY=gsk_xxxxxxxxxxxx
GROQ_VISION_MODEL=llama-3.2-11b-vision-preview
GROQ_TIMEOUT=30
GROQ_MAX_TOKENS=800
GROQ_TEMPERATURE=0.4
□ Verifikasi .gitignore sudah include .env
0.4 Struktur Direktori
□ Buat public/css/ jika belum ada
□ Buat resources/views/layouts/ jika belum ada
📦 Deliverable
Proyek Laravel berjalan

.env terisi API Key Groq

Repo Git terinisialisasi (git init + first commit)

✅ Definition of Done
bash
php artisan serve
# → http://127.0.0.1:8000 tampil welcome page Laravel
🧱 FASE 1 — BACKEND FOUNDATION
Durasi: 1 hari · Dependensi: F0

🎯 Tujuan
Menyiapkan route, controller skeleton, dan config layer.

✅ Tasks
1.1 Config Layer
□ Edit config/services.php — tambahkan:
php
'groq' => [
    'key'           => env('GROQ_API_KEY'),
    'model'         => env('GROQ_VISION_MODEL', 'llama-3.2-11b-vision-preview'),
    'timeout'       => env('GROQ_TIMEOUT', 30),
    'max_tokens'    => env('GROQ_MAX_TOKENS', 800),
    'temperature'   => env('GROQ_TEMPERATURE', 0.4),
],
□ Test: php artisan config:cache sukses tanpa error
1.2 Route
□ Edit routes/web.php:
php
use App\Http\Controllers\ChatController;

Route::get('/',  [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat', [ChatController::class, 'send'])
    ->middleware('throttle:10,1')
    ->name('chat.send');
□ Verifikasi: php artisan route:list menampilkan 2 route
1.3 Controller Skeleton
□ Generate: php artisan make:controller ChatController
□ Isi method index() → return view('chat')
□ Isi method send() → placeholder return response()->json(['reply' => 'dummy']);
□ Test via Postman/curl: POST /chat → dapat { "reply": "dummy" }
1.4 View Placeholder
□ Buat resources/views/chat.blade.php dengan teks "Hello HealthCare"
□ Test: akses / → lihat teks
📦 Deliverable
Route terdefinisi (2 endpoint)

ChatController skeleton berjalan

Config layer Groq terpasang

✅ Definition of Done
bash
curl -X POST http://127.0.0.1:8000/chat -H "Accept: application/json"
# → {"reply":"dummy"}
🤖 FASE 2 — GROQ API INTEGRATION
Durasi: 1.5 hari · Dependensi: F1

🎯 Tujuan
Implementasi lengkap method send() — validasi, encode gambar, call Groq API, return response.

✅ Tasks
2.1 Validasi Request
□ Di ChatController@send() tambahkan:
php
$request->validate([
    'text'  => 'nullable|string|max:1000',
    'image' => 'nullable|image|max:4096',
]);
□ Guard: jika text kosong dan tidak ada image → return JSON error
□ Test: kirim POST kosong → 422 atau soft error
2.2 Base64 Encoding
□ Buat helper private function encodeImage(UploadedFile $file): string
php
private function encodeImage($file): string
{
    $b64  = base64_encode(file_get_contents($file->getRealPath()));
    $mime = $file->getMimeType();
    return "data:{$mime};base64,{$b64}";
}
□ Unit test: validasi output prefix data:image/...;base64,
2.3 System Prompt
□ Buat konstanta/properti $systemPrompt — sesuai TRD Section 6.1:
Cover: luka (4 poin), obat (4 poin), gambar acak (tolak), disclaimer

□ Verifikasi prompt memuat semua constraint PRD FR-03, FR-04, FR-05
2.4 Build Payload
□ Susun array $payload:
php
$userContent = [];
if ($request->filled('text')) {
    $userContent[] = ['type' => 'text', 'text' => $request->text];
}
if ($request->hasFile('image')) {
    $userContent[] = [
        'type'      => 'image_url',
        'image_url' => ['url' => $this->encodeImage($request->file('image'))],
    ];
}

$payload = [
    'model'       => config('services.groq.model'),
    'messages'    => [
        ['role' => 'system', 'content' => $this->systemPrompt],
        ['role' => 'user',   'content' => $userContent],
    ],
    'temperature' => (float) config('services.groq.temperature'),
    'max_tokens'  => (int)   config('services.groq.max_tokens'),
];
2.5 HTTP Call ke Groq
□ Implement Http::withToken(...)->timeout(...)->post(...):
php
$response = Http::withToken(config('services.groq.key'))
    ->timeout(config('services.groq.timeout'))
    ->acceptJson()
    ->post('https://api.groq.com/openai/v1/chat/completions', $payload);
2.6 Parse & Return Response
□ Cek $response->failed() → return soft error JSON
□ Ambil $response->json('choices.0.message.content')
□ Sanitasi: nl2br(e($reply))
□ Return: response()->json(['reply' => $reply])
2.7 Manual Test dengan Groq Asli
□ Test dengan gambar luka (foto lecet/luka bakar) → AI jawab 4 poin P3K
□ Test dengan gambar obat (foto kemasan Panadol dll) → AI jawab 4 poin
□ Test dengan gambar acak (foto pemandangan) → AI menolak sopan
□ Cek waktu respons (< 5 detik)
□ Simpan hasil test di docs/test-evidence.md
📦 Deliverable
ChatController@send() lengkap

Endpoint /chat fungsional end-to-end

Evidence test manual

✅ Definition of Done
bash
# Kirim gambar luka
curl -X POST http://127.0.0.1:8000/chat \
  -H "Accept: application/json" \
  -F "text=Luka ini apa?" \
  -F "image=@/path/luka.jpg"
# → {"reply":"<p>Jenis luka: ...</p>"}
🎨 FASE 3 — FRONTEND LAYOUT & UI
Durasi: 1.5 hari · Dependensi: F1

🎯 Tujuan
Membangun tampilan chat sky-blue responsive.

✅ Tasks
3.1 Layout Global
□ Buat resources/views/layouts/app.blade.php:
Meta CSRF token

CDN Bootstrap 5.3 + Bootstrap Icons 1.11

Link healthcare.css

Navbar gradient sky-blue

@yield('content') + @yield('scripts')

□ Test: buka halaman → navbar tampil
3.2 Halaman Chat
□ Buat resources/views/chat.blade.php extends layout
□ Struktur:
.hc-container (flex column full height)

.hc-chat (area scroll chat)

Bubble welcome AI (hardcoded)

.hc-preview-wrap (preview gambar terpilih)

.hc-inputbar (tombol image, text input, tombol send)

□ Tambahkan <form id="chatForm"> dengan enctype="multipart/form-data"
3.3 CSS Theme
□ Buat public/css/healthcare.css:
Variabel CSS (:root — palet sky-blue)

.hc-navbar gradient sky-500 → sky-700

.hc-bubble styling user vs AI

.hc-avatar bulat gradient

.hc-typing animasi bounce 3 titik

.hc-disclaimer border-dashed + merah

.hc-inputbar rounded-pill + shadow

.hc-preview-* preview gambar

Media query @media (max-width: 576px)

3.4 Ikon & Aksesibilitas
□ Semua tombol punya title atau aria-label
□ Kontras warna memenuhi WCAG AA (cek via DevTools)
□ Font-size minimum 14px mobile
3.5 Responsive Check
□ Desktop (1440px) → chat maks-width 860px
□ Tablet (768px) → tetap proporsional
□ Mobile (375px) → bubble max 82%, gambar max 160px, input full width
📦 Deliverable
Layout + halaman chat sky-blue

Style lengkap healthcare.css

Responsive di 3 breakpoint

✅ Definition of Done
Buka / → tampilan lengkap (navbar, welcome bubble, input bar)

Tidak ada console error

Preview di Chrome DevTools responsive 375px, 768px, 1440px

⚡ FASE 4 — FRONTEND JS LOGIC
Durasi: 1.5 hari · Dependensi: F2, F3

🎯 Tujuan
Interaksi kirim/terima pesan, preview gambar, loading indicator.

✅ Tasks
4.1 State & DOM Cache
□ Deklarasi selectedFile global
□ Cache semua getElementById di awal script
4.2 Preview Gambar
□ Handler imageInput.onchange:
Cek file.size > 4MB → alert + reset

Set previewImg.src = URL.createObjectURL(file)

Tampilkan previewWrap

□ Handler previewClose.onclick:
Reset selectedFile, imageInput.value, hide preview

4.3 Submit Handler
□ form.onsubmit:
e.preventDefault()

Guard: jika !text && !selectedFile → return

Render bubble user (appendUserMessage)

Render loading AI (appendLoading)

Build FormData dengan text + image

Reset input state

fetch(POST /chat) dengan X-CSRF-TOKEN

Handle response:

success → appendAIMessage(data.reply) + remove loading

error → append error bubble + remove loading

4.4 Helper Rendering
□ appendUserMessage(text, file) — bubble kanan, gradient sky
□ appendAIMessage(html) — bubble kiri + disclaimer wajib
□ appendLoading() — typing dots + return element (untuk .remove())
□ scrollBottom() — auto scroll chat
□ escapeHtml(s) — XSS prevention
4.5 Edge Cases
□ Kirim hanya gambar (tanpa teks) → tetap jalan
□ Kirim hanya teks (tanpa gambar) → tetap jalan
□ Kirim gambar 4.5 MB → alert client-side, tidak kirim
□ Batal pilih gambar → preview hilang, tidak terkirim
□ Double submit (klik 2x cepat) → guard dengan flag isLoading
4.6 Loading & UX
□ Tambahkan flag isLoading → disable tombol send selama request
□ Setelah response: re-enable + scroll bottom
📦 Deliverable
JS handler lengkap di chat.blade.php section @section('scripts')

Semua edge case tertangani

✅ Definition of Done
Kirim gambar luka via UI → loading dot muncul → balasan AI muncul

Disclaimer tampil di setiap bubble AI

Auto scroll berfungsi

Tidak ada error di console

🔒 FASE 5 — SECURITY & ERROR HANDLING
Durasi: 1 hari · Dependensi: F2, F4

🎯 Tujuan
Menerapkan SEC-01 s/d SEC-08 + error matrix TRD Section 11.

✅ Tasks
5.1 API Key & Environment
□ Audit: grep -r "GROQ_API_KEY" resources/ public/ → harus kosong (tidak ada key di client)
□ Pastikan env() hanya di config/services.php (bukan langsung di Controller)
5.2 CSRF
□ Cek meta tag: <meta name="csrf-token" content="{{ csrf_token() }}">
□ Cek fetch header X-CSRF-TOKEN
□ Test: POST tanpa CSRF → 419
5.3 Rate Limiting
□ Middleware throttle:10,1 sudah ada di route
□ Test: kirim 11 request cepat → response ke-11 = 429
□ Custom response 429 (opsional) → JSON { reply: "⚠️ Terlalu banyak permintaan, tunggu sebentar" }
Daftarkan di bootstrap/app.php atau RouteServiceProvider

5.4 Validasi Server
□ Konfirmasi validate() menolak:
File bukan gambar → 422

File > 4 MB → 422

text > 1000 char → 422

□ Test manual setiap kasus
5.5 Output Sanitasi
□ Verifikasi e($reply) sebelum nl2br()
□ Test: kirim input berisi <script>alert(1)</script> → tampil sebagai teks, bukan dieksekusi
5.6 Error Handling Groq
□ Bungkus call dengan try-catch
□ Handle $response->failed():
401 → log error + reply "invalid API key"

429 → reply "rate limit"

5xx → reply "server gangguan"

□ Handle exception (timeout, network) → catch → reply "timeout"
□ Log semua error ke storage/logs/laravel.log
5.7 Frontend Error
□ fetch().catch() → append bubble "⚠️ Terjadi kesalahan, coba lagi"
□ Response non-200 → parse JSON, tampilkan data.reply atau data.message
5.8 Security Headers (Opsional tapi direkomendasikan)
□ Tambahkan middleware header:
X-Frame-Options: DENY

X-Content-Type-Options: nosniff

Referrer-Policy: no-referrer

📦 Deliverable
Semua security requirement TRD terpenuhi

Error handling teruji

✅ Definition of Done
Tidak ada API key di client-side (DevTools Source/Network)

Test matrix error (TRD Section 11) → semua lolos

🧪 FASE 6 — TESTING & QA
Durasi: 1.5 hari · Dependensi: F2, F4, F5

🎯 Tujuan
Verifikasi seluruh requirement PRD & TRD via automated + manual test.

✅ Tasks
6.1 Unit Test (PHPUnit)
□ tests/Unit/ImageEncodingTest.php:
Test encodeImage() return prefix data:image/...

□ tests/Unit/SystemPromptTest.php:
Test prompt memuat keyword "P3K", "disclaimer", "efek samping"

bash
php artisan make:test --unit ImageEncodingTest
php artisan test --testsuite=Unit
6.2 Feature Test
□ tests/Feature/ChatControllerTest.php:
test_index_returns_view() — GET / status 200, view chat

test_send_rejects_empty_request() — POST tanpa data → JSON error

test_send_rejects_oversize_image() — file 5 MB → 422

test_send_rejects_non_image() — file .txt → 422

test_send_handles_groq_failure() — Http::fake(['*' => Http::response([], 500)]) → soft error

test_send_returns_ai_reply() — Http::fake dengan response valid → reply terisi

test_rate_limit_enforced() — 11 request → 429

bash
php artisan test --testsuite=Feature
6.3 Manual Test Matrix
#	Skenario	Ekspektasi	✅
1	Kirim foto luka bakar	4 poin P3K muncul + disclaimer	☐
2	Kirim foto obat (Panadol)	4 poin obat muncul + disclaimer	☐
3	Kirim foto pemandangan	AI tolak sopan	☐
4	Kirim teks saja	AI jawab berdasarkan teks	☐
5	Kirim gambar saja tanpa teks	AI jawab	☐
6	Upload > 4 MB	Alert client, tidak terkirim	☐
7	Upload bukan gambar	Validasi backend 422	☐
8	Klik kirim saat kosong	Tidak ada aksi	☐
9	Matikan koneksi → kirim	Error bubble muncul	☐
10	Kirim 11x cepat	Request 11 = 429	☐
11	Inspect Network → cari API key	Tidak ditemukan	☐
12	Respons time (p95)	< 5 detik	☐
6.4 Browser Compatibility
□ Chrome (latest) — full test
□ Edge (latest) — smoke test
□ Firefox (latest) — smoke test
□ Safari (jika tersedia) — smoke test
□ Chrome Mobile (DevTools) — responsive + submit
6.5 Responsive Test
□ 375×667 (iPhone SE) — input & bubble tidak overflow
□ 768×1024 (iPad) — layout proporsional
□ 1440×900 (Desktop) — chat center max 860px
6.6 Performance Test
□ Ukur respons end-to-end (DevTools Network → time)
□ Ukur content-length response < 20 KB
□ Log di Controller: Log::info('Groq latency: ' . $ms)
📦 Deliverable
Test suite PHPUnit (unit + feature) hijau

Manual test matrix terisi

Screenshot evidence di docs/test-evidence/

✅ Definition of Done
bash
php artisan test
# → Tests: XX passed
Semua baris matrix manual tercentang ✅

🚢 FASE 7 — DEPLOYMENT & GO-LIVE
Durasi: 1 hari · Dependensi: F6

🎯 Tujuan
Deploy aplikasi ke production dengan aman.

✅ Tasks
7.1 Pilih Hosting
□ Pilih provider (rekomendasi awal):
Railway.app (gratis tier, mudah)

Laravel Forge + DigitalOcean (VPS $6/bulan)

Shared hosting (cPanel, jika ada)

□ Pastikan support PHP 8.2+, HTTPS, Composer
7.2 Pre-Deploy Checklist
□ .env production terisi:
APP_ENV=production

APP_DEBUG=false

APP_URL=https://domain.com

GROQ_API_KEY= (asli)

□ .env TIDAK di-commit ke Git
□ storage/ & bootstrap/cache/ writable (755)
□ composer install --no-dev --optimize-autoloader
7.3 Optimize & Cache
bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
□ Semua cache sukses
7.4 HTTPS Setup
□ Aktifkan SSL (Let's Encrypt / Cloudflare)
□ Force HTTPS:
.htaccess atau Nginx redirect

Atau URL::forceScheme('https') di AppServiceProvider@boot

7.5 Deploy
□ Push ke Git
□ Deploy via provider (Railway auto / Forge / manual SSH)
□ Set permission:
bash
chmod -R 755 storage bootstrap/cache
7.6 Post-Deploy Verification
□ Buka https://domain.com → halaman chat tampil
□ Kirim gambar uji → AI balas
□ Cek storage/logs/laravel.log — tidak ada error
□ DevTools → tidak ada API key exposed
□ Response time < 5 detik
□ Test rate limit (11 request cepat)
7.7 Backup
□ Setup backup harian (jika pakai DB nanti)
□ Export .env ke password manager
□ Dokumentasi recovery di docs/runbook.md
📦 Deliverable
Aplikasi live di domain HTTPS

Dokumentasi runbook

Backup .env aman

✅ Definition of Done
URL production dapat diakses publik

Semua test manual F6 lolos di production

Log bersih

📈 FASE 8 — POST-LAUNCH MONITORING
Durasi: 0.5 hari (setup) + ongoing

🎯 Tujuan
Memastikan aplikasi stabil pasca-launch.

✅ Tasks
8.1 Log Monitoring
□ Akses storage/logs/laravel.log rutin
□ Setup log rotation (default Laravel sudah ada)
□ Cari keyword error: ERROR, Timeout, 429, 401
8.2 Uptime Monitoring
□ Daftarkan URL ke UptimeRobot (free) → cek tiap 5 menit
□ Setup notifikasi email jika down
8.3 Metrik Awal (Minggu 1)
□ Track: jumlah request/hari
□ Track: rata-rata latency
□ Track: error rate (%)
□ Track: rate limit hits (429)
□ Track: quota Groq usage (dari dashboard Groq)
8.4 Feedback User
□ Sediakan email/kontak feedback
□ Kumpulkan contoh: kasus AI tidak akurat / gambar gagal
□ Iterate system prompt jika perlu
8.5 Dokumen
□ Update README.md — cara run, env, deploy
□ Simpan CHANGELOG.md
📦 Deliverable
Monitoring aktif

Baseline metrik

Dokumentasi handover

📋 MILESTONE & DEPENDENCY GRAPH
text
F0 ──▶ F1 ──▶ F2 ──┐
        │          ├──▶ F5 ──▶ F6 ──▶ F7 ──▶ F8
        └──▶ F3 ──▶ F4 ──┘
Milestone	Trigger	Verifikasi
M1: Foundation Ready	F1 selesai	Endpoint dummy merespons
M2: AI Working	F2 selesai	Curl ke Groq dapat balasan
M3: UI Ready	F3 selesai	Halaman chat tampil
M4: MVP Functional	F4 selesai	Bisa kirim gambar via UI
M5: Secure	F5 selesai	Audit key + error matrix lolos
M6: QA Passed	F6 selesai	php artisan test hijau
M7: Live	F7 selesai	URL production aktif
M8: Monitored	F8 selesai	Uptime robot aktif
⚠️ RISK REGISTER
#	Risiko	Dampak	Probabilitas	Mitigasi
R1	Groq API key bocor	Tinggi (quota habis)	Rendah	Env-only, gitignore, audit F5.1
R2	Groq free-tier limit tiba-tiba	Fitur mati	Sedang	Fallback message + monitoring quota
R3	Model LLaMA Vision deprecated	Fitur rusak	Sedang	Config GROQ_VISION_MODEL via .env → swap tanpa deploy kode
R4	Gambar besar → timeout	UX buruk	Sedang	Validasi 4 MB + alert client
R5	Prompt injection via teks	AI keluar konteks	Rendah	System prompt tegas + escape output
R6	Latency > 5 detik	Frustasi user	Sedang	Model 11b > 90b; max_tokens:800; temperature:0.4
R7	Rate limit 429 tidak dikonfigurasi	Abuse	Rendah	throttle:10,1 (F5.3)
R8	Tidak ada DB → riwayat hilang	User keluhan	Rendah (MVP)	Out-of-scope Fase 2.1
R9	Foto mengandung wajah/PII	Privasi	Rendah	Disclaimer "jangan kirim foto identitas" di welcome bubble
R10	Deploy tanpa HTTPS	Security	Rendah	Force HTTPS di F7.4
🧾 DELIVERABLE CHECKLIST (SIAP SIGN-OFF)
Kode
□ app/Http/Controllers/ChatController.php
□ config/services.php (groq entry)
□ routes/web.php (2 route + throttle)
□ resources/views/layouts/app.blade.php
□ resources/views/chat.blade.php
□ public/css/healthcare.css
□ tests/Unit/ImageEncodingTest.php
□ tests/Feature/ChatControllerTest.php
Konfigurasi
□ .env.example (dengan placeholder)
□ .env production (di server, tidak di-commit)
□ .gitignore include .env
Dokumentasi
□ README.md (cara run + deploy)
□ docs/runbook.md
□ docs/test-evidence.md
□ CHANGELOG.md
Verifikasi
□ php artisan test → hijau
□ Manual test matrix (F6.3) → 12/12 ✅
□ Security audit (F5.1) → lolos
□ Production URL → dapat diakses
□ Uptime monitor → aktif
⏱️ TIMELINE REKOMENDASI (KALENDER)
Hari	Fokus	Output
H1	F0 + F1	Proyek siap, route ada
H2–H3	F2	Endpoint /chat live lokal
H4–H5	F3	UI sky-blue selesai
H6–H7	F4	Interaksi chat fungsional
H8	F5	Security pass
H9–H10	F6	Test hijau + QA
H11	F7	Deploy production
H12	F8	Monitoring + handover