# Testing Plan — HealthCare

## 1. Tujuan

Memastikan fitur berjalan, data pengguna terlindungi, dan guardrail Hybrid AI tidak dapat dilewati.

## 2. Perintah dasar

```powershell
php artisan test
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
php artisan route:list
php artisan config:clear
```

Untuk FastAPI:

```powershell
cd ai-service
pytest
```

## 3. Test case wajib

| ID | Skenario | Hasil yang diharapkan |
|---|---|---|
| AUTH-01 | Register dan login | User masuk dashboard |
| AUTH-02 | Akses dashboard tanpa login | Dialihkan ke login |
| AUTH-03 | User membuka scan user lain | 403/404, data tidak bocor |
| SCAN-01 | Upload JPG valid | Scan dibuat dan gambar tersimpan |
| SCAN-02 | File bukan gambar | 422, tidak ada panggilan AI |
| SCAN-03 | File > 10 MB | 422, tidak disimpan |
| SCAN-04 | Tipe bukan luka/obat | 422 |
| AI-01 | CNN luka, 0.85 | Groq dipanggil, hasil tersimpan |
| AI-02 | CNN obat, 0.90 | Respons edukasi dan disclaimer |
| AI-03 | Label tidak relevan | Ditolak, Groq tidak dipanggil |
| AI-04 | Confidence 0.70 | Ditolak, Groq tidak dipanggil |
| AI-05 | Confidence 0.71 | Dapat lanjut ke Groq |
| AI-06 | FastAPI timeout | Status failed dan pesan aman |
| AI-07 | Groq 401/429/5xx | Error aman tanpa secret |
| CHAT-01 | Chat lanjutan valid | Pesan tersimpan pada scan benar |
| CHAT-02 | Pesan > 1.000 karakter | 422 |
| SAFE-01 | Respons normal | Disclaimer selalu tampil |
| SAFE-02 | Prompt injection di notes | Kebijakan tidak berubah |
| SAFE-03 | Kondisi darurat | Rujuk dokter/faskes/UGD |
| SEC-01 | API key di source/browser | Tidak ditemukan |
| SEC-02 | CSRF tidak valid | Request ditolak |
| SEC-03 | Rate limit | Request berlebih mendapat 429 |

## 4. Automated test minimum

Gunakan `Http::fake()` untuk Groq dan FastAPI. Test minimal:

- Validasi file, tipe, dan notes.
- Mapping response FastAPI.
- Confidence `<= 0.70` menghasilkan rejected.
- Rejected tidak memanggil URL Groq.
- Accepted memanggil Groq dan menyimpan disclaimer.
- Ownership scan/chat dengan dua user berbeda.
- Timeout/5xx menghasilkan status aman.

## 5. Evaluasi model

Catat versi model, dataset, jumlah data tiap kelas, confusion matrix, accuracy, precision, recall, F1, dan latensi. Target proposal: accuracy ≥85%, rejection gambar tidak relevan/buram ≥90%, dan P95 end-to-end ≤5 detik.

## 6. Bukti pengujian

Simpan bukti manual di `Docs/test-evidence/` dengan format `{ID}_{deskripsi}.png`.

```markdown
### AI-03 — Label tidak relevan
- Tanggal:
- Commit:
- Input:
- Hasil: PASS/FAIL
- Catatan:
- Evidence:
```

## 7. Gate sebelum demo/deployment

- [ ] `php artisan test` lulus.
- [ ] Test FastAPI lulus.
- [ ] Tidak ada bypass confidence gate.
- [ ] Tidak ada API key di Git, HTML, JS, atau response.
- [ ] Ownership scan/chat teruji.
- [ ] Disclaimer dan rujukan darurat muncul.
- [ ] Tidak ada bug Critical/High terbuka.
- [ ] Backup database dan storage tersedia.
