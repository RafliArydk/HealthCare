# Deployment Checklist

## Sebelum release

- [ ] Provider dan region dipilih; Laravel dan FastAPI dapat saling mengakses.
- [ ] `APP_ENV=production` dan `APP_DEBUG=false`.
- [ ] `APP_KEY`, `GROQ_API_KEY`, `AI_SERVICE_TOKEN`, dan password database disimpan sebagai secret provider.
- [ ] Database production dan backup terjadwal tersedia.
- [ ] Storage gambar memakai object storage persisten, bukan filesystem ephemeral.
- [ ] Model `model_cnn.keras` dikirim melalui artifact/private storage dan tidak di-commit.
- [ ] `php artisan test`, test FastAPI, `vendor/bin/pint --dirty --format agent`, dan `composer audit` lulus.

## Railway: Laravel + FastAPI manual deployment

Gunakan dua service Railway dari repository yang sama:

1. Buat project baru di Railway dan hubungkan repository GitHub.
2. Buat service `healthcare-app` dengan root directory `/` dan Dockerfile `Dockerfile`.
3. Buat service `healthcare-ai` dengan root directory `/ai-service` dan Dockerfile `Dockerfile`.
4. Tambahkan MySQL managed Railway. Jangan memakai SQLite untuk production.
5. Generate public domain hanya untuk Laravel. FastAPI cukup private di jaringan Railway.
6. Deploy FastAPI lebih dulu, pastikan `/health` sehat, lalu deploy Laravel.

### Variables FastAPI

```text
AI_SERVICE_TOKEN=<random-long-token>
MODEL_URL=<private-signed-url-ke-model-cnn.keras>
PORT=${{PORT}}
```

`MODEL_URL` opsional bila model tersedia dalam image. Model sengaja tidak di-commit; gunakan signed URL/private artifact yang dapat dibaca saat container start. Jangan menaruh URL berisi secret di Git.

### Variables Laravel

```text
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generated-production-key>
APP_URL=https://<domain-laravel>
DB_CONNECTION=mysql
DB_HOST=<mysql-host>
DB_PORT=3306
DB_DATABASE=<database>
DB_USERNAME=<username>
DB_PASSWORD=<password>
AI_SERVICE_URL=http://<private-fastapi-host>:8001
AI_SERVICE_TOKEN=<nilai-sama-dengan-FastAPI>
GROQ_API_KEY=<groq-key>
GROQ_VISION_MODEL=qwen/qwen3.8-27b
GROQ_TIMEOUT=30
GROQ_MAX_TOKENS=800
GROQ_TEMPERATURE=0.4
```

Gunakan hostname private Railway yang ditampilkan dashboard; jangan menebaknya. Jika private networking tidak tersedia, gunakan URL FastAPI HTTPS yang dilindungi token.

### Build dan release Laravel

Build command:

```text
composer install --no-dev --optimize-autoloader && npm ci && npm run build
```

Start command:

```text
apache2-foreground
```

Release command:

```text
php artisan migrate --force
```

Jangan menyimpan upload, session, atau cache penting pada disk container. Konfigurasi object storage, database, queue, dan scheduler harus memakai resource production provider.

### Verifikasi Railway

1. Buka `https://<laravel-domain>/up`.
2. Pastikan `/health` FastAPI menunjukkan `model_loaded=true`.
3. Uji register/login, scan diterima, scan ditolak, chat, riwayat, dan akses lintas-user.
4. Pastikan log tidak menampilkan token/API key atau gambar mentah.

### Dampak dan mitigasi

- Dua service menambah konfigurasi dan biaya, tetapi isolasi error lebih baik dan FastAPI dapat di-scale terpisah.
- Jika FastAPI gagal, scan menampilkan pesan aman dan tidak melewati confidence gate.
- Jika model gagal diunduh, health check menunjukkan `model_loaded=false`; periksa `MODEL_URL` lalu redeploy.
- Filesystem Railway ephemeral; gunakan object storage/database managed untuk data persisten.
- Jika token berbeda, FastAPI mengembalikan 401; samakan `AI_SERVICE_TOKEN` melalui secret manager.

## Laravel Cloud/VPS

## FastAPI

Health check: `/health`

Internal prediction endpoint: `POST /api/v1/predict`

Set `AI_SERVICE_TOKEN` pada service FastAPI dan Laravel. Endpoint prediction menolak MIME type yang tidak diizinkan, file di atas 10 MB, dan request tanpa token yang sesuai.

## Sesudah release

- [ ] Health check Laravel (`/up`) dan FastAPI (`/health`) merespons.
- [ ] Uji register/login, upload diterima, upload ditolak, chat, riwayat, dan akses lintas-user.
- [ ] Pastikan log tidak berisi API key, gambar mentah, atau data sensitif.
- [ ] Pastikan rate limit, HTTPS, backup, monitoring, dan alert aktif.
- [ ] Simpan URL, commit, migration version, model version, dan bukti pengujian pada catatan release.
