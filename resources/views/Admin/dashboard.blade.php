<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Monitoring</h2>
            <p class="text-gray-500 mt-1 text-sm">Pantau aktivitas platform dan ringkasan penggunaan HealCare AI.</p>
        </div>
        <button class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Perbarui data
        </button>
    </div>

    <!-- Banner Info Admin -->
    <div class="bg-[#f0f9ff] border border-blue-100 rounded-2xl p-6 mb-8 flex gap-4 items-center">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm text-[#0ea5e9]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-gray-900 text-sm">Mode administrator</h4>
            <p class="text-xs text-gray-600 mt-1">Angka dan aktivitas pada halaman ini adalah data simulasi untuk mockup, bukan data pengguna nyata.</p>
        </div>
    </div>

    <!-- 4 Kartu Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Pengguna -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Total pengguna</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">1.284</h3>
            <p class="text-xs font-semibold text-green-500 mt-1 flex items-center gap-1">↑ 12.8% <span class="text-gray-400 font-normal">vs bulan lalu</span></p>
        </div>

        <!-- Total AI Scan -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Total AI scan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg></div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">3.862</h3>
            <p class="text-xs font-semibold text-green-500 mt-1 flex items-center gap-1">↑ 8.4% <span class="text-gray-400 font-normal">vs bulan lalu</span></p>
        </div>

        <!-- Percakapan Chatbot -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Percakapan chatbot</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg></div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">5.917</h3>
            <p class="text-xs font-semibold text-green-500 mt-1 flex items-center gap-1">↑ 18.2% <span class="text-gray-400 font-normal">vs bulan lalu</span></p>
        </div>

        <!-- Status Layanan -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Status layanan</span>
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
            </div>
            <h3 class="text-3xl font-bold text-green-500">Normal</h3>
            <p class="text-xs font-semibold text-gray-400 mt-1">Simulasi status sistem</p>
        </div>
    </div>

    <!-- Baris Chart & Diagram -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <!-- Kiri: Chart Bar -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Aktivitas platform</h3>
                    <p class="text-xs text-gray-500 mt-1">Volume layanan selama 7 hari terakhir</p>
                </div>
                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1.5 rounded-lg">7 hari</span>
            </div>

            <!-- Legend -->
            <div class="flex gap-4 mb-6 text-xs text-gray-500 font-medium">
                <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#0ea5e9]"></span> AI Scan</div>
                <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[#bae6fd]"></span> Chatbot</div>
            </div>

            <!-- Visualisasi Bar Chart (Mockup) -->
            <div class="flex-1 flex items-end justify-between gap-2 md:gap-4 h-48 mt-auto">
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

        <!-- Kanan: Donut Chart (Komposisi Aktivitas) -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
            <h3 class="font-bold text-gray-900 text-lg">Komposisi aktivitas</h3>
            <p class="text-xs text-gray-500 mt-1 mb-8">Distribusi penggunaan layanan</p>

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

            <!-- Catatan Analitik -->
            <div class="bg-[#f0f9ff] border border-blue-100 p-4 rounded-xl mt-6">
                <p class="text-xs font-bold text-gray-800 mb-1">Catatan analitik</p>
                <p class="text-[11px] text-gray-500">Statistik ini hanya contoh visual dan tidak merepresentasikan penggunaan nyata.</p>
            </div>
        </div>
    </div>

    <!-- ===== AKTIVITAS TERBARU ===== -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
        <!-- Header Aktivitas (Fix Panah Besar diganti link teks) -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-900 text-lg">Aktivitas terbaru</h3>
            <a href="#" class="text-sm font-bold text-[#0ea5e9] hover:text-[#0284c7] hover:underline flex items-center gap-1 transition">
                Lihat monitoring
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- List Aktivitas -->
        <div class="space-y-4">
            <!-- Item 1 -->
            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100 cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">AI Scan obat selesai</p>
                        <p class="text-xs text-gray-500 mt-0.5">user_rafli · Paracetamol · 09:15</p>
                    </div>
                </div>
                <span class="text-[10px] bg-green-50 text-green-600 font-bold px-2.5 py-1 rounded-md">Berhasil</span>
            </div>

            <!-- Item 2 -->
            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100 cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Sesi CareBot dimulai</p>
                        <p class="text-xs text-gray-500 mt-0.5">user_dina · Informasi kesehatan umum · 09:07</p>
                    </div>
                </div>
                <span class="text-[10px] bg-blue-50 text-blue-600 font-bold px-2.5 py-1 rounded-md">Aktif</span>
            </div>

            <!-- Item 3 -->
            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100 cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">AI Scan luka selesai</p>
                        <p class="text-xs text-gray-500 mt-0.5">user_nadia · Pemeriksaan awal · 08:52</p>
                    </div>
                </div>
                <span class="text-[10px] bg-green-50 text-green-600 font-bold px-2.5 py-1 rounded-md">Berhasil</span>
            </div>

            <!-- Item 4 -->
            <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100 cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-yellow-50 text-yellow-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Pengguna baru terdaftar</p>
                        <p class="text-xs text-gray-500 mt-0.5">andi.demo@mail.test · 08:31</p>
                    </div>
                </div>
                <span class="text-[10px] bg-orange-50 text-orange-600 font-bold px-2.5 py-1 rounded-md">Baru</span>
            </div>
        </div>
    </div>
</x-app-layout>