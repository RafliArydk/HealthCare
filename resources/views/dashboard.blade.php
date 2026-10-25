<x-app-layout>
    <!-- Header Sambutan -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat pagi, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
            <p class="text-gray-500 mt-2 text-sm">Bagaimana kabarmu hari ini? Ini ringkasan aktivitas kesehatanmu.</p>
        </div>
        <div>
            <a href="#" class="px-6 py-3 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl hover:bg-[#0284c7] transition shadow-lg shadow-blue-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                Mulai AI Scan
            </a>
        </div>
    </div>

    <!-- ===== 4 KARTU STATISTIK ===== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card 1: Total -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Total pemeriksaan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">08</h3>
                <p class="text-xs font-semibold text-green-500 mt-1">+2 bulan ini</p>
            </div>
        </div>

        <!-- Card 2: Scan Obat -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Scan obat</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">05</h3>
                <p class="text-xs font-semibold text-gray-500 mt-1">Riwayat tersimpan</p>
            </div>
        </div>

        <!-- Card 3: Scan Luka -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Scan luka</span>
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">03</h3>
                <p class="text-xs font-semibold text-gray-500 mt-1">Riwayat tersimpan</p>
            </div>
        </div>

        <!-- Card 4: Chat -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Chat CareBot</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">12</h3>
                <p class="text-xs font-semibold text-gray-500 mt-1">Percakapan</p>
            </div>
        </div>
    </div>

    <!-- Grid Utama (Kiri 2/3, Kanan 1/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ===== KIRI: Hasil Scan Terakhir ===== -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 h-full flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900 text-lg">Hasil Scan Terakhir</h3>
                    <a href="#" class="text-sm font-semibold text-[#0ea5e9] hover:underline">Lihat Semua Riwayat</a>
                </div>

                <!-- Card Detail Scan -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex-1 flex flex-col">
                    <!-- Area Gambar (Placeholder) -->
                    <div class="w-full h-64 bg-gray-200 rounded-xl mb-6 flex items-center justify-center relative overflow-hidden group">
                        <svg class="w-16 h-16 text-gray-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-bold text-gray-700 shadow-sm">
                            Scan Luka · Hari ini
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between items-end mb-2">
                            <h4 class="text-xl font-bold text-gray-900">Luka Lecet Ringan</h4>
                            <span class="text-sm font-bold text-[#0ea5e9]">92% Akurat</span>
                        </div>
                        <div class="w-full bg-gray-200 h-2.5 rounded-full">
                            <div class="bg-[#0ea5e9] h-2.5 rounded-full w-[92%]"></div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                        Bersihkan dengan air mengalir, keringkan dengan kain bersih, lalu tutup dengan perban steril. Hindari mengoleskan pasta gigi atau minyak.
                    </p>

                    <div class="bg-orange-50 border border-orange-200 p-4 rounded-xl flex gap-3 items-start mt-auto">
                        <svg class="w-5 h-5 text-orange-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-sm text-orange-700 font-medium">Segera ke dokter bila luka bernanah, bengkak hebat, atau disertai demam tinggi.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== KANAN: Akses Cepat, Ingat Ya, & Riwayat ===== -->
        <div class="space-y-6">

            <!-- 1. Akses Cepat -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="mb-5">
                    <h3 class="font-bold text-gray-900 text-lg">Akses cepat</h3>
                    <p class="text-xs text-gray-500 mt-1">Pilih layanan yang kamu butuhkan</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="bg-white border border-gray-200 p-4 rounded-2xl hover:border-[#0ea5e9] hover:shadow-md transition group flex flex-col gap-3">
                        <div class="w-10 h-10 bg-blue-50 text-[#0ea5e9] rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 leading-tight">Kenali info pada kemasan</span>
                    </a>

                    <a href="#" class="bg-white border border-gray-200 p-4 rounded-2xl hover:border-green-500 hover:shadow-md transition group flex flex-col gap-3">
                        <div class="w-10 h-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 leading-tight">Panduan awal perawatan</span>
                    </a>

                    <a href="#" class="bg-white border border-gray-200 p-4 rounded-2xl hover:border-purple-500 hover:shadow-md transition group flex flex-col gap-3">
                        <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 leading-tight">Informasi kesehatan umum</span>
                    </a>

                    <a href="#" class="bg-white border border-gray-200 p-4 rounded-2xl hover:border-yellow-500 hover:shadow-md transition group flex flex-col gap-3">
                        <div class="w-10 h-10 bg-yellow-50 text-yellow-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 leading-tight">Lihat aktivitas tersimpan</span>
                    </a>
                </div>
            </div>

            <!-- 2. Ingat, ya! -->
            <div class="bg-[#fff7ed] rounded-3xl p-6 border border-orange-200 relative overflow-hidden">
                <h4 class="font-bold text-orange-800 mb-2">Ingat, ya!</h4>
                <p class="text-xs text-orange-700 leading-relaxed mb-4 font-medium relative z-10">
                    Hasil AI adalah informasi awal, bukan diagnosis. Untuk keluhan serius, segera hubungi tenaga medis.
                </p>
                <div class="absolute -bottom-4 -right-2 text-orange-200 opacity-50">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>

            <!-- 3. Riwayat Terbaru -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-gray-900 text-base">Riwayat Terbaru</h3>
                    <a href="#" class="text-xs font-bold text-[#0ea5e9] hover:underline">Semua</a>
                </div>
                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-xl transition cursor-pointer group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 group-hover:text-[#0ea5e9] transition">Paracetamol 500 mg</p>
                                <p class="text-[11px] text-gray-500 mt-0.5">Scan obat · Hari ini</p>
                            </div>
                        </div>
                        <span class="text-[10px] bg-blue-50 text-blue-600 font-bold px-2 py-1 rounded">Dikenali</span>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-xl transition cursor-pointer group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 group-hover:text-[#0ea5e9] transition">Luka di lutut</p>
                                <p class="text-[11px] text-gray-500 mt-0.5">Scan luka · Kemarin</p>
                            </div>
                        </div>
                        <span class="text-[10px] bg-green-50 text-green-600 font-bold px-2 py-1 rounded">Membaik</span>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-xl transition cursor-pointer group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 group-hover:text-[#0ea5e9] transition">Ruam di lengan</p>
                                <p class="text-[11px] text-gray-500 mt-0.5">Scan luka · 3 hari lalu</p>
                            </div>
                        </div>
                        <span class="text-[10px] bg-red-50 text-red-600 font-bold px-2 py-1 rounded">Perlu Dokter</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>