<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pusat Bantuan</h2>
        <p class="text-gray-500 mt-2 text-sm">Informasi singkat untuk menggunakan HealthCare AI dengan bijak.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6 divide-y divide-gray-100">
        <!-- FAQ 1 -->
        <div class="p-6 flex gap-5 items-start hover:bg-gray-50 transition">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 text-sm">Bagaimana cara memakai AI Scan?</h3>
                <p class="text-xs text-gray-500 mt-1">Unggah foto yang jelas lalu pilih Analisis. <span class="text-blue-500">· Panduan</span></p>
            </div>
            <button class="px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg hover:bg-blue-100 transition">Baca</button>
        </div>

        <!-- FAQ 2 -->
        <div class="p-6 flex gap-5 items-start hover:bg-gray-50 transition">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 text-sm">Apakah hasil scan merupakan diagnosis?</h3>
                <p class="text-xs text-gray-500 mt-1">Tidak. Hasil hanya edukasi awal dan tidak menggantikan dokter. <span class="text-orange-500">· Penting</span></p>
            </div>
            <button class="px-4 py-1.5 bg-orange-50 text-orange-600 text-xs font-bold rounded-lg hover:bg-orange-100 transition">Baca</button>
        </div>

        <!-- FAQ 3 -->
        <div class="p-6 flex gap-5 items-start hover:bg-gray-50 transition">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 text-sm">Apa yang bisa ditanyakan ke CareBot?</h3>
                <p class="text-xs text-gray-500 mt-1">Pertanyaan kesehatan umum, informasi obat, dan perawatan awal luka ringan. <span class="text-blue-500">· Panduan</span></p>
            </div>
            <button class="px-4 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg hover:bg-blue-100 transition">Baca</button>
        </div>

        <!-- FAQ 4 -->
        <div class="p-6 flex gap-5 items-start hover:bg-gray-50 transition">
            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 text-sm">Bagaimana data saya digunakan?</h3>
                <p class="text-xs text-gray-500 mt-1">Dalam prototype ini tidak ada backend. Jangan unggah data sensitif. <span class="text-green-500">· Privasi</span></p>
            </div>
            <button class="px-4 py-1.5 bg-green-50 text-green-600 text-xs font-bold rounded-lg hover:bg-green-100 transition">Baca</button>
        </div>
    </div>

    <!-- Emergency Warning -->
    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-6 flex items-start gap-4">
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-sm text-orange-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <p class="text-sm text-orange-800 font-medium leading-relaxed pt-2">
            Untuk keadaan darurat, segera hubungi layanan darurat setempat atau pergi ke IGD — jangan mengandalkan chatbot.
        </p>
    </div>
</x-app-layout>