<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HealthCare membantu mengenali obat dan luka ringan dengan panduan awal berbasis AI.">
    <title>{{ config('app.name', 'HealthCare') }} — Panduan kesehatan awal</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="landing-page">
    @php
        $scanUrl = Auth::check() ? route('scan.index') : route('login');
        $chatUrl = Auth::check() ? route('chat.index') : route('login');
    @endphp

    <header class="landing-nav-wrap">
        <nav class="landing-nav" aria-label="Navigasi utama">
            <a href="{{ url('/') }}" class="landing-brand"><span class="brand-mark">+</span><span>{{ config('app.name', 'HealthCare') }}</span></a>
            <div class="landing-nav-links" id="landing-menu">
                <a href="#fitur">Fitur</a>
                <a href="#cara-kerja">Cara Kerja</a>
                <a href="#informasi">Informasi</a>
            </div>
            <div class="landing-nav-actions">
                @auth
                    <a href="{{ route('scan.index') }}" class="button button-primary">Mulai Scan</a>
                    <details class="landing-profile">
                        <summary class="landing-profile-trigger {{ Auth::user()->role === 'admin' ? 'is-admin' : '' }}">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="Foto profil {{ Auth::user()->name }}" class="landing-profile-avatar object-cover">
                            @else
                                <span class="landing-profile-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                            @endif
                            <span class="landing-profile-copy">
                                <strong>{{ Auth::user()->name }}</strong>
                                <small>{{ Auth::user()->role === 'admin' ? 'Admin' : 'Akun saya' }}</small>
                            </span>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </summary>
                        <div class="landing-profile-menu">
                            <div class="landing-profile-heading">
                                <strong>{{ Auth::user()->name }}</strong>
                                <span>{{ Auth::user()->email }}</span>
                            </div>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                <a href="{{ route('admin.monitoring') }}">Monitoring Scan</a>
                                <a href="{{ route('admin.users') }}">Data Pengguna</a>
                            @else
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                                <a href="{{ route('history.index') }}">Riwayat Pemeriksaan</a>
                                <a href="{{ route('chat.index') }}">CareBot Chat</a>
                            @endif
                            <a href="{{ route('settings.index') }}">Profil & Pengaturan</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Keluar</button>
                            </form>
                        </div>
                    </details>
                @else
                    <a href="{{ route('login') }}" class="button button-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="button button-primary">Daftar</a>
                @endauth
            </div>
            <button class="landing-menu-toggle" type="button" aria-label="Buka menu" aria-controls="landing-menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </nav>
    </header>

    <main>
        <section class="hero section-shell">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> Didukung kecerdasan buatan</span>
                <h1>Pindai obat dan luka,<br><span>dapatkan panduan awal</span><br>dalam hitungan detik</h1>
                <p>HealthCare membantu mengenali obat dan menilai luka ringan dari foto, dilengkapi chatbot yang siap menjawab pertanyaanmu.</p>
                <div class="hero-actions">
                    <a href="{{ $scanUrl }}" class="button button-primary button-large">
                        <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m13-5h3a2 2 0 0 1 2 2v3M3 16v3a2 2 0 0 0 2 2h3m13-5v3a2 2 0 0 1-2 2h-3M8 12h.01M16 12h.01M12 8h.01M12 16h.01"/></svg>
                        Mulai Scan
                    </a>
                    <a href="#cara-kerja" class="button button-outline button-large">Lihat Cara Kerja</a>
                </div>
            </div>
            <div class="scan-demo-card" aria-label="Pratinjau scan HealthCare">
                <label for="hero-image-input" class="scan-dropzone" id="scan-dropzone">
                    <span class="scan-icon" id="scan-icon">
                        <svg viewBox="0 0 24 24"><path d="M8 3H5a2 2 0 0 0-2 2v3m13-5h3a2 2 0 0 1 2 2v3M3 16v3a2 2 0 0 0 2 2h3m13-5v3a2 2 0 0 1-2 2h-3"/><path d="M8 12h.01M16 12h.01M12 8h.01M12 16h.01"/></svg>
                    </span>
                    <img src="" alt="Preview foto yang dipilih" id="hero-image-preview" hidden>
                    <strong id="scan-dropzone-label">Letakkan foto di sini</strong>
                    <small>atau klik untuk memilih gambar</small>
                    <input id="hero-image-input" type="file" accept="image/jpeg,image/png,image/webp" hidden>
                </label>
                <div class="scan-result-heading">
                    <span id="scan-result-label">Contoh hasil: Luka lecet ringan</span>
                    <b id="scan-confidence">92% yakin</b>
                </div>
                <div class="confidence-track"><span></span></div>
                <a href="{{ $scanUrl }}" class="demo-link">Gunakan fitur scan <span>→</span></a>
            </div>
        </section>

        <section class="content-section section-shell" id="fitur">
            <div class="section-heading"><h2>Semua yang kamu butuhkan</h2></div>
            <div class="feature-grid">
                <article class="feature-card">
                    <span class="feature-icon"><svg viewBox="0 0 24 24"><path d="m14.5 5.5 4 4M8 16l-3 3a2.8 2.8 0 0 1-4-4l3-3m12-7 2-2a2.8 2.8 0 0 1 4 4l-3 3M7 17 17 7"/></svg></span>
                    <h3>Scan Obat</h3><p>Foto kemasan atau tablet untuk mengenali nama, kegunaan umum, dan peringatan pemakaian.</p>
                </article>
                <article class="feature-card">
                    <span class="feature-icon"><svg viewBox="0 0 24 24"><path d="M20.8 8.7c0 5.5-8.8 11.3-8.8 11.3S3.2 14.2 3.2 8.7A4.7 4.7 0 0 1 12 6a4.7 4.7 0 0 1 8.8 2.7Z"/></svg></span>
                    <h3>Scan Luka</h3><p>Unggah foto luka untuk mendapat perkiraan jenis luka dan langkah perawatan awal.</p>
                </article>
                <article class="feature-card">
                    <span class="feature-icon"><svg viewBox="0 0 24 24"><path d="M20 11.5a7 7 0 0 1-7.5 7H9l-5 3v-5.2A7 7 0 0 1 4.5 5.5 7 7 0 0 1 20 11.5Z"/></svg></span>
                    <h3>Chatbot Kesehatan</h3><p>Tanyakan hasil scan atau keluhan ringan kapan saja dengan jawaban yang mudah dipahami.</p>
                </article>
            </div>
        </section>

        <section class="content-section section-shell" id="cara-kerja">
            <div class="section-heading"><h2>Cara kerja</h2></div>
            <div class="steps-grid">
                <article class="step-card"><span class="step-number">1</span><div><h3>Daftar atau masuk</h3><p>Buat akun gratis dalam satu menit.</p></div></article>
                <article class="step-card"><span class="step-number">2</span><div><h3>Foto obat atau luka</h3><p>Ambil foto dari kamera atau galeri.</p></div></article>
                <article class="step-card"><span class="step-number">3</span><div><h3>Terima hasil & saran</h3><p>AI memberi analisis awal, lalu lanjutkan ke chatbot.</p></div></article>
            </div>
        </section>

        <section class="callout callout-blue section-shell" id="informasi">
            <span class="circle circle-left"></span><span class="circle circle-right"></span>
            <div class="callout-content">
                <h2>Kami tidak menggantikan dokter.<br>Kami membantumu sebelum ke dokter.</h2>
                <p>HealthCare memberi panduan awal supaya kamu tahu apa yang harus dilakukan lebih dulu. Jika kondisi serius, sistem akan menyarankanmu untuk menemui tenaga medis.</p>
                <a href="tel:119" class="emergency-pill">⚠ Kondisi darurat? Hubungi 119</a>
            </div>
        </section>

        <section class="audience-card section-shell">
            <div class="audience-title">
                <span class="eyebrow">Untuk semua kalangan</span>
                <h2>Untuk siapa HealthCare?</h2>
            </div>
            <div class="audience-list">
                <div><span>1</span><p><b>Keluarga berpenghasilan rendah</b><small>Dapatkan informasi kesehatan gratis kapan pun kamu membutuhkannya.</small></p></div>
                <div><span>2</span><p><b>Ibu dan pengasuh</b><small>Cek luka anak atau obat yang umum dipakai tanpa panik.</small></p></div>
                <div><span>3</span><p><b>Lansia dan pengguna yang belum terbiasa digital</b><small>Tampilan sederhana, teks mudah dibaca, dan proses masuk yang ringkas.</small></p></div>
                <div><span>4</span><p><b>Pekerja harian</b><small>Berguna untuk luka kecil saat bekerja atau mengenali obat dengan cepat.</small></p></div>
            </div>
        </section>

        <section class="callout callout-blue section-shell">
            <span class="circle circle-left"></span><span class="circle circle-right"></span>
            <div class="callout-content">
                <h2>Akses kesehatan dasar harus gratis<br>untuk semua orang.</h2>
                <p>Mulai gunakan HealthCare dan bantu keluargamu merasa lebih aman, tenang, dan terinformasi setiap hari.</p>
                <a href="{{ $scanUrl }}" class="button callout-button">♡ &nbsp; Mulai Cek Gratis</a>
            </div>
        </section>
    </main>

    <footer class="landing-footer section-shell">
        <div class="footer-main">
            <div class="footer-about">
                <a href="{{ url('/') }}" class="landing-brand"><span class="brand-mark">+</span><span>{{ config('app.name', 'HealthCare') }}</span></a>
                <p>Panduan awal obat dan luka berbasis AI, gratis untuk semua orang.</p>
            </div>
            <div>
                <b>Fitur</b>
                <a href="{{ $scanUrl }}">Scan Obat</a>
                <a href="{{ $scanUrl }}">Scan Luka</a>
                <a href="{{ $chatUrl }}">Chatbot Kesehatan</a>
            </div>
            <div>
                <b>Bantuan</b>
                <a href="#cara-kerja">Cara Kerja</a>
                <a href="{{ route('help.index') }}">Pertanyaan Umum</a>
                <a href="mailto:hello@healthcare.test">Hubungi Kami</a>
            </div>
            <div>
                <b>Legal</b>
                <a href="#informasi">Kebijakan Privasi</a>
                <a href="#informasi">Syarat & Ketentuan</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} HealthCare. Semua hak dilindungi.</span>
            <span>Bukan pengganti diagnosis dokter · Darurat? Hubungi 119</span>
        </div>
    </footer>

    <script>
        const menuButton = document.querySelector('.landing-menu-toggle');
        const navLinks = document.querySelector('.landing-nav-links');
        menuButton?.addEventListener('click', () => {
            const open = navLinks.classList.toggle('is-open');
            menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        document.querySelectorAll('.landing-nav-links a[href^="#"], .hero-actions a[href^="#"]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const target = document.querySelector(link.getAttribute('href'));
                if (!target) return;
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                navLinks.classList.remove('is-open');
                menuButton?.setAttribute('aria-expanded', 'false');
            });
        });

        const imageInput = document.querySelector('#hero-image-input');
        const preview = document.querySelector('#hero-image-preview');
        const dropzone = document.querySelector('#scan-dropzone');
        const label = document.querySelector('#scan-dropzone-label');
        const icon = document.querySelector('#scan-icon');

        imageInput?.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (!file) return;
            if (file.size > 10 * 1024 * 1024) {
                label.textContent = 'Ukuran maksimal 10 MB';
                imageInput.value = '';
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
            icon.hidden = true;
            label.textContent = file.name;
            dropzone.classList.add('has-image');
        });
    </script>
</body>
</html>