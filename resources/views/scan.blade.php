<x-app-layout>
    <!-- CDN Markdown Parser -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <!-- CSS Tambahan untuk Markdown AI -->
    <style>
        .prose { text-align: left; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .prose ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .prose strong { font-weight: 700; color: #0f172a; }
        .prose p { margin-bottom: 0.75rem; }
        .prose h3, .prose h4 { font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; color: #0ea5e9; }
    </style>

    <!-- Header AI Scan -->
    <div class="mb-8 relative bg-white rounded-3xl p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center overflow-hidden border border-gray-100 shadow-sm">
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">AI Scan</h2>
            <p class="text-gray-500 mt-2 text-sm font-medium">Unggah foto untuk mendapatkan informasi awal yang relevan.</p>
        </div>
        <div class="absolute right-4 md:right-12 top-1/2 transform -translate-y-1/2 text-[#0ea5e9] opacity-10 md:opacity-20">
            <svg class="w-24 h-24 md:w-32 md:h-32 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
        </div>
    </div>

    <!-- Grid 2 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- ===== KIRI: Form Scan ===== -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 flex flex-col">
            <form id="scanForm" enctype="multipart/form-data">

                <!-- Pilih Jenis Pemeriksaan -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 text-sm mb-1">Pilih jenis pemeriksaan</h3>
                    <p class="text-[11px] text-gray-500 mb-4">Pastikan foto jelas dan cukup cahaya.</p>

                    <div class="grid grid-cols-2 gap-3">
                        <!-- Scan Obat -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="obat" class="peer sr-only" checked>
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 peer-checked:border-[#0ea5e9] peer-checked:bg-blue-50/50 transition text-left group bg-white">
                                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Scan obat</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Informasi kemasan obat</p>
                                </div>
                            </div>
                        </label>

                        <!-- Scan Luka -->
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="luka" class="peer sr-only">
                            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 peer-checked:border-[#0ea5e9] peer-checked:bg-blue-50/50 transition text-left group bg-white">
                                <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Scan luka</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Panduan perawatan awal</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Input Teks Opsional -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-800 mb-2">Nama obat atau catatan (opsional)</label>
                    <textarea name="notes" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9] text-sm py-3 px-4 resize-none bg-gray-50/50" placeholder="Contoh: nama yang terlihat pada kemasan..."></textarea>
                </div>

                <!-- KOTAK MEDIA (Kamera / Upload / Preview) -->
                <div class="mb-4">
                    <div class="relative w-full h-72 border-2 border-dashed border-[#0ea5e9]/30 rounded-2xl bg-[#f0f9ff] overflow-hidden flex flex-col items-center justify-center">

                        <!-- 1. Placeholder (Awal) -->
                        <div id="placeholderState" class="flex flex-col items-center justify-center text-center p-4">
                            <div class="w-12 h-12 bg-white text-[#0ea5e9] rounded-full flex items-center justify-center mb-3 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-800">Pilih foto atau nyalakan kamera</p>
                            <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG (Maks. 10MB)</p>
                        </div>

                        <!-- 2. Preview Image -->
                        <img id="imagePreview" class="absolute inset-0 w-full h-full object-contain bg-[#f0f9ff] hidden z-10" />

                        <!-- 3. Live Kamera Feed -->
                        <video id="cameraVideo" autoplay playsinline muted class="absolute inset-0 w-full h-full object-cover hidden z-10 transform scale-x-[-1]"></video>

                        <!-- Tombol Silang (X) Reset -->
                        <button type="button" id="btnResetMedia" onclick="resetMedia()" class="absolute top-4 right-4 w-8 h-8 bg-white/90 backdrop-blur-sm text-gray-700 rounded-full shadow-md hidden items-center justify-center hover:bg-red-50 hover:text-red-500 transition z-30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>

                        <!-- 4. Tombol Shutter Kamera -->
                        <button type="button" id="btnCapture" onclick="capturePhoto()" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 w-14 h-14 bg-white/30 backdrop-blur-sm border-4 border-white rounded-full hidden items-center justify-center z-20 hover:bg-white/50 transition">
                            <div class="w-10 h-10 bg-white rounded-full"></div>
                        </button>
                    </div>
                </div>

                <!-- Tombol Aksi Bawah -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button type="button" onclick="prepareForUpload()" class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl shadow-sm hover:bg-gray-50 hover:text-[#0ea5e9] transition">
                        Gunakan foto/video
                    </button>
                    <button type="button" id="btnToggleCamera" onclick="toggleCamera()" class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl shadow-sm hover:bg-gray-50 hover:text-[#0ea5e9] transition">
                        Gunakan kamera
                    </button>
                </div>

                <input type="file" id="imageInput" name="image" accept="image/*" class="hidden">

                <!-- Checkbox Consent -->
                <div class="mb-6 flex items-start">
                    <div class="flex items-center h-5">
                        <input id="consent" name="consent_training" type="checkbox" value="1" required
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 text-[#0ea5e9] cursor-pointer">
                    </div>
                    <label for="consent" class="ml-2 text-xs font-normal text-gray-600 cursor-pointer leading-tight">
                        Saya setuju gambar ini digunakan secara anonim untuk meningkatkan akurasi AI HealthCare di masa depan.
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" id="btnSubmit" class="w-full bg-[#0ea5e9] text-white py-3.5 rounded-xl font-bold hover:bg-[#0284c7] transition shadow-md shadow-blue-200 flex items-center justify-center gap-2 mb-4 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span id="btnText">Analisis dengan AI</span>
                </button>
            </form>
            <p class="text-[10px] text-center text-gray-400 leading-relaxed px-4">
                Dengan melanjutkan, kamu memahami bahwa hasil bersifat edukatif dan belum terhubung ke model AI medis.
            </p>
        </div>

        <!-- ===== KANAN: Hasil Analisis ===== -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 flex flex-col h-full min-h-[500px]">
            <div class="mb-6">
                <h3 class="font-bold text-gray-900 text-lg">Hasil analisis</h3>
                <p class="text-xs text-gray-500 mt-1">Hasil akan muncul di bagian ini</p>
            </div>

            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-8 border border-gray-100 rounded-2xl bg-gray-50/50">
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-gray-100 flex items-center justify-center mb-6 text-[#0ea5e9]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Siap untuk memulai?</h4>
                <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                    Unggah foto atau ambil gambar dari kamera, lalu klik tombol analisis.
                </p>
            </div>
        </div>

    </div>

    <canvas id="cameraCanvas" class="hidden"></canvas>

    <script>
        const form = document.getElementById('scanForm');
        const imageInput = document.getElementById('imageInput');

        const imagePreview = document.getElementById('imagePreview');
        const placeholderState = document.getElementById('placeholderState');
        const cameraVideo = document.getElementById('cameraVideo');
        const btnCapture = document.getElementById('btnCapture');
        const btnToggleCamera = document.getElementById('btnToggleCamera');
        const btnResetMedia = document.getElementById('btnResetMedia');

        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = document.getElementById('btnText');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let currentFile = null;
        let videoStream = null;
        let isCameraActive = false;

        // === FUNGSI RESET MEDIA (Hanya Input Kiri) ===
        function resetMedia() {
            currentFile = null;
            imageInput.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            btnResetMedia.classList.add('hidden');
            btnResetMedia.classList.remove('flex');

            stopCamera();
            placeholderState.classList.remove('hidden');
        }

        // === FUNGSI RESET TOTAL (Kiri & Kanan) ===
        function resetApp() {
            form.reset();
            resetMedia();

            // Kembalikan Empty State di Kanan
            const resultDiv = document.querySelector('.flex-1.flex.flex-col.items-center.justify-center');
            resultDiv.innerHTML = `
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-gray-100 flex items-center justify-center mb-6 text-[#0ea5e9]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Siap untuk memulai?</h4>
                <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                    Unggah foto atau ambil gambar dari kamera, lalu klik tombol analisis.
                </p>
            `;

            btnSubmit.disabled = false;
            btnText.innerText = 'Analisis dengan AI';
        }

        // === FUNGSI PERSIAPAN UPLOAD FILE ===
        function prepareForUpload() {
            resetMedia();
            imageInput.click();
        }

        // === 1. LOGIKA UPLOAD FILE ===
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                currentFile = file;
                showPreview(URL.createObjectURL(file));
            }
        });

        // === 2. LOGIKA KAMERA ===
        async function toggleCamera() {
            if (isCameraActive) {
                resetMedia();
                return;
            }

            currentFile = null;
            imageInput.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            placeholderState.classList.add('hidden');

            try {
                videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraVideo.srcObject = videoStream;

                cameraVideo.classList.remove('hidden');
                btnCapture.classList.remove('hidden');
                btnCapture.classList.add('flex');
                btnResetMedia.classList.remove('hidden');
                btnResetMedia.classList.add('flex');

                await cameraVideo.play();

                btnToggleCamera.innerText = 'Matikan kamera';
                btnToggleCamera.classList.add('bg-red-50', 'text-red-600', 'border-red-200');

                isCameraActive = true;
            } catch (err) {
                console.error(err);
                resetMedia();
                alert("Gagal mengakses kamera. Pastikan izin browser menyala.");
            }
        }

        function stopCamera() {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                cameraVideo.srcObject = null;
                videoStream = null;
            }
            isCameraActive = false;

            cameraVideo.classList.add('hidden');
            btnCapture.classList.add('hidden');
            btnCapture.classList.remove('flex');

            btnToggleCamera.innerText = 'Gunakan kamera';
            btnToggleCamera.classList.remove('bg-red-50', 'text-red-600', 'border-red-200');
        }

        function capturePhoto() {
            const canvas = document.getElementById('cameraCanvas');
            const context = canvas.getContext('2d');

            canvas.width = cameraVideo.videoWidth;
            canvas.height = cameraVideo.videoHeight;
            context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);

            canvas.toBlob((blob) => {
                currentFile = new File([blob], "kamera.jpg", { type: "image/jpeg" });
                showPreview(URL.createObjectURL(currentFile));
                stopCamera();
            }, 'image/jpeg', 0.9);
        }

        function showPreview(src) {
            imagePreview.src = src;
            imagePreview.classList.remove('hidden');
            placeholderState.classList.add('hidden');

            btnResetMedia.classList.remove('hidden');
            btnResetMedia.classList.add('flex');
        }

        // === 3. SUBMIT FORM (Tembak API Laravel) ===
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!currentFile) {
                alert('Pilih foto atau ambil gambar terlebih dahulu!');
                return;
            }

            btnSubmit.disabled = true;
            btnText.innerText = 'AI sedang menganalisis...';

            const formData = new FormData(form);
            formData.set('image', currentFile);

            try {
                const response = await fetch("{{ route('scan.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();
                const resultDiv = document.querySelector('.flex-1.flex.flex-col.items-center.justify-center');

                // LOGIKA GUARDRAIL & TAMPILAN UI
                if (response.ok && data.success) {
                    // 1. TAMPILAN JIKA SUKSES
                    const formattedAnalysis = marked.parse(data.analysis);

                    resultDiv.innerHTML = `
                        <div class="w-full h-full flex flex-col overflow-y-auto text-left">
                            <img src="${data.image_url}" class="w-full h-48 object-contain bg-gray-100 rounded-xl mb-4 shadow-sm border border-gray-200">

                            <div class="flex gap-2 mb-3">
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-200">CNN: ${data.cnn_label.toUpperCase()}</span>
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-md border border-green-200">Akurasi: ${(data.confidence * 100).toFixed(1)}%</span>
                            </div>

                            <h4 class="text-lg font-bold text-[#0ea5e9] mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Hasil Analisis AI
                            </h4>

                            <!-- Teks Analisis -->
                            <div class="prose prose-sm max-w-none text-gray-700 bg-gray-50 p-5 rounded-xl border border-gray-100 mb-5">
                                ${formattedAnalysis}
                            </div>

                            <!-- Peringatan -->
                            <div class="bg-orange-50 border border-orange-200 p-3 rounded-lg flex gap-2 items-start mb-5">
                                <svg class="w-4 h-4 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-[10px] text-orange-700 font-medium">Hasil ini bersifat informasi awal. Bukan diagnosis medis. Segera ke dokter jika kondisi memburuk.</p>
                            </div>

                            <!-- TOMBOL TANYA LANJUT -->
                            <a href="/chat/${data.scan_id}" class="w-full bg-[#0ea5e9] text-white py-3 rounded-xl font-bold hover:bg-[#0284c7] transition shadow-md shadow-blue-200 flex items-center justify-center gap-2 mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Tanya CareBot Lanjutan
                            </a>

                            <!-- TOMBOL SCAN ULANG -->
                            <button type="button" onclick="resetApp()" class="w-full bg-white border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Scan Ulang Gambar Lain
                            </button>

                        </div>
                    `;
                    btnText.innerText = 'Selesai';
                } else {
                    // 2. TAMPILAN JIKA DITOLAK GUARDRAIL (Status 422 dari Laravel)
                    resultDiv.innerHTML = `
                        <div class="w-full h-full flex flex-col items-center justify-center text-center p-6 bg-red-50 rounded-xl border border-red-200">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-red-700 mb-2">Gambar Ditolak</h4>
                            <p class="text-sm text-red-600 font-medium mb-6">${data.message || 'Sistem tidak dapat memproses gambar ini.'}</p>

                            <button type="button" onclick="resetApp()" class="px-6 py-2.5 bg-white border border-red-200 text-red-600 font-bold text-sm rounded-xl hover:bg-red-50 transition shadow-sm">
                                Coba Scan Ulang
                            </button>
                        </div>
                    `;


                    btnText.innerText = 'Analisis dengan AI';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan jaringan atau server mati.');
                btnSubmit.disabled = false;
                btnText.innerText = 'Analisis dengan AI';
            }
        });
    </script>
</x-app-layout>