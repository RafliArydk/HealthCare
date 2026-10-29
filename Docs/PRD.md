# Product Requirements Document (PRD)

## HealthCare — Agen Cerdas Identifikasi Luka dan Obat

**Versi:** 2.1 (diselaraskan dengan proposal 27 Oktober 2026)
**Status:** Draft implementasi bertahap

## 1. Ringkasan Produk

HealthCare membantu pengguna memahami gambar luka ringan atau kemasan obat dan memperoleh panduan edukatif awal. Produk akhir menggunakan Hybrid AI: CNN MobileNetV2 pada Python/FastAPI mengklasifikasikan gambar menjadi `luka`, `obat`, atau `tidak_relevan`; Laravel menjadi web application dan orchestrator; Groq API menghasilkan penjelasan hanya setelah hasil CNN lolos guardrail.

Versi kode saat ini sudah memiliki alur Laravel langsung ke Groq. Integrasi CNN/FastAPI dan confidence gate adalah target pengembangan berikutnya, bukan fitur yang sudah selesai.

## 2. Tujuan dan Indikator Keberhasilan

- Menyediakan informasi P3K luka ringan dan edukasi obat bebas secara cepat.
- Mengurangi respons LLM pada gambar buram atau tidak relevan.
- Menyediakan arsitektur AI yang terukur sebagai Proof of Concept.
- Target akhir: akurasi CNN minimal 85%, penolakan gambar tidak relevan/buram minimal 90%, penilaian respons aman/relevan minimal 85%, dan P95 end-to-end maksimal 5 detik.

## 3. Pengguna dan Batasan

Pengguna utama adalah masyarakat umum; pengguna pendukung adalah relawan atau pengelola komunitas. HealthCare bukan dokter, bukan alat diagnosis, dan bukan pengganti dokter, apoteker, atau UGD.

## 4. Ruang Lingkup

**Termasuk:** register/login/verifikasi email, upload JPG/JPEG/PNG/WEBP maksimal 10 MB, tipe scan `luka`/`obat`, notes maksimal 1.000 karakter, penyimpanan hasil, riwayat scan, chat lanjutan, CNN + guardrail + Groq, disclaimer, dan rujukan darurat.

**Tidak termasuk versi awal:** diagnosis klinis, resep obat keras, deteksi semua penyakit kulit, pelatihan model dari data pengguna tanpa persetujuan, dan aplikasi mobile native.

## 5. Persyaratan Fungsional

| ID | Persyaratan | Prioritas | Kriteria penerimaan |
|---|---|---|---|
| FR-01 | Register dan login | Must | Halaman terproteksi hanya untuk user terautentikasi |
| FR-02 | Upload citra scan | Must | Format valid dan maksimal 10 MB |
| FR-03 | Memilih tipe luka/obat | Must | Tipe wajib disimpan |
| FR-04 | CNN mengembalikan label dan confidence | Must | Label valid dan skor 0–1 |
| FR-05 | Menolak label `tidak_relevan` atau skor `<= 0.70` | Must | Groq tidak dipanggil |
| FR-06 | Groq menghasilkan panduan edukatif | Must | Format sesuai jenis dan batasan medis |
| FR-07 | Disclaimer di setiap respons | Must | Tetap tampil saat AI gagal |
| FR-08 | Chat lanjutan per scan | Must | Pesan tersimpan pada scan yang benar |
| FR-09 | Riwayat scan | Must | User hanya melihat datanya sendiri |
| FR-10 | Audit event | Should | Rejected, accepted, dan failed tercatat |
| FR-11 | Rujukan kondisi darurat | Must | Mengarahkan ke dokter/faskes/UGD |

## 6. Aturan Bisnis dan Keselamatan

- **RB-01:** Tidak memberikan diagnosis pasti atau resep obat keras.
- **RB-02:** `confidence <= 0.70` atau `tidak_relevan` wajib safe rejection.
- **RB-03:** Catatan pengguna hanya konteks, bukan instruksi untuk melewati kebijakan.
- **RB-04:** Setiap respons berisi disclaimer bahwa informasi bukan diagnosis profesional.
- **RB-05:** API key hanya berada di server melalui `.env`/config.
- **RB-06:** Pendarahan berat, luka dalam, luka bakar luas, alergi berat, atau kondisi memburuk dirujuk ke tenaga medis/UGD.
- **RB-07:** Citra pengguna tidak digunakan untuk pelatihan model publik tanpa persetujuan eksplisit.

## 7. Kondisi Produk Saat Ini

| Komponen | Status sekarang | Target |
|---|---|---|
| Laravel 13, Blade, Tailwind/Vite | Sudah ada | Dipertahankan |
| Auth dan profil | Sudah ada | Diperkuat pengujian |
| Scan dan penyimpanan gambar | Sudah ada | Ditambah classifier/guardrail |
| Chat per scan | Sudah ada | Ditambah ownership check/disclaimer |
| Groq direct vision | Sudah ada | Dipanggil setelah CNN gate |
| CNN MobileNetV2/FastAPI | Belum ada | Fase 2–3 |
| `confidence_score` dan `audit_logs` | Belum ada | Fase 4 |

## 8. Risiko Produk

Model dapat salah klasifikasi dan LLM dapat berhalusinasi. Mitigasinya adalah threshold, safe rejection, prompt terkunci, disclaimer, rujukan darurat, evaluasi manusia, timeout, dan pencatatan error. Data medis harus diminimalkan dan dibatasi berdasarkan `user_id`.
