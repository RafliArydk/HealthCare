<x-app-layout>
    <!-- Header AI Scan (Background Putih + Shield Baru) -->
    <div class="mb-8 relative bg-white rounded-3xl p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center overflow-hidden border border-gray-100 shadow-sm">
        <!-- Teks Kiri -->
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">AI Scan</h2>
            <p class="text-gray-500 mt-2 text-sm font-medium">Unggah foto untuk mendapatkan informasi awal yang relevan.</p>
        </div>
        
        <!-- Gambar Shield Kanan (Ukuran Diperkecil & Opacity Diturunkan) -->
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
            <div class="mb-6">
                <h3 class="font-bold text-gray-900 text-lg">Pilih jenis pemeriksaan</h3>
                <p class="text-xs text-gray-500 mt-1">Pastikan foto jelas dan cukup cahaya.</p>
            </div>

            <!-- Tipe Pemeriksaan -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Scan Obat -->
                <button class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 hover:border-[#0ea5e9] transition text-left group bg-white">
                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Scan obat</p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Informasi kemasan obat</p>
                    </div>
                </button>

                <!-- Scan Luka (Active State) -->
                <button class="flex items-center gap-3 p-4 rounded-xl border-2 border-[#0ea5e9] bg-blue-50/30 transition text-left group">
                    <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0284c7]">Scan luka</p>
                        <p class="text-[11px] text-[#0284c7]/70 mt-0.5">Panduan perawatan awal</p>
                    </div>
                </button>
            </div>

            <!-- Input Teks Opsional -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-700 mb-2">Ceritakan kondisi luka (opsional)</label>
                <textarea rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#0ea5e9] focus:ring-[#0ea5e9] text-sm py-3 px-4 resize-none" placeholder="Contoh: luka lecet di lutut sejak kemarin..."></textarea>
            </div>

            <!-- Area Upload -->
            <div class="border-2 border-dashed border-[#0ea5e9]/30 rounded-2xl p-8 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50/50 transition group bg-[#f0f9ff] mb-6 flex-1">
                <div class="w-12 h-12 bg-white text-[#0ea5e9] rounded-full flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </div>
                <p class="text-sm font-bold text-gray-900 mb-1">Seret foto ke sini atau pilih file</p>
                <p class="text-xs text-gray-500 mb-4">Format JPG, PNG atau WEBP · Maks. 10 MB</p>
                <button class="px-5 py-2 bg-white border border-gray-300 text-gray-700 text-xs font-bold rounded-lg shadow-sm hover:bg-gray-50 transition">
                    Pilih foto
                </button>
            </div>

            <!-- Tombol Analisis -->
            <button class="w-full bg-[#0ea5e9] text-white py-3.5 rounded-xl font-bold hover:bg-[#0284c7] transition shadow-md shadow-blue-200 flex items-center justify-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Analisis dengan AI
            </button>

            <p class="text-[11px] text-center text-gray-400 leading-relaxed px-4">
                Dengan melanjutkan, kamu memahami bahwa hasil bersifat edukatif dan belum terhubung ke model AI medis.
            </p>
        </div>

        <!-- ===== KANAN: Hasil Analisis ===== -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 flex flex-col h-full min-h-[500px]">
            <div class="mb-6">
                <h3 class="font-bold text-gray-900 text-lg">Hasil analisis</h3>
                <p class="text-xs text-gray-500 mt-1">Hasil akan muncul di bagian ini</p>
            </div>

            <!-- Empty State (Kosong) -->
            <div class="flex-1 flex flex-col items-center justify-center text-center p-8 border border-gray-100 rounded-2xl bg-gray-50/50">
                <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-gray-100 flex items-center justify-center mb-6 text-[#0ea5e9]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Siap untuk memulai?</h4>
                <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                    Unggah foto dan klik tombol analisis untuk melihat contoh hasil informasi awal.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>