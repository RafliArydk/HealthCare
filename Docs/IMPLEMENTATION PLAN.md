# Implementation Plan — HealthCare Hybrid AI

**Metode:** kerjakan satu fase sampai Definition of Done terpenuhi. Stabilkan Laravel dahulu, bangun AI service, pasang guardrail, lalu uji.

## Fase 0 — Persiapan dan baseline

**Estimasi:** 0,5–1 hari. Pastikan PHP 8.3+, Composer, Node, MySQL, Python 3.10+, Git terpasang.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
npm install
npm run build
php artisan storage:link
php artisan migrate
php artisan serve
```

Smoke test: register → login → dashboard → scan → chat. Buat baseline commit sebelum perubahan.

## Fase 1 — Rapikan baseline Laravel

**Estimasi:** 1–2 hari.

- Pindahkan konfigurasi Groq dari controller ke `config/services.php`.
- Tambahkan `AI_SERVICE_URL` dan `AI_SERVICE_TOKEN`.
- Perbaiki ownership agar user tidak dapat membuka scan user lain.
- Tambahkan status error scan dan tangani response Groq `failed()`.
- Pastikan disclaimer selalu ditambahkan.
- Tambahkan rate limit pada scan dan chat.

**DoD:** auth, upload, direct-Groq, history, dan chat lulus smoke test serta API key tidak tampil di browser.

## Fase 2 — Buat Python FastAPI service

**Estimasi:** 2–3 hari.

- Buat `ai-service/app/main.py`, `predictor.py`, `schemas.py`, `requirements.txt`.
- Buat `GET /health` dan `POST /api/v1/predict`.
- Awali dengan predictor dummy agar kontrak Laravel dapat diuji.
- Tambahkan validasi file, token internal, timeout, dan log aman.

```powershell
cd ai-service
python -m venv .venv
.venv\Scripts\activate
pip install -r requirements.txt
uvicorn app.main:app --reload --port 8001
```

**DoD:** health sukses dan Laravel menerima `label` + `confidence_score` dummy.

## Fase 3 — Latih dan pasang MobileNetV2

**Estimasi:** 3–7 hari, tergantung dataset.

- Siapkan dataset berizin dengan kelas `luka`, `obat`, `tidak_relevan`.
- Pisahkan train/validation/test dan dokumentasikan sumbernya.
- Resize 224×224, normalisasi, dan augmentation secukupnya.
- Ukur accuracy, precision, recall, F1, loss, confusion matrix, dan latensi.
- Simpan model/version di luar Git bila besar.
- Tetapkan threshold 0.70 berdasarkan evaluasi.

**DoD:** model dipanggil FastAPI, hasil terukur dilaporkan, dan gambar tidak relevan diuji khusus.

## Fase 4 — Integrasi orchestrator dan guardrail

**Estimasi:** 2–3 hari.

- Tambahkan migration `cnn_label`, `confidence_score`, `model_version`, `status`.
- Tambahkan migration/model `audit_logs`.
- Buat `AiClassifierService` dan `GroqService`.
- Ubah scan agar memanggil FastAPI terlebih dahulu.
- Hentikan alur sebelum Groq bila label tidak relevan atau confidence `<= 0.70`.
- Susun prompt dari hasil CNN + notes dan tambahkan disclaimer/rujukan darurat.

**DoD:** test membuktikan rejected tidak pernah memanggil Groq; accepted menyimpan skor dan respons.

## Fase 5 — UI, riwayat, dan chat

**Estimasi:** 1–2 hari.

- Tampilkan status validasi, klasifikasi, diterima/ditolak, dan generasi.
- Tampilkan label/confidence tanpa menyatakan diagnosis.
- Tampilkan safe rejection dan rujukan darurat dengan jelas.
- Pastikan chat membawa konteks scan yang benar dan ownership terjaga.

## Fase 6 — Pengujian dan evaluasi

**Estimasi:** 2–3 hari.

- Jalankan unit/feature Laravel dan test endpoint FastAPI.
- Gunakan HTTP fake untuk Groq/FastAPI.
- Uji luka, obat, acak, blur, confidence rendah, timeout, dan kondisi darurat.
- Evaluasi model dengan confusion matrix/F1.
- Minta evaluator manusia menilai relevansi dan keamanan.
- Simpan bukti di `Docs/test-evidence/`.

## Fase 7 — Deployment PoC

**Estimasi:** 1–2 hari.

- Siapkan Laravel, MySQL, Python service, HTTPS, dan secret environment.
- Jalankan migration, `storage:link`, build asset, dan cache config.
- Jangan expose FastAPI ke publik tanpa autentikasi.
- Uji backup database/storage dan siapkan rollback ke direct-Groq.

## Cara kerja manual harian

Terminal 1:

```powershell
php artisan serve
```

Terminal 2:

```powershell
npm run dev
```

Mulai fase AI, Terminal 3:

```powershell
cd ai-service
.venv\Scripts\activate
uvicorn app.main:app --reload --port 8001
```

Setiap selesai task: cek `git diff`, jalankan test terkait, buka aplikasi, lalu commit perubahan kecil dengan pesan jelas.

## Rollback aman

Jangan menghapus database atau storage saat debugging. Buat backup SQL, gunakan migration baru, dan matikan integrasi FastAPI melalui config bila service bermasalah.
