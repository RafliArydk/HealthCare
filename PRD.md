PRODUCT REQUIREMENTS DOCUMENT (PRD)
Nama Produk: HealthCare (Vision Chatbot Deteksi Luka & Obat)
Versi: 2.0 (Edisi Integrasi Groq API - LLaMA Vision)

1. Ringkasan Eksekutif
HealthCare adalah aplikasi web chatbot medis interaktif yang dirancang untuk memproses input teks dan gambar (foto) dari pengguna. Sistem ini memanfaatkan kecepatan tinggi dari Groq API menggunakan model Vision open-source (seperti LLaMA 3.2 Vision) yang tersedia pada tier gratis. Aplikasi ini akan mengidentifikasi jenis luka fisik untuk memberikan saran P3K, serta membaca kemasan obat untuk menjelaskan indikasi dan cara pakainya.

2. Arsitektur & Teknologi (Tech Stack)
Arsitektur: Model-View-Controller (MVC)

Frontend (Antarmuka): Laravel Blade, HTML5, CSS3, dan Bootstrap 5 (ramah pemula, responsif, dan rapi tanpa framework JavaScript tambahan).

Backend (Logika & Keamanan): PHP (Laravel 10 atau 11). Laravel bertindak sebagai jembatan yang menyembunyikan API Key Groq dari sisi klien (mencegah pencurian API Key).

AI Engine (Vision LLM): Groq API (Endpoint OpenAI-Compatible) menggunakan model llama-3.2-11b-vision-preview atau llama-3.2-90b-vision-preview. Model ini dipilih karena mendukung pembacaan gambar, sangat cepat (menggunakan LPU), dan 100% gratis untuk developer.

3. Persyaratan Fungsional (Functional Requirements)
FR-01: Input Multimodal (Teks + Gambar)

Formulir obrolan memiliki kolom teks (opsional) dan tombol unggah gambar (wajib untuk deteksi).

FR-02: Auto-Routing Konteks

Model LLaMA Vision membedakan secara otomatis apakah gambar yang dikirim adalah luka, kemasan obat, atau gambar acak yang tidak relevan.

FR-03: Analisis Luka (Wound Care)

Output wajib mencakup: 1) Jenis luka, 2) Estimasi kondisi (lecet/bakar/sayat), 3) Langkah P3K, 4) Tanda bahaya (kapan harus ke dokter).

FR-04: Analisis Obat (Medication Guide)

Output wajib mencakup: 1) Nama obat, 2) Fungsi & indikasi, 3) Aturan pakai umum, 4) Efek samping utama.

FR-05: Penyangkalan Medis (Medical Disclaimer)

Sistem menyisipkan teks statis di akhir jawaban: "Peringatan: Informasi ini dihasilkan oleh AI (HealthCare) dan bukan diagnosis medis. Segera konsultasikan ke dokter untuk penanganan pasti."

4. Persyaratan Non-Fungsional
NFR-01: Keamanan API Key: Kredensial Groq API hanya disimpan di file .env server dan dieksekusi di Controller PHP.

NFR-02: Optimasi Gambar: Gambar yang diunggah harus dikonversi ke format Base64 dan dibatasi ukurannya (maksimal 2-4 MB) sebelum dikirim ke Groq agar tidak terkena limit payload.

NFR-03: Kecepatan Respons: Memanfaatkan Groq LPU, balasan AI ditargetkan muncul dalam waktu kurang dari 5 detik setelah gambar selesai diunggah.

5. Panduan Pembuatan Kode (Langkah demi Langkah)
Pendekatan ini sangat ramah pemula karena menggunakan Laravel HTTP Client bawaan untuk menembak API Groq yang sudah berformat OpenAI-Compatible.