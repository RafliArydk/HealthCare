📘 TECHNICAL REQUIREMENTS DOCUMENT (TRD)
HealthCare — Vision Chatbot Deteksi Luka & Obat
Versi: 1.0
Referensi PRD: PRD v2.0 (Edisi Integrasi Groq API – LLaMA Vision)
Status: Draft — untuk Review

1. Ringkasan Teknis
TRD ini menjabarkan spesifikasi teknis untuk membangun aplikasi HealthCare sesuai PRD v2.0. Fokus utama:

Integrasi Groq API (LLaMA 3.2 Vision) via Laravel HTTP Client dengan format OpenAI-Compatible.

Keamanan API Key di sisi server (.env + Controller).

Handling multimodal input (teks + gambar Base64).

Frontend ringan (Blade + Bootstrap 5 + vanilla JS, tanpa framework JS tambahan).

2. Arsitektur Sistem
2.1 Diagram Arsitektur (High-Level)
text
┌──────────────┐    HTTPS     ┌──────────────────────┐    HTTPS    ┌──────────────────┐
│   Browser    │ ───────────▶ │  Laravel App (MVC)    │ ──────────▶ │   Groq API       │
│ (Blade + JS) │              │  ┌────────────────┐   │             │  (LLaMA Vision)  │
│              │ ◀─────────── │  │ ChatController │   │ ◀────────── │                  │
└──────────────┘   JSON       │  └────────────────┘   │   JSON      └──────────────────┘
                              │        │              │
                              │   .env (API Key)      │
                              └──────────────────────┘
2.2 Pola Arsitektur
MVC — View (Blade), Controller (ChatController), Model tidak dipakai (tanpa database di MVP).

Stateless — tidak ada session chat yang disimpan; setiap request independen.

Proxy Pattern — Laravel bertindak sebagai reverse proxy untuk menyembunyikan API Key Groq.

3. Tech Stack
Layer	Teknologi	Versi	Keterangan
Runtime	PHP	≥ 8.2	Wajib untuk Laravel 11
Framework	Laravel	10.x / 11.x	MVC, HTTP Client bawaan
Frontend	Blade + HTML5 + CSS3	—	Server-rendered
CSS Framework	Bootstrap	5.3.x	CDN
Ikon	Bootstrap Icons	1.11.x	CDN
JS	Vanilla JS (ES6)	—	Fetch API, tanpa build tool
AI Provider	Groq API	OpenAI-compatible	POST /openai/v1/chat/completions
Model	llama-3.2-11b-vision-preview (default)	—	Fallback: llama-3.2-90b-vision-preview
Web Server	Nginx / Apache	—	Production
Dev Env	Laravel Sail / php artisan serve	—	Local dev
4. Komponen Sistem
4.1 Komponen Backend
Komponen	Deskripsi
routes/web.php	Definisi GET / (view) & POST /chat (AJAX)
ChatController@index	Render halaman chat.blade.php
ChatController@send	Validasi → encode Base64 → call Groq API → return JSON
config/services.php	(Opsional) menyimpan config Groq agar tidak panggil env() langsung
4.2 Komponen Frontend
Komponen	Deskripsi
layouts/app.blade.php	Layout global (navbar, meta, asset)
chat.blade.php	UI chat: bubble, input, preview gambar
public/css/healthcare.css	Style sky-blue theme
Inline <script>	Handler fetch(), preview gambar, render bubble, typing indicator
5. API Specification (Internal + Eksternal)
5.1 Endpoint Internal
POST /chat
Purpose: Kirim pesan + gambar ke AI, terima balasan.

Request (multipart/form-data):

Field	Tipe	Wajib	Constraint
text	string	❌	max 1000 char
image	file	❌ (salah satu wajib)	image/*, max 4 MB
Headers:

X-CSRF-TOKEN (wajib)

Accept: application/json

Response 200 (success):

json
{
  "reply": "<p>Jenis luka: ...</p>"
}
Response 200 (soft error dari Groq):

json
{
  "reply": "⚠️ Gagal menghubungi AI: <pesan error>"
}
Response 422 (validasi gagal):

json
{ "message": "...", "errors": { "image": ["..."] } }
5.2 Endpoint Eksternal — Groq API
Base URL: https://api.groq.com/openai/v1
Endpoint: POST /chat/completions
Auth: Authorization: Bearer ${GROQ_API_KEY}

Request payload (format OpenAI-compatible):

json
{
  "model": "llama-3.2-11b-vision-preview",
  "messages": [
    { "role": "system", "content": "<system prompt>" },
    {
      "role": "user",
      "content": [
        { "type": "text", "text": "..." },
        {
          "type": "image_url",
          "image_url": { "url": "data:image/jpeg;base64,..." }
        }
      ]
    }
  ],
  "temperature": 0.4,
  "max_tokens": 800
}
Response (ringkas):

json
{
  "choices": [
    { "message": { "content": "<jawaban AI>" } }
  ]
}
6. Alur Data (Sequence Diagram)
6.1 Flow Utama — Kirim Gambar Luka
text
User          Browser                Laravel (ChatController)         Groq API
 │                │                         │                            │
 │ pilih gambar   │                         │                            │
 │───────────────▶│                         │                            │
 │                │ preview lokal           │                            │
 │ tulis teks     │                         │                            │
 │ tekan Kirim    │                         │                            │
 │───────────────▶│                         │                            │
 │                │ POST /chat (FormData)   │                            │
 │                │────────────────────────▶│                            │
 │                │                         │ validasi (image, size)     │
 │                │                         │ file → base64 + mime       │
 │                │                         │ POST /chat/completions     │
 │                │                         │───────────────────────────▶│
 │                │                         │                            │ inferensi
 │                │                         │◀───────────────────────────│
 │                │                         │ ekstrak choices[0].message │
 │                │◀────────────────────────│ return JSON { reply }      │
 │                │ render bubble + disclaim│                            │
 │◀───────────────│                         │                            │
6.2 Flow Error — Gambar > 4 MB
Frontend: imageInput.onchange cek file.size > 4MB → alert + reset (tidak kirim).

Backend (jika bypass frontend): validasi max:4096 → HTTP 422.

6.3 Flow Error — Groq Timeout / 5xx
Http::timeout(30) → catch exception / $response->failed().

Return JSON { reply: "⚠️ ..." } dengan status 200 (agar tetap tampil di bubble).

7. Spesifikasi Fungsional-Teknis (Trace ke PRD)
PRD ID	Implementasi Teknis
FR-01 Input multimodal	FormData: text + image; JS validasi file client-side
FR-02 Auto-routing konteks	Ditangani system prompt — tidak ada klasifikasi manual di server
FR-03 Analisis luka	System prompt mewajibkan 4 output (jenis, kondisi, P3K, tanda bahaya)
FR-04 Analisis obat	System prompt mewajibkan 4 output (nama, indikasi, aturan pakai, efek samping)
FR-05 Disclaimer	Dua lapis: (1) di system prompt AI, (2) hardcoded di frontend appendAIMessage()
NFR-01 API Key aman	env('GROQ_API_KEY') hanya di ChatController; tidak diekspos ke JS
NFR-02 Optimasi gambar	Validasi max:4096 (KB) + Base64 encoding sebelum kirim
NFR-03 <5 detik	Groq LPU + temperature:0.4 + max_tokens:800
8. Skema Konfigurasi (.env)
env
# Wajib
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxx
GROQ_VISION_MODEL=llama-3.2-11b-vision-preview

# Opsional (future)
GROQ_TIMEOUT=30
GROQ_MAX_TOKENS=800
GROQ_TEMPERATURE=0.4
Best practice: setelah stabil, pindahkan ke config/services.php:

php
'groq' => [
    'key'   => env('GROQ_API_KEY'),
    'model' => env('GROQ_VISION_MODEL', 'llama-3.2-11b-vision-preview'),
],
Akses via config('services.groq.key') (mendukung php artisan config:cache).

9. Keamanan (Security Requirements)
ID	Requirement	Implementasi
SEC-01	API Key tidak terekspos client	Hanya di Controller + .env
SEC-02	CSRF protection	@csrf / meta tag + header X-CSRF-TOKEN
SEC-03	Validasi input ketat	validate() — text:string|max:1000, image:image|max:4096
SEC-04	Rate limiting	Route::middleware('throttle:10,1') → 10 req/menit (cegah abuse API Groq)
SEC-05	Sanitasi output AI	e() (escape HTML) sebelum nl2br() di sisi server
SEC-06	HTTPS only	Redirect HTTP → HTTPS di production
SEC-07	Header keamanan	X-Frame-Options: DENY, X-Content-Type-Options: nosniff
SEC-08	.env tidak ter-commit	.gitignore wajib
10. Non-Functional Requirements (Terukur)
ID	Metrik	Target	Cara Ukur
PERF-01	Latensi end-to-end	≤ 5 detik (p95)	Log microtime() di Controller
PERF-02	Payload gambar	≤ 4 MB	Validasi server + client
PERF-03	Ukuran response JSON	≤ 20 KB	Log
AVAIL-01	Uptime	≥ 99% (best effort, bergantung Groq)	Monitoring
SCALE-01	Concurrency	20 req/detik (Groq free-tier limit)	throttle
COMPAT-01	Browser	Chrome/Edge/Firefox/Safari versi terbaru	Manual test
COMPAT-02	Mobile responsive	Breakpoint ≤ 576px	Bootstrap grid
11. Error Handling Matrix
Skenario	Deteksi	Aksi Sistem	Pesan ke User
User kirim kosong	JS + backend	Block request	(tidak tampil)
Gambar > 4 MB	Client + server	Reject	"Ukuran gambar maksimal 4 MB"
Format bukan gambar	Validasi image	422	"File harus berupa gambar"
Groq 401	$response->failed()	Return soft error	"⚠️ Gagal menghubungi AI: invalid API key"
Groq 429 (rate limit)	$response->status() === 429	Return soft error	"⚠️ Terlalu banyak permintaan, coba lagi"
Groq timeout	Http::timeout exception	Catch & return	"⚠️ Koneksi ke AI timeout"
Groq 5xx	$response->failed()	Return soft error	"⚠️ Server AI sedang gangguan"
Network client offline	fetch().catch()	Show error bubble	"⚠️ Terjadi kesalahan, coba lagi"
Gambar acak / tidak relevan	System prompt AI	AI menolak sopan	(dari AI)
12. Struktur Direktori (Referensi Implementasi)
text
healthcare-app/
├── app/
│   └── Http/Controllers/
│       └── ChatController.php
├── config/
│   └── services.php          # (opsional) config Groq
├── public/
│   └── css/
│       └── healthcare.css
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── chat.blade.php
├── routes/
│   └── web.php
├── .env                      # API Key (JANGAN commit)
├── .env.example              # Template
└── composer.json
13. Testing Strategy
Level	Cakupan	Tools
Unit	Base64 encoding, validasi payload	PHPUnit
Feature	POST /chat — 200, 422, soft error	PHPUnit + Http::fake()
Integration	Real call ke Groq (sandbox manual)	Manual / Postman
E2E	Kirim gambar → balasan muncul	Manual + browser
Browser compat	Chrome, Firefox, Safari, mobile	Manual
Test case wajib:

✅ Kirim gambar luka → AI balas 4 poin P3K.

✅ Kirim gambar obat → AI balas 4 poin obat.

✅ Kirim gambar acak → AI menolak sopan.

✅ Kirim > 4 MB → ditolak.

✅ Groq API key salah → soft error tampil.

✅ Tanpa gambar + tanpa teks → ditolak.

14. Deployment Checklist
□ .env production diisi GROQ_API_KEY asli
□ php artisan config:cache + route:cache + view:cache
□ APP_ENV=production, APP_DEBUG=false
□ HTTPS aktif (Let's Encrypt / Cloudflare)
□ Rate limit middleware aktif
□ Log rotation aktif (storage/logs)
□ Monitoring dasar (uptime + error log)
15. Batasan & Asumsi
Item	Catatan
Tidak ada database	Riwayat chat hilang saat refresh (sesuai MVP)
Tidak ada autentikasi	Aplikasi publik; rate limit jadi pengaman utama
Ketergantungan Groq	Jika Groq down → fitur AI mati (tidak ada fallback model)
Free-tier Groq	Rate limit & model bisa berubah kapan saja
Ukuran gambar	Base64 memperbesar payload ~33% dari file asli
Disclaimer AI	Tidak menggantikan diagnosis dokter — wajib ditampilkan
16. Roadmap Teknis (Out of Scope MVP)
Fase	Fitur	Perubahan Teknis
v2.1	Riwayat chat	Tambah MySQL + tabel conversations, messages
v2.2	Streaming response	SSE via response()->stream() + Groq stream: true
v2.3	Autentikasi	Laravel Breeze + rate limit per user
v2.4	Multi-bahasa	Locale switcher + system prompt dinamis
✅ Sign-off
Role	Nama	Tanggal
Product Owner	—	—
Tech Lead	—	—
QA	—	—