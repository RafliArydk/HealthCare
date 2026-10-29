# HealthCare — Hybrid AI Medical Assistant

HealthCare adalah aplikasi web Laravel untuk edukasi awal tentang luka dan obat. Versi target menggabungkan CNN MobileNetV2 melalui FastAPI dengan Groq LLM. Aplikasi tidak menggantikan dokter dan tidak memberikan diagnosis pasti.

## Status proyek

Laravel sudah menyediakan autentikasi, dashboard, upload scan, penyimpanan gambar, riwayat, dan chat lanjutan. Alur scan masih memanggil Groq secara langsung. `ai-service/`, MobileNetV2, confidence gate, dan audit log adalah pekerjaan fase berikutnya.

## Prasyarat

- PHP 8.3+, Composer, Node.js/npm
- MySQL melalui Laragon/XAMPP
- Python 3.10+ untuk fase FastAPI
- Git

## Menjalankan Laravel saat ini

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

Buka `http://127.0.0.1:8000`. Pastikan database `healthcare_db` dibuat dan `.env` benar. Untuk frontend live reload gunakan terminal kedua: `npm run dev`.

## Konfigurasi `.env`

Isi secara lokal dan jangan commit:

```env
APP_NAME=HealthCare
DB_CONNECTION=mysql
DB_DATABASE=healthcare_db
DB_USERNAME=root
DB_PASSWORD=
GROQ_API_KEY=isi_api_key_lokal
GROQ_VISION_MODEL=qwen/qwen3.8-27b
GROQ_TIMEOUT=30
GROQ_MAX_TOKENS=800
GROQ_TEMPERATURE=0.4
AI_SERVICE_URL=http://127.0.0.1:8001
AI_SERVICE_TOKEN=token_lokal
```

## Menjalankan AI service pada fase integrasi

```powershell
cd ai-service
python -m venv .venv
.venv\Scripts\activate
pip install -r requirements.txt
uvicorn app.main:app --reload --port 8001
```

## Alur fitur target

```text
Upload → validasi → CNN/FastAPI → confidence gate
       ├─ ditolak: simpan event dan minta foto ulang
       └─ diterima: Groq → disclaimer → simpan → tampilkan
```

## Dokumentasi

- [PRD](PRD.md) — kebutuhan produk dan aturan bisnis.
- [TRD](TRD.md) — arsitektur, API, schema, keamanan, dan NFR.
- [Implementation Plan](IMPLEMENTATION%20PLAN.md) — fase pengerjaan manual.
- [Testing Plan](testing.md) — test case dan gate rilis.

## Pindah PC ke laptop

Clone/pull source dari Git, lalu pindahkan manual `.env`, dump database MySQL, dan `public/storage` bila riwayat gambar diperlukan. `vendor` dan `node_modules` dibuat ulang dengan `composer install` dan `npm install`.

| Nama | Email | Password | Role |
|---|---|---|---|
| User Test | `usertest@gmail.com` | `password` | `user` |
| Admin | `admin@gmail.com` | `admin123` | `admin` |