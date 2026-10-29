<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Pengguna</h2>
        <p class="text-gray-500 mt-1 text-sm">Kelola dan pantau akun demo yang terdaftar.</p>
    </div>

    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Akun -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Total akun</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">1.284</h3>
                <p class="text-xs font-semibold text-gray-400 mt-1">Data demo</p>
            </div>
        </div>

        <!-- Aktif 30 Hari -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Aktif 30 hari</span>
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">986</h3>
                <p class="text-xs font-semibold text-green-500 mt-1">76,7% aktif</p>
            </div>
        </div>

        <!-- Pendaftaran Baru -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Pendaftaran baru</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">42</h3>
                <p class="text-xs font-semibold text-gray-400 mt-1">7 hari terakhir</p>
            </div>
        </div>

        <!-- Akun Perlu Review -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Akun perlu review</span>
                <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">06</h3>
                <p class="text-xs font-semibold text-gray-400 mt-1">Simulasi moderasi</p>
            </div>
        </div>
    </div>

    <!-- Filter & Tabel -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">

        <!-- Filter Bar -->
        <div class="p-6 border-b border-gray-100 flex flex-wrap gap-3">
            <input type="text" placeholder="Cari nama atau email..." class="w-full md:w-64 bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <input type="date" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <button class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition">
                Reset
            </button>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider font-bold">
                        <th class="p-5 w-1/4">Pengguna</th>
                        <th class="p-5 w-1/4">Email</th>
                        <th class="p-5">Bergabung</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">

                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">RA</div>
                            <div>
                                <p class="font-bold text-gray-800">Rafli Aryadika</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">rafli@example.com</td>
                        <td class="p-5 text-gray-500">25 Okt 2026</td>
                        <td class="p-5"><span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Aktif</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">DI</div>
                            <div>
                                <p class="font-bold text-gray-800">Dina Putri</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">dina.demo@email.test</td>
                        <td class="p-5 text-gray-500">24 Okt 2026</td>
                        <td class="p-5"><span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Aktif</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">NA</div>
                            <div>
                                <p class="font-bold text-gray-800">Nadia Safitri</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">nadia.demo@email.test</td>
                        <td class="p-5 text-gray-500">22 Okt 2026</td>
                        <td class="p-5"><span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Aktif</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4 (Review) -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-xs flex-shrink-0">AK</div>
                            <div>
                                <p class="font-bold text-gray-800">Andi Kurniawan</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">andi.demo@email.test</td>
                        <td class="p-5 text-gray-500">25 Okt 2026</td>
                        <td class="p-5"><span class="bg-orange-50 text-orange-600 px-3 py-1 rounded-full text-xs font-bold">Review</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">SR</div>
                            <div>
                                <p class="font-bold text-gray-800">Siti Rahma</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">siti.demo@email.test</td>
                        <td class="p-5 text-gray-500">19 Okt 2026</td>
                        <td class="p-5"><span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Aktif</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 6 (Tidak aktif) -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-xs flex-shrink-0">BN</div>
                            <div>
                                <p class="font-bold text-gray-800">Bima Nugraha</p>
                                <p class="text-[11px] text-gray-500">Pengguna</p>
                            </div>
                        </td>
                        <td class="p-5 text-gray-600">bima.demo@email.test</td>
                        <td class="p-5 text-gray-500">18 Okt 2026</td>
                        <td class="p-5"><span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">Tidak aktif</span></td>
                        <td class="p-5 text-center">
                            <button class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Info Footer -->
    <div class="bg-[#f0f9ff] border border-blue-100 rounded-2xl p-4 text-xs text-gray-500 flex items-start gap-2">
        <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Akun demo dan angka pada tabel ini hanyalah data simulasi visual.
    </div>
</x-app-layout>