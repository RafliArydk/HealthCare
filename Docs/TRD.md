# Technical Requirements Document (TRD)

## HealthCare — Hybrid AI

**Versi:** 2.1
**Referensi:** PRD 2.1 dan Proposal HealthCare, 27 Oktober 2026

## 1. Arsitektur Target

```text
Browser → Laravel 13 Web/Orchestrator → MySQL
                  │
                  ▼
          Python FastAPI AI Service
          preprocessing → MobileNetV2 → label + confidence
                                      │ > 0.70 dan label valid
                                      ▼
                                  Groq API
```

Kondisi saat ini: `ScanController` masih mengirim gambar langsung ke Groq. FastAPI, CNN, dan confidence gate belum tersedia.

## 2. Stack Teknologi

| Layer | Teknologi |
|---|---|
| Web/backend | PHP 8.3+, Laravel 13 |
| UI | Blade, Tailwind CSS, Alpine.js, Vite |
| Database | MySQL; SQLite untuk eksperimen/test lokal |
| AI service | Python 3.10+, FastAPI, Uvicorn |
| Vision model | TensorFlow/Keras, MobileNetV2 transfer learning, 224×224 |
| LLM | Groq OpenAI-compatible API |
| Storage | Laravel public disk |

## 3. Struktur Target

```text
HealthCare-app/
├── app/ config/ database/ public/ resources/ routes/ tests/
├── ai-service/
│   ├── app/main.py
│   ├── app/predictor.py
│   ├── app/schemas.py
│   ├── models/
│   ├── requirements.txt
│   └── README.md
└── Docs/
```

## 4. Kontrak API Internal

`POST /api/v1/predict` menerima multipart field `file`, maksimal 10 MB.

```json
{
  "label": "luka",
  "confidence_score": 0.87,
  "model_version": "mobilenetv2-v1"
}
```

Label wajib `luka`, `obat`, atau `tidak_relevan`. Laravel harus menolak response yang tidak sesuai schema.

Alur Laravel: validasi → panggil FastAPI → reject bila label tidak relevan/skor `<= 0.70` → simpan gambar → susun prompt → panggil Groq → tambahkan disclaimer → simpan dan tampilkan.

## 5. Schema Data Target

Sudah ada: `users`, `scans`, `chats`. Tambahkan ke `scans` secara migration baru:

```text
cnn_label string nullable
confidence_score decimal(5,4) nullable
model_version string nullable
status enum(pending, accepted, rejected, failed)
error_code string nullable
```

Tabel target `audit_logs`: `id`, `user_id`, `scan_id`, `event_type`, `metadata` JSON, timestamps.

Semua query riwayat wajib membatasi `user_id` dari session. Jangan menghapus data lama secara destruktif.

## 6. Konfigurasi

```env
GROQ_API_KEY=isi_di_file_lokal_saja
GROQ_VISION_MODEL=qwen/qwen3.8-27b
GROQ_TIMEOUT=30
GROQ_MAX_TOKENS=800
GROQ_TEMPERATURE=0.4
AI_SERVICE_URL=http://127.0.0.1:8001
AI_SERVICE_TOKEN=token_lokal
```

Gunakan `config('services.groq.*')`, bukan `env()` langsung di controller. `.env` tidak boleh di-commit.

## 7. Non-Functional Requirements

| ID | Requirement | Target |
|---|---|---|
| NFR-01 | P95 scan end-to-end | ≤ 5 detik bila layanan tersedia |
| NFR-02 | Upload | Maksimal 10 MB |
| NFR-03 | Keamanan | CSRF, auth, ownership, rate limit, secret server-side |
| NFR-04 | Keselamatan | Tidak ada bypass confidence gate |
| NFR-05 | Error eksternal | Timeout dan 4xx/5xx ditangani aman |
| NFR-06 | Kompatibilitas | Browser modern dan mobile responsive |

## 8. Keamanan dan Error

- Lindungi route scan/chat dengan `auth` dan cek pemilik scan.
- Tambahkan rate limit untuk scan dan chat.
- Escape output AI sebelum dirender.
- Jangan log API key, gambar mentah, atau data sensitif.
- Gunakan token internal Laravel–FastAPI.
- Audit `SCAN_REJECTED`, `SCAN_ACCEPTED`, `AI_FAILED`, dan `CHAT_SENT`.
- File invalid → 422 tanpa panggilan AI; FastAPI timeout → failed; Groq 401/429/5xx → pesan aman tanpa secret.
- Kondisi darurat wajib dirujuk ke tenaga medis/UGD.
