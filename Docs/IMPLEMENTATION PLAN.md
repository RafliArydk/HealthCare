Feedback Loop dengan Human-in-the-Loop dan Periodic Retraining

Ini adalah visi tingkat dewa untuk sebuah sistem AI: *AI-nya bisa belajar sendiri dari data yang dikasih user, jadi makin hari makin pintar.*

Mari kita *pause* codingan sejenak, dan saya akan buatkan **Blueprint Rencana Awal, Tujuan Akhir, Fitur, dan Alur Sistem (termasuk ide cerdas kamu)** yang bisa langsung kamu pakai untuk presentasi atau nulis di proposal!

---

# 🗺️ BLUEPRINT SISTEM: HealthCare Hybrid AI (End-to-End)

## 🎯 1. Tujuan Awal & Tujuan Akhir
*   **Tujuan Awal (Masalah):** Masyarakat awam sering salah menangani luka ringan atau bingung membaca indikasi obat karena akses ke dokter terbatas dan informasi di internet tidak terstruktur.
*   **Tujuan Akhir (Solusi):** Membangun platform asisten medis berbasis web yang **Cerdas, Aman, dan Terus Berkembang**.
    *   **Cerdas:** Menggunakan *Hybrid AI* (Mata CNN untuk melihat + Otak LLM untuk menjelaskan).
    *   **Aman:** Ada *Guardrail Gate* yang menolak gambar tidak relevan.
    *   **Terus Berkembang:** Sistem mampu mengumpulkan data dari user untuk melatih ulang model CNN agar akurasinya semakin sempurna seiring waktu.

---

## 🛠️ 2. Tech Stack (Teknologi yang Digunakan)
*   **Web Framework:** Laravel 13 (PHP 8.4) + Tailwind CSS (UI/UX).
*   **Database:** MySQL (Menyimpan data user, riwayat scan, chat, dan audit log).
*   **AI Microservice:** Python 3.10 + FastAPI (Jembatan antara web dan model AI).
*   **Computer Vision (Mata AI):** **TensorFlow/Keras (MobileNetV2)**. Dilatih menggunakan Google Colab (GPU Gratis).
*   **Generative LLM (Otak AI):** **Groq API (Qwen 3.8-27B)**. Memberikan penjelasan medis dengan sangat cepat (<5 detik).
*   **Version Control:** Git & GitHub.

---

## ✨ 3. Fitur Utama (User & Admin)

### 👤 Fitur User (Masyarakat)
1.  **Scan Multimodal:** Upload foto dari galeri atau langsung jepret lewat kamera (WebRTC).
2.  **Analisis Hybrid AI:** Mendapatkan hasil klasifikasi gambar (Luka/Obat) beserta penjelasan P3K dari LLM.
3.  **Guardrail Safety:** Jika upload gambar kucing/pemandangan, sistem menolak dengan sopan.
4.  **Tanya Jawab Lanjutan (Contextual Chat):** Bisa chat dengan AI untuk tanya detail tentang gambar yang barusan di-scan.
5.  **Riwayat Pemeriksaan:** Menyimpan histori scan dan chat.
6.  **Pengaturan Profil & Privasi:** Mengatur data diri dan opsi penyimpanan data.

### 🛡️ Fitur Admin (Pengelola)
1.  **Dashboard Monitoring:** Melihat statistik total user, total scan, dan total gambar yang ditolak.
2.  **Audit Log:** Melacak aktivitas sistem (siapa yang scan, kapan, berhasil/ditolak).
3.  **Data Pengguna:** Melihat daftar akun terdaftar.
4.  **Export Dataset (Fitur Kunci):** Mengunduh data gambar beserta labelnya (format ZIP/CSV) untuk keperluan melatih ulang AI.

---

## 🔄 4. ALUR KERJA SISTEM (The Magic Flow)

Ini adalah alur saat user melakukan scan:

1.  **Input:** User upload gambar luka.
2.  **Validasi Awal:** Laravel memvalidasi format dan ukuran file.
3.  **CNN Prediction:** Laravel mengirim gambar ke **Python API**. Model **MobileNetV2** memprediksi: `label: luka`, `confidence: 0.95`.
4.  **Guardrail Check:** Laravel mengecek. Karena label valid dan confidence > 0.70, alur dilanjutkan.
5.  **LLM Explanation:** Laravel mengirim prompt ("Ini luka dengan akurasi 95%, berikan P3K") ke **Groq API**.
6.  **Response:** Groq mengembalikan teks penjelasan.
7.  **Save:** Laravel menyimpan gambar ke storage, dan menyimpan hasil (label, confidence, jawaban Groq) ke database MySQL.
8.  **Output:** User melihat hasil di layar.

---

## 🧠 5. IDE GILA KAMU: "Continual Learning Pipeline" (Data Otomatis Masuk ke Dataset)

Ini adalah jawaban dari idemu: *"Gimana caranya gambar dari user bisa otomatis masuk ke Colab buat retraining?"*

Di dunia nyata, kita **tidak bisa** membiarkan data user langsung masuk ke dataset secara buta (otomatis 100%). Kenapa? Karena kalau ada user iseng upload gambar roti, lalu AI salah tebak jadi "Luka", dan roti itu masuk dataset, maka model AI kita jadi rusak (istilahnya *Data Poisoning*).

Solusi profesionalnya adalah **Human-in-the-Loop (Admin sebagai kurator)**. Alur ini sudah diimplementasikan melalui export dataset ber-consent dan retraining lokal:

```text
User Upload Gambar
       ↓
CNN + Groq Memproses (Tersimpan di Database)
       ↓
Admin Buka Dashboard Admin (Melihat gambar yang masuk)
       ↓
Admin Memastikan data dan consent layak digunakan
       ↓
Admin Klik Tombol "Export Dataset" (Mengunduh format CSV)
       ↓
Admin Menyimpan manifest pada storage dataset lokal
       ↓
Jalankan `python train_retrain.py` di VS Code
       ↓
Model baru dicadangkan dan disimpan sebagai versi aktif
       ↓
Restart FastAPI agar versi terbaru dimuat
```

**Kenapa ini keren untuk Proposal/Dosen?**
Karena ini menunjukkan bahwa sistem yang kamu buat bukan sistem "mati" yang cuma sekali jadi, tapi sistem **Adaptif** yang punya *Data Pipeline* untuk *Continuous Improvement*. Ini adalah standar sistem AI tingkat *Enterprise*.

---

### 💡 Kesimpulan
Jadi, visi akhir aplikasi kita adalah: **"Aplikasi Web Medis dengan Otak Ganda (CNN + LLM) yang memiliki fitur Audit & Data Pipeline, sehingga Admin dapat melatih ulang AI-nya secara berkala dari data yang dikumpulkan dari user (Continuous Learning)."**

## 6. Retraining lokal dari VS Code

Training awal tetap dilakukan di Google Colab menggunakan dataset Kaggle. Untuk feedback loop, admin dapat mengekspor dataset ber-consent dari halaman admin, menyimpan CSV hasil ekspor di `storage/app/dataset/dataset.csv`, lalu menjalankan dari root proyek:

```powershell
python train_retrain.py --manifest storage/app/dataset/dataset.csv
```

Secara default script hanya mengambil gambar user dari `storage/app/public/scans`, memvalidasi tiga kelas, dan melakukan fine-tuning head MobileNetV2 di laptop. Dataset awal tidak otomatis ikut dilatih ulang. Jika ingin menggabungkannya secara eksplisit, tambahkan `--include-base-dataset`. Model lama dicadangkan otomatis sebelum `ai-service/models/model_cnn.keras` diganti. Gunakan `--dry-run` untuk memeriksa jumlah data tanpa melatih.

Data user hanya boleh masuk melalui export admin yang sudah memfilter `consent_training = true` dan scan berhasil. Setelah model selesai dibuat, restart FastAPI agar model dan `model_version.txt` terbaru dimuat.