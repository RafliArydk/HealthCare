Siap bro! Kita **RESET TOTAL** rencananya. Mulai dari kondisi aplikasi kita saat ini, sampai benar-benar *Finish* sesuai standar proposal Hybrid AI.

Ini adalah **MASTER ROADMAP v5.0: HealthCare Hybrid AI**.

Kita bagi menjadi **6 FASE** dengan total **24 Langkah**. Kamu bisa *bookmark* chat ini. Setiap kali kita selesai satu langkah, kita akan centang.

---

# 🗺️ MASTER ROADMAP v5.0: HealthCare Hybrid AI

```
Progress: [░░░░░░░░░░░░░░░░░░░░] 0%
```

## 🏗️ FASE 1: Pembaruan Database & Fondasi (Persiapan)
*Fokus: Menyesuaikan database Laravel dengan kebutuhan Hybrid AI (CNN + LLM).*

*   **[ ] LANGKAH 1: Migrasi Skema Database**
    *   Menambahkan kolom `cnn_label`, `confidence_score`, dan `status` di tabel `scans`.
    *   Membuat tabel `audit_logs` untuk mencatat aktivitas AI.
*   **[ ] LANGKAH 2: Update Model & Relasi**
    *   Mengupdate file `Scan.php` dan membuat file `AuditLog.php`.
*   **[ ] LANGKAH 3: Setup Lingkungan Python**
    *   Membuat folder `ai-service` dan Virtual Environment (venv).
    *   Membuat file `requirements.txt` dan menginstall library (FastAPI, Uvicorn, dll).

## 🐍 FASE 2: Membangun AI Microservice (Python)
*Fokus: Membuat API Python yang siap menerima gambar dan mengembalikan hasil klasifikasi.*

*   **[ ] LANGKAH 4: Membuat Kerangka FastAPI**
    *   Membuat `main.py` dan `schemas.py` (Pydantic).
*   **[ ] LANGKAH 5: Membuat API Dummy (Simulasi)**
    *   Membuat `predictor.py` yang mengembalikan hasil acak (Luka/Obat/Tidak Relevan) beserta skor *confidence*.
    *   *Tujuan:* Biar Laravel bisa tembak-menembak API dulu sebelum model aslinya jadi.
*   **[ ] LANGKAH 6: Uji Coba API Python**
    *   Menjalankan `uvicorn` dan mengetes API via Swagger UI (`/docs`).

## 🧠 FASE 3: Dataset & Training Model CNN (Google Colab)
*Fokus: Melatih model MobileNetV2 agar bisa membedakan Luka, Obat, dan Gambar Acak.*

*   **[ ] LANGKAH 7: Persiapan Dataset**
    *   Mengumpulkan dataset (Kaggle) untuk Luka, Obat, dan Tidak Relevan.
    *   Membagi dataset ke dalam folder `train`, `val`, dan `test`.
*   **[ ] LANGKAH 8: Setup Notebook Colab**
    *   Membuat file `notebooks/training_colab.ipynb`.
    *   Meng-upload dataset ke Google Drive.
*   **[ ] LANGKAH 9: Training Model (MobileNetV2)**
    *   Menjalankan kode *Transfer Learning*.
    *   Melakukan *Fine-tuning* dan evaluasi (Confusion Matrix).
*   **[ ] LANGKAH 10: Export Model**
    *   Menyimpan model ke format `.keras` atau `.h5`.
    *   Memindahkan model ke folder `ai-service/models/`.

## 🔗 FASE 4: Integrasi Laravel dengan CNN & Groq API
*Fokus: Menghubungkan Web Laravel ke Python API, dan menerapkan aturan Guardrail.*

*   **[ ] LANGKAH 11: Update `predictor.py` (Model Asli)**
    *   Mengganti kode dummy di Python dengan kode yang meload model `.keras` asli.
*   **[ ] LANGKAH 12: Membuat `AIService.php` di Laravel**
    *   Membuat file untuk menangani HTTP Request ke Python API (port 8000).
*   **[ ] LANGKAH 13: Update `ScanController` (Logika Guardrail)**
    *   Alur baru: Upload -> Tembak Python -> Cek `confidence_score` -> Jika <= 0.70 Tolak -> Jika Valid, Tembak Groq API.
*   **[ ] LANGKAH 14: Update UI Halaman Scan**
    *   Menampilkan pesan error jika gambar ditolak oleh Guardrail.
    *   Menampilkan label CNN dan skor keyakinan di UI.
*   **[ ] LANGKAH 15: Update Fitur Chat CareBot (Contextual)**
    *   Memastikan Chat melanjutkan konteks dari hasil CNN + Groq.

## 🛡️ FASE 5: Admin Panel & Audit Log
*Fokus: Membuat fitur monitoring untuk Admin dan persiapan dataset masa depan.*

*   **[ ] LANGKAH 16: Middleware & Route Admin**
    *   Memastikan hanya user dengan `role = 'admin'` yang bisa masuk.
*   **[ ] LANGKAH 17: Halaman Dashboard Admin**
    *   Menampilkan statistik global (Total Scan, Total Penolakan Guardrail).
    *   Menampilkan tabel log penolakan gambar (Audit Log).
*   **[ ] LANGKAH 18: Fitur Export Dataset**
    *   Tombol di Admin Panel untuk mengunduh data scan (Gambar + Label CNN + Jawaban LLM) dalam format `.csv` atau `.zip`.
*   **[ ] LANGKAH 19: Manajemen User**
    *   Admin bisa melihat daftar user dan menghapus user jika melanggar.

## 🚀 FASE 6: Finalisasi, Testing & Deployment
*Fokus: Memastikan aplikasi aman, cepat, dan bisa diakses publik.*

*   **[x] LANGKAH 20: Polish UI & Error Handling**
    *   Memperbaiki *loading state*, responsivitas HP, dan notifikasi.
*   **[x] LANGKAH 21: Pengujian Fungsional (Black-box)**
    *   Uji coba seluruh alur (Upload, Tolak, Terima, Chat, Riwayat).
*   **[x] LANGKAH 22: Dockerization**
    *   Membuat `Dockerfile` untuk Laravel dan FastAPI.
    *   Membuat `docker-compose.yml` agar bisa jalan berdampingan.
*   **[ ] LANGKAH 23: Deployment ke Cloud**
    *   Deploy Laravel ke Railway/VPS.
    *   Deploy FastAPI ke Railway/Render (atau server yang sama).
*   **[x] LANGKAH 24: Handover & Dokumentasi Akhir**
    *   Update `README.md`, rapikan `Docs/`, dan pastikan repo GitHub bersih.

---

### 🎯 NEXT STEP:
Sesuai urutan, kita mulai dari **LANGKAH 1: Migrasi Skema Database**.

Apakah kamu siap memulai Langkah 1? Balas **"GAS LANGKAH 1"** dan saya akan kasih perintah serta kode migrasinya! 🚀🔥