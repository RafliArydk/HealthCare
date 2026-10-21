# 🧪 TESTING DOCUMENT (TEST PLAN & REPORT)
## HealthCare — Vision Chatbot Deteksi Luka & Obat

**Versi Dokumen:** 1.0
**Referensi:** PRD v2.0 · TRD v1.0 · Implementation Plan v1.0
**Fase Terkait:** F6 (Testing & QA)
**Status:** Ready for Execution

---

## 📑 DAFTAR ISI

1. [Tujuan & Ruang Lingkup](#1-tujuan--ruang-lingkup)
2. [Strategi Testing](#2-strategi-testing)
3. [Environment Testing](#3-environment-testing)
4. [Test Matrix — Functional](#4-test-matrix--functional)
5. [Test Matrix — Security](#5-test-matrix--security)
6. [Test Matrix — UI/UX](#6-test-matrix--uiux)
7. [Test Matrix — Performance](#7-test-matrix--performance)
8. [Test Matrix — Compatibility](#8-test-matrix--compatibility)
9. [Automated Test Suite](#9-automated-test-suite)
10. [Test Evidence Template](#10-test-evidence-template)
11. [Bug Report Template](#11-bug-report-template)
12. [Sign-Off](#12-sign-off)

---

## 1. TUJUAN & RUANG LINGKUP

### 1.1 Tujuan
Memverifikasi bahwa aplikasi **HealthCare** memenuhi seluruh requirement fungsional (FR) dan non-fungsional (NFR) yang didefinisikan dalam PRD v2.0 dan TRD v1.0, sebelum go-live.

### 1.2 Ruang Lingkup

| In-Scope ✅ | Out-of-Scope ❌ |
|---|---|
| Endpoint `GET /` dan `POST /chat` | Integrasi database |
| Integrasi Groq API (vision) | Multi-user / autentikasi |
| Validasi input (teks & gambar) | Streaming response |
| Security (CSRF, rate limit, key protection) | Dark mode |
| UI responsive & cross-browser | Aksesibilitas lanjutan (screen reader detail) |
| Error handling & fallback | Load test skala besar (>100 concurrent) |

### 1.3 Referensi Requirement

| ID | Requirement | Sumber |
|---|---|---|
| FR-01 s/d FR-05 | Functional | PRD §3 |
| NFR-01 s/d NFR-03 | Non-functional | PRD §4 |
| SEC-01 s/d SEC-08 | Security | TRD §9 |
| PERF / COMPAT / SCALE | Performance & compat | TRD §10 |

---

## 2. STRATEGI TESTING

### 2.1 Piramida Testing

```
        ▲
       ╱ ╲        E2E / Manual (12+ skenario)
      ╱───╲
     ╱─────╲      Integration (FE + BE + Groq)
    ╱───────╲
   ╱─────────╲    Feature (Laravel HTTP tests)
  ╱───────────╲
 ╱─────────────╲  Unit (helper, config)
╱───────────────╲
```

### 2.2 Level & Tools

| Level | Tools | Cakupan | Frekuensi |
|---|---|---|---|
| **Unit** | PHPUnit 10 | Helper, prompt, encoding | Setiap commit |
| **Feature** | PHPUnit + `Http::fake()` | Controller, validation, route | Setiap PR |
| **Integration** | Manual / Postman | Groq API real call | Pre-deploy |
| **E2E** | Manual browser | User flow lengkap | Pre-release |
| **Compatibility** | Manual device/browser | Chrome, Firefox, Safari, mobile | Pre-release |
| **Security** | Manual audit + DevTools | Key, CSRF, XSS, rate limit | Pre-release |

### 2.3 Entry & Exit Criteria

**Entry Criteria (siap mulai test):**
- [x] Kode F0–F5 selesai
- [x] `.env` lokal terisi API Key Groq asli
- [x] `php artisan serve` jalan
- [x] Route `GET /` dan `POST /chat` aktif

**Exit Criteria (lolos QA):**
- [ ] Semua automated test hijau (`php artisan test` → 0 failures)
- [ ] ≥95% manual test case = PASS
- [ ] Tidak ada bug severity **Critical** atau **High** terbuka
- [ ] Coverage requirement PRD 100% (FR-01 s/d FR-05)
- [ ] Security audit lolos

---

## 3. ENVIRONMENT TESTING

| Item | Spesifikasi |
|---|---|
| OS | (Local) Windows 11 / macOS / Ubuntu 22.04 |
| PHP | 8.2 / 8.3 |
| Laravel | 10.x / 11.x |
| Composer | 2.7+ |
| Browser | Chrome 129+, Firefox 130+, Edge 129+, Safari 17+ |
| Network | Minimum 5 Mbps (untuk kirim gambar) |
| Groq API | Free tier aktif |
| Test Tools | PHPUnit 10, Postman v11, Chrome DevTools |

---

## 4. TEST MATRIX — FUNCTIONAL

### 4.1 Halaman & Routing

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-01 | Akses halaman utama | `GET /` | Status 200, tampil UI chat + navbar | ⬜ |
| TC-F-02 | Navbar tampil | Buka `/` | Brand "HealthCare" + subtitle + ikon | ⬜ |
| TC-F-03 | Welcome bubble muncul | Buka `/` | Ada bubble AI "Halo! Saya HealthCare" | ⬜ |
| TC-F-04 | CSRF meta ada | Inspect head | `<meta name="csrf-token">` terisi | ⬜ |
| TC-F-05 | Asset CSS loaded | DevTools Network | `healthcare.css` status 200 | ⬜ |

### 4.2 Input Teks Saja

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-10 | Kirim teks saja | Ketik "Apa itu luka bakar?" → klik send | Bubble user tampil + AI balas | ⬜ |
| TC-F-11 | Teks kosong + klik send | Klik send tanpa isi apa pun | Tidak ada request (guard client) | ⬜ |
| TC-F-12 | Teks > 1000 char | Paste 1500 char → send | Server tolak 422 (validasi `max:1000`) | ⬜ |
| TC-F-13 | Teks dengan emoji | Kirim "Halo 👋" | AI balas normal | ⬜ |

### 4.3 Input Gambar — Luka

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-20 | Kirim foto luka bakar | Upload foto luka bakar + teks "Ini apa?" | AI reply: jenis, kondisi, P3K, tanda bahaya | ⬜ |
| TC-F-21 | Kirim foto luka lecet | Upload foto lecet | AI deteksi lecet + saran P3K | ⬜ |
| TC-F-22 | Kirim foto luka sayat | Upload foto luka sayat | AI deteksi sayat + saran P3K | ⬜ |
| TC-F-23 | Kirim gambar luka saja (tanpa teks) | Upload tanpa teks → send | AI tetap balas | ⬜ |
| TC-F-24 | Disclaimer pada jawaban luka | Setelah AI balas | Disclaimer merah tampil di bawah | ⬜ |

### 4.4 Input Gambar — Obat

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-30 | Kirim foto Panadol | Upload foto kemasan Panadol | AI sebut: nama, fungsi, aturan pakai, efek samping | ⬜ |
| TC-F-31 | Kirim foto obat generik | Upload foto paracetamol generik | AI ekstrak info sesuai | ⬜ |
| TC-F-32 | Kirim foto obat sirup | Upload botol sirup obat | AI deteksi bentuk sediaan | ⬜ |
| TC-F-33 | Disclaimer pada jawaban obat | Setelah AI balas | Disclaimer muncul | ⬜ |

### 4.5 Input Gambar — Acak/Tidak Relevan

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-40 | Kirim foto pemandangan | Upload foto gunung | AI menolak sopan + minta gambar luka/obat | ⬜ |
| TC-F-41 | Kirim foto makanan | Upload foto nasi goreng | AI menolak sopan | ⬜ |
| TC-F-42 | Kirim foto selfie | Upload foto wajah | AI menolak (bukan luka/obat) | ⬜ |
| TC-F-43 | Kirim screenshot teks | Upload screenshot chat | AI menolak sopan | ⬜ |

### 4.6 Preview & Manajemen Gambar

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-50 | Preview muncul saat pilih | Klik ikon image → pilih file | Preview thumbnail + tombol ✕ | ⬜ |
| TC-F-51 | Tombol ✕ menghapus preview | Setelah preview tampil → klik ✕ | Preview hilang, `imageInput.value` reset | ⬜ |
| TC-F-52 | Upload > 4 MB | Pilih file 5 MB | Alert "maksimal 4 MB" + tidak terkirim | ⬜ |
| TC-F-53 | Upload file non-image | Coba pilih `.txt` | File picker filter (accept) mencegah | ⬜ |
| TC-F-54 | Preview ter-reset setelah kirim | Kirim gambar → sukses | Preview hilang, input baru kosong | ⬜ |

### 4.7 Loading & Rendering

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-60 | Typing indicator muncul | Kirim pesan | 3 titik animasi bounce tampil | ⬜ |
| TC-F-61 | Loading hilang setelah balas | Setelah AI balas | Typing indicator hilang, diganti bubble | ⬜ |
| TC-F-62 | Auto-scroll ke bawah | Kirim 5+ pesan | Chat auto-scroll ke pesan terbaru | ⬜ |
| TC-F-63 | Bubble user rata kanan | Kirim pesan | Gradient sky-blue, rounded kanan-atas | ⬜ |
| TC-F-64 | Bubble AI rata kiri | AI balas | Putih border sky, rounded kiri-atas | ⬜ |
| TC-F-65 | Gambar user tampil di bubble | Kirim gambar | Thumbnail muncul dalam bubble | ⬜ |

### 4.8 Multi-turn Interaction

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-F-70 | Kirim 3 pesan berurutan | Kirim teks, gambar, teks | Semua balasan tampil berurutan | ⬜ |
| TC-F-71 | Refresh halaman | F5 setelah kirim | Chat reset (sesuai MVP — tanpa DB) | ⬜ |

---

## 5. TEST MATRIX — SECURITY

### 5.1 API Key Protection

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-01 | Key tidak di HTML | View Source halaman | Tidak ada string `gsk_...` | ⬜ |
| TC-S-02 | Key tidak di JS bundle | DevTools → Sources → cari "gsk_" | 0 hasil | ⬜ |
| TC-S-03 | Key tidak di Network tab | Inspect request/response | Tidak ada di payload/header | ⬜ |
| TC-S-04 | Key tidak di response JSON | `POST /chat` → cek JSON | Hanya field `reply` | ⬜ |
| TC-S-05 | Grep source code | `grep -r "GROQ_API_KEY" resources/ public/` | 0 hasil | ⬜ |
| TC-S-06 | `.env` tidak ter-commit | `git log --all -- .env` | Tidak ada | ⬜ |

### 5.2 CSRF Protection

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-10 | POST tanpa CSRF | `curl -X POST /chat` tanpa token | 419 (Page Expired) | ⬜ |
| TC-S-11 | POST dengan CSRF | Request via UI normal | 200 + reply | ⬜ |
| TC-S-12 | CSRF token expired | Idle 2 jam lalu kirim | 419 + user refresh (perilaku default) | ⬜ |

### 5.3 Rate Limiting

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-20 | Batas 10/menit | Kirim 11 request cepat | Request ke-11 → 429 | ⬜ |
| TC-S-21 | Reset setelah 1 menit | Kirim 11x → tunggu 60s → kirim 1x | Request ke-12 sukses | ⬜ |
| TC-S-22 | Pesan 429 user-friendly | Kena 429 | Frontend tampil error bubble, tidak crash | ⬜ |

### 5.4 Input Validation

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-30 | Teks > 1000 char | POST via curl dengan teks 1500 | 422 + errors | ⬜ |
| TC-S-31 | File bukan gambar | POST `.pdf` sebagai image | 422 | ⬜ |
| TC-S-32 | File > 4 MB | POST file 5 MB | 422 | ⬜ |
| TC-S-33 | Request tanpa field | POST kosong | JSON error / 422 | ⬜ |

### 5.5 XSS Prevention

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-40 | Script injection di teks | Kirim `<script>alert(1)</script>` | Tampil sebagai teks literal, tidak eksekusi | ⬜ |
| TC-S-41 | Script di response AI | Mock Groq return `<img onerror=...>` | Escaped sebelum render | ⬜ |
| TC-S-42 | HTML di nama file gambar | Upload file `<svg onload=...>` | Ditolak / diabaikan namanya | ⬜ |

### 5.6 Error Handling Groq

| ID | Test Case | Steps | Expected | Status |
|---|---|---|---|---|
| TC-S-50 | API key salah | Set key invalid di `.env` | Soft error "⚠️ Gagal menghubungi AI: invalid API key" | ⬜ |
| TC-S-51 | Groq timeout | Simulasi network slow (>30s) | Soft error timeout | ⬜ |
| TC-S-52 | Groq 500 error | Mock 500 | Soft error "server gangguan" | ⬜ |
| TC-S-53 | Groq 429 (rate limit vendor) | Kirim cepat ke Groq | Soft error rate limit | ⬜ |

---

## 6. TEST MATRIX — UI/UX

| ID | Test Case | Expected | Status |
|---|---|---|---|
| TC-U-01 | Warna sesuai palet | Navbar sky-blue, background `#f0f9ff` | ⬜ |
| TC-U-02 | Ikon tampil | Bootstrap Icons (heart, image, send) tampil | ⬜ |
| TC-U-03 | Font readable | Size ≥ 14px di mobile | ⬜ |
| TC-U-04 | Kontras warna WCAG AA | Cek via Lighthouse / DevTools | ⬜ |
| TC-U-05 | Tombol hover state | Tombol send scale + shadow | ⬜ |
| TC-U-06 | Placeholder input jelas | "Tulis pesan atau unggah gambar..." | ⬜ |
| TC-U-07 | Disclaimer merah terlihat jelas | Border-dashed + warna merah | ⬜ |
| TC-U-08 | Loading animasi smooth | 3 titik bounce tanpa lag | ⬜ |
| TC-U-09 | Auto-focus input | Buka halaman → input bisa langsung diketik | ⬜ |
| TC-U-10 | No console error | DevTools console bersih | ⬜ |

---

## 7. TEST MATRIX — PERFORMANCE

| ID | Test Case | Target | Cara Ukur | Status |
|---|---|---|---|---|
| TC-P-01 | Latency end-to-end | ≤ 5 detik (p95) | DevTools Network time | ⬜ |
| TC-P-02 | Size response JSON | ≤ 20 KB | DevTools Network size | ⬜ |
| TC-P-03 | Upload gambar 4 MB | ≤ 10 detik (dari klik sampai balas) | Stopwatch | ⬜ |
| TC-P-04 | Time to First Byte (TTFB) | ≤ 500 ms | DevTools | ⬜ |
| TC-P-05 | Page load < 2 detik | Full load | Lighthouse / DevTools | ⬜ |
| TC-P-06 | Lighthouse Performance | ≥ 90 | Chrome Lighthouse | ⬜ |

**Cara Ukur Latency (tambahkan sementara di Controller):**
```php
$start = microtime(true);
$response = Http::withToken(...)->post(...);
$latency = round((microtime(true) - $start) * 1000);
\Log::info("Groq latency: {$latency} ms");
```

---

## 8. TEST MATRIX — COMPATIBILITY

### 8.1 Browser

| Browser | Versi | TC-F-20 | TC-F-30 | TC-F-40 | TC-S-01 | Status |
|---|---|---|---|---|---|---|
| Chrome | 129+ | ⬜ | ⬜ | ⬜ | ⬜ | ⬜ |
| Firefox | 130+ | ⬜ | ⬜ | ⬜ | ⬜ | ⬜ |
| Edge | 129+ | ⬜ | ⬜ | ⬜ | ⬜ | ⬜ |
| Safari | 17+ | ⬜ | ⬜ | ⬜ | ⬜ | ⬜ |

### 8.2 Responsive

| Viewport | Device | Cek | Status |
|---|---|---|---|
| 375×667 | iPhone SE | Input tidak overflow, bubble max 82% | ⬜ |
| 390×844 | iPhone 14 | Layout proporsional | ⬜ |
| 768×1024 | iPad | Chat tetap center | ⬜ |
| 1440×900 | Desktop | Chat max-width 860px | ⬜ |
| 1920×1080 | Full HD | Sama seperti desktop | ⬜ |

---

## 9. AUTOMATED TEST SUITE

### 9.1 File Structure

```
tests/
├── Unit/
│   ├── ImageEncodingTest.php
│   └── SystemPromptTest.php
└── Feature/
    └── ChatControllerTest.php
```

### 9.2 `tests/Unit/ImageEncodingTest.php`

```php
<?php

namespace Tests\Unit;

use App\Http\Controllers\ChatController;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageEncodingTest extends TestCase
{
    public function test_encode_image_returns_data_uri_prefix(): void
    {
        $file = UploadedFile::fake()->image('luka.jpg', 100, 100);

        $controller = new ChatController();
        $reflection = new \ReflectionMethod($controller, 'encodeImage');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($controller, $file);

        $this->assertStringStartsWith('data:image/', $result);
        $this->assertStringContainsString(';base64,', $result);
    }

    public function test_encode_image_contains_valid_base64(): void
    {
        $file = UploadedFile::fake()->image('obat.png', 50, 50);

        $controller = new ChatController();
        $reflection = new \ReflectionMethod($controller, 'encodeImage');
        $reflection->setAccessible(true);

        $result = $reflection->invoke($controller, $file);
        $b64 = explode(';base64,', $result)[1];

        $this->assertNotFalse(base64_decode($b64, true));
    }
}
```

### 9.3 `tests/Unit/SystemPromptTest.php`

```php
<?php

namespace Tests\Unit;

use App\Http\Controllers\ChatController;
use Tests\TestCase;

class SystemPromptTest extends TestCase
{
    private function getPrompt(): string
    {
        $controller = new ChatController();
        $reflection = new \ReflectionProperty($controller, 'systemPrompt');
        $reflection->setAccessible(true);
        return $reflection->getValue($controller);
    }

    public function test_prompt_mentions_wound_care(): void
    {
        $prompt = $this->getPrompt();
        $this->assertStringContainsStringIgnoringCase('luka', $prompt);
        $this->assertStringContainsStringIgnoringCase('P3K', $prompt);
    }

    public function test_prompt_mentions_medication(): void
    {
        $prompt = $this->getPrompt();
        $this->assertStringContainsStringIgnoringCase('obat', $prompt);
        $this->assertStringContainsStringIgnoringCase('efek samping', $prompt);
    }

    public function test_prompt_instructs_to_reject_irrelevant_images(): void
    {
        $prompt = $this->getPrompt();
        $this->assertStringContainsStringIgnoringCase('tidak relevan', $prompt);
    }
}
```

### 9.4 `tests/Feature/ChatControllerTest.php`

```php
<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    public function test_index_returns_chat_view(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('chat');
    }

    public function test_send_rejects_empty_request(): void
    {
        $response = $this->postJson('/chat', []);
        $response->assertStatus(200);
        $response->assertJsonStructure(['reply']);
        $this->assertStringContainsString('Silakan kirim', $response->json('reply'));
    }

    public function test_send_rejects_oversize_image(): void
    {
        $file = UploadedFile::fake()->image('big.jpg')->size(5000); // 5 MB

        $response = $this->postJson('/chat', [
            'text'  => 'test',
            'image' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    public function test_send_rejects_non_image_file(): void
    {
        $file = UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf');

        $response = $this->postJson('/chat', [
            'text'  => 'test',
            'image' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['image']);
    }

    public function test_send_rejects_text_too_long(): void
    {
        $response = $this->postJson('/chat', [
            'text' => str_repeat('a', 1500),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['text']);
    }

    public function test_send_returns_ai_reply_on_success(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Jenis luka: lecet ringan. P3K: cuci air bersih.']],
                ],
            ], 200),
        ]);

        $response = $this->postJson('/chat', ['text' => 'Ini luka apa?']);

        $response->assertStatus(200);
        $this->assertStringContainsString('lecet', $response->json('reply'));
    }

    public function test_send_handles_groq_failure(): void
    {
        Http::fake([
            'api.groq.com/*' => Http::response(['error' => ['message' => 'Invalid API key']], 401),
        ]);

        $response = $this->postJson('/chat', ['text' => 'test']);

        $response->assertStatus(200);
        $this->assertStringContainsString('⚠️', $response->json('reply'));
    }

    public function test_send_handles_groq_timeout(): void
    {
        Http::fake([
            'api.groq.com/*' => function () {
                throw new \Illuminate\Http\Client\ConnectionException('Timeout');
            },
        ]);

        $response = $this->postJson('/chat', ['text' => 'test']);

        $response->assertStatus(200);
        $this->assertStringContainsString('⚠️', $response->json('reply'));
    }

    public function test_rate_limit_enforced(): void
    {
        Http::fake(['api.groq.com/*' => Http::response(['choices' => [['message' => ['content' => 'ok']]]], 200)]);

        for ($i = 0; $i < 10; $i++) {
            $this->postJson('/chat', ['text' => 'test']);
        }

        $response = $this->postJson('/chat', ['text' => 'test']);
        $response->assertStatus(429);
    }
}
```

### 9.5 Menjalankan Test

```bash
# Semua test
php artisan test

# Hanya unit
php artisan test --testsuite=Unit

# Hanya feature
php artisan test --testsuite=Feature

# File tertentu
php artisan test tests/Feature/ChatControllerTest.php

# With coverage (butuh Xdebug)
php artisan test --coverage
```

### 9.6 Expected Output

```
   PASS  Tests\Unit\ImageEncodingTest
  ✓ encode image returns data uri prefix
  ✓ encode image contains valid base64

   PASS  Tests\Unit\SystemPromptTest
  ✓ prompt mentions wound care
  ✓ prompt mentions medication
  ✓ prompt instructs to reject irrelevant images

   PASS  Tests\Feature\ChatControllerTest
  ✓ index returns chat view
  ✓ send rejects empty request
  ✓ send rejects oversize image
  ✓ send rejects non image file
  ✓ send rejects text too long
  ✓ send returns ai reply on success
  ✓ send handles groq failure
  ✓ send handles groq timeout
  ✓ rate limit enforced

  Tests:    13 passed (24 assertions)
  Duration: 2.15s
```

---

## 10. TEST EVIDENCE TEMPLATE

Untuk setiap test case, simpan bukti di `docs/test-evidence/`.

### 10.1 Struktur Folder

```
docs/test-evidence/
├── TC-F-20_luka-bakar.png
├── TC-F-30_panadol.png
├── TC-S-01_no-key-in-source.png
├── TC-P-01_latency.png
└── ...
```

### 10.2 Format Nama File
`{TC-ID}_{deskripsi-singkat}.png`

### 10.3 Template Catatan per TC

```markdown
### TC-F-20 — Kirim Foto Luka Bakar
- **Tanggal:** 2026-10-21
- **Tester:** [Nama]
- **Browser:** Chrome 129
- **Input:** foto luka bakar (luka-bakar.jpg, 1.2 MB) + teks "Ini apa?"
- **Hasil:** ✅ PASS
- **Catatan:** AI mendeteksi "luka bakar derajat 1", P3K sesuai, disclaimer tampil.
- **Evidence:** `TC-F-20_luka-bakar.png`
```

---

## 11. BUG REPORT TEMPLATE

Setiap bug yang ditemukan dicatat dengan format:

```markdown
## BUG-XXX — [Judul singkat]

**Severity:** Critical / High / Medium / Low
**Priority:** P0 / P1 / P2 / P3
**Status:** Open / In Progress / Fixed / Closed
**Test Case:** TC-XX-XX
**Environment:** Chrome 129 / PHP 8.2 / Laravel 11

### Steps to Reproduce
1. ...
2. ...
3. ...

### Expected
...

### Actual
...

### Evidence
- Screenshot: `bugs/BUG-XXX.png`
- Console log: `...`
- Network log: `...`

### Suggested Fix
...
```

### 11.1 Severity Definition

| Severity | Definisi | Contoh |
|---|---|---|
| **Critical** | Aplikasi tidak bisa dipakai sama sekali | Halaman white screen, endpoint 500 permanen |
| **High** | Fitur inti rusak | Gambar tidak bisa dikirim, AI tidak balas |
| **Medium** | Fitur berjalan tapi ada cacat | Disclaimer tidak muncul, loading nyangkut |
| **Low** | Kosmetik / typo | Warna sedikit off, teks typo |

### 11.2 Contoh Bug (fiktif)

```markdown
## BUG-001 — Preview gambar tidak hilang setelah kirim

**Severity:** Medium
**Priority:** P2
**Status:** Open
**Test Case:** TC-F-54

### Steps
1. Buka halaman `/`
2. Pilih gambar → preview tampil
3. Klik tombol send

### Expected
Preview gambar + thumbnail di input bar hilang.

### Actual
Preview masih tampil meski pesan sudah terkirim.

### Evidence
`bugs/BUG-001.png`

### Suggested Fix
Pastikan `previewWrap.style.display = 'none'` dipanggil di handler `form.onsubmit` setelah reset.
```

---

## 12. SIGN-OFF

### 12.1 Ringkasan Hasil

| Kategori | Total | PASS | FAIL | BLOCKED | Coverage |
|---|---|---|---|---|---|
| Functional (TC-F-*) | 25 | __ | __ | __ | __% |
| Security (TC-S-*) | 22 | __ | __ | __ | __% |
| UI/UX (TC-U-*) | 10 | __ | __ | __ | __% |
| Performance (TC-P-*) | 6 | __ | __ | __ | __% |
| Compatibility | 12 | __ | __ | __ | __% |
| Automated | 13 | __ | __ | __ | __% |
| **TOTAL** | **88** | __ | __ | __ | __% |

### 12.2 Gate Kriteria Go-Live

- [ ] **Automated test** hijau (`php artisan test`)
- [ ] **≥95% manual test** PASS
- [ ] **0 bug Critical/High** terbuka
- [ ] **Security audit** (TC-S-*) semua PASS
- [ ] **Performance** latency p95 ≤ 5 detik
- [ ] **Compatibility** ≥3 browser PASS

### 12.3 Approval

| Role | Nama | Tanggal | Tanda Tangan |
|---|---|---|---|
| QA Lead | ______________ | ________ | ________ |
| Tech Lead | ______________ | ________ | ________ |
| Product Owner | ______________ | ________ | ________ |

---

## 📌 QUICK COMMAND REFERENCE

```bash
# Jalankan semua test
php artisan test

# Test dengan coverage
php artisan test --coverage

# Manual test environment
php artisan serve

# Cek route aktif
php artisan route:list

# Bersihkan cache test
php artisan config:clear && php artisan cache:clear

# Grep API key di source
grep -r "gsk_" resources/ public/ app/Http/Controllers/

# Cek log error production
tail -f storage/logs/laravel.log | grep -i error
```