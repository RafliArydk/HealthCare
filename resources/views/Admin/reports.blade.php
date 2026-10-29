<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan & Analitik</h2>
            <p class="text-gray-500 mt-1 text-sm">Gambaran penggunaan layanan, sebagai contoh komponen monitoring.</p>
        </div>
        <button class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 hover:bg-[#0284c7] transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Buat laporan
        </button>
    </div>

    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Total aktivitas</p>
            <h3 class="text-3xl font-bold text-gray-900">9.779</h3>
            <p class="text-xs font-semibold text-gray-400 mt-1">Periode contoh</p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Pengguna aktif</p>
            <h3 class="text-3xl font-bold text-gray-900">986</h3>
            <p class="text-xs font-semibold text-green-500 mt-1">+7,5% periode lalu</p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Rata-rata sesi chat</p>
            <h3 class="text-3xl font-bold text-gray-900">4,8 mnt</h3>
            <p class="text-xs font-semibold text-gray-400 mt-1">Simulasi</p>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-medium text-gray-500 mb-1">Event ditinjau</p>
            <h3 class="text-3xl font-bold text-gray-900">32</h3>
            <p class="text-xs font-semibold text-gray-400 mt-1">Contoh audit</p>
        </div>
    </div>

    <!-- Area Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Tren Penggunaan (Bar Chart) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Tren penggunaan</h3>
                    <p class="text-xs text-gray-500 mt-1">Perbandingan aktivitas mingguan (contoh)</p>
                </div>
                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-lg">7 hari</span>
            </div>

            <!-- Visualisasi Bar Chart (Mockup) -->
            <div class="flex-1 flex items-end justify-between gap-2 md:gap-4 h-48 mt-4">
                <!-- Senin -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[40%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[20%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Sen</span>
                </div>
                <!-- Selasa -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[70%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[40%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Sel</span>
                </div>
                <!-- Rabu -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[50%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[30%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Rab</span>
                </div>
                <!-- Kamis -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[80%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[60%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Kam</span>
                </div>
                <!-- Jumat -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[60%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[40%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Jum</span>
                </div>
                <!-- Sabtu -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[95%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[70%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Sab</span>
                </div>
                <!-- Minggu -->
                <div class="flex flex-col items-center gap-2 flex-1 group">
                    <div class="flex items-end gap-1 w-full justify-center h-full">
                        <div class="w-1/2 bg-[#0ea5e9] rounded-t-sm h-[85%] group-hover:bg-[#0284c7] transition"></div>
                        <div class="w-1/2 bg-[#bae6fd] rounded-t-sm h-[50%] group-hover:bg-[#7dd3fc] transition"></div>
                    </div>
                    <span class="text-[10px] text-gray-400">Min</span>
                </div>
            </div>
        </div>

        <!-- Distribusi Layanan (Donut Chart) -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
            <h3 class="font-bold text-gray-900 text-lg">Distribusi layanan</h3>
            <p class="text-xs text-gray-500 mt-1 mb-8">Porsi aktivitas (contoh)</p>

            <div class="flex justify-center mb-8 relative">
                <!-- CSS Donut Chart -->
                <div class="w-40 h-40 rounded-full" style="background: conic-gradient(#0ea5e9 0% 56%, #38bdf8 56% 83%, #bae6fd 83% 100%);"></div>
                <!-- Inner circle -->
                <div class="absolute inset-0 m-auto w-28 h-28 bg-white rounded-full flex flex-col items-center justify-center shadow-inner">
                    <span class="text-xl font-bold text-gray-900">100%</span>
                    <span class="text-[10px] text-gray-500">Aktivitas</span>
                </div>
            </div>

            <!-- Legend -->
            <div class="space-y-3 mt-auto">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#0ea5e9]"></span> <span class="text-gray-600">Scan obat</span></div>
                    <span class="font-bold text-gray-900">56%</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#38bdf8]"></span> <span class="text-gray-600">Chatbot</span></div>
                    <span class="font-bold text-gray-900">27%</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#bae6fd]"></span> <span class="text-gray-600">Scan luka</span></div>
                    <span class="font-bold text-gray-900">17%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontrol Laporan -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-6">
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 text-lg">Kontrol laporan</h3>
            <p class="text-xs text-gray-500 mt-1">Pilih periode untuk contoh alur ekspor.</p>
        </div>

        <div class="flex flex-wrap gap-3 mb-6">
            <input type="date" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <input type="date" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <button class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 hover:bg-[#0284c7] transition flex items-center gap-2">
                Unduh CSV demo <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        <div class="bg-[#f0f9ff] border border-blue-100 rounded-2xl p-4 text-xs text-gray-500 flex items-start gap-2">
            <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Visualisasi dan angka dibuat untuk presentasi UI; bukan analitik operasional atau data klinis.
        </div>
    </div>
</x-app-layout>