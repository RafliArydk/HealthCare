<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h2>
        <p class="text-gray-500 mt-2 text-sm">Kelola profil, keamanan, dan preferensimu.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
            <div class="flex items-center gap-5 mb-8 pb-8 border-b border-gray-100">
                <div class="w-20 h-20 bg-[#0ea5e9] text-white rounded-full flex items-center justify-center font-bold text-2xl shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    <span class="inline-block mt-2 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded">Akun {{ Auth::user()->role }}</span>
                </div>
                <button class="ml-auto px-4 py-2 border border-gray-300 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 transition">Ganti Foto</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nama lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Nomor HP</label>
                    <input type="text" value="0812 3456 7890" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Tanggal lahir</label>
                    <input type="date" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Alergi obat (opsional)</label>
                    <input type="text" placeholder="Contoh: penisilin" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Bahasa</label>
                    <select class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                        <option>Bahasa Indonesia</option>
                        <option>English</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button class="px-5 py-2.5 text-gray-600 font-bold text-sm hover:bg-gray-100 rounded-xl transition">Batal</button>
                <button class="px-6 py-2.5 bg-[#0ea5e9] text-white font-bold text-sm rounded-xl hover:bg-[#0284c7] transition shadow-md shadow-blue-200">Simpan Perubahan</button>
            </div>
        </div>

        <!-- Security Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <h3 class="font-bold text-gray-900">Keamanan</h3>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata sandi saat ini</label>
                    <input type="password" value="........" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kata sandi baru</label>
                    <input type="password" placeholder="Minimal 8 karakter" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
                </div>
                <button class="w-full py-2 bg-gray-50 border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-100 transition">Ubah Kata Sandi</button>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-2">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Verifikasi 2 langkah</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Kode tambahan saat masuk.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <h3 class="font-bold text-gray-900">Notifikasi</h3>
            </div>
            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Hasil scan siap</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Beritahu saat analisis AI selesai.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Pengingat minum obat</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Pengingat sesuai jadwal.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Tips kesehatan</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Ringkasan mingguan lewat email.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Privacy Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h3 class="font-bold text-gray-900">Privasi & Data</h3>
            </div>
            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Simpan riwayat scan</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Foto dan hasil scan disimpan di akunmu.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-800">Bantu tingkatkan AI</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">Gunakan hasil scan (tanpa identitas) untuk evaluasi.</p>
                    </div>
                    <div class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0ea5e9]"></div>
                    </div>
                </div>
                <button class="w-full py-2 bg-gray-50 border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-100 transition flex items-center justify-center gap-2 mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Data Saya
                </button>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50/50 rounded-3xl p-6 shadow-sm border border-red-100 h-fit">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="font-bold text-red-700">Zona Berbahaya</h3>
            </div>
            <p class="text-xs text-red-600/80 mb-5 leading-relaxed">Menghapus akun akan menghapus seluruh riwayat scan dan percakapan chatbot secara permanen.</p>
            <button class="w-full py-2.5 bg-red-500 text-white font-bold text-xs rounded-xl hover:bg-red-600 transition shadow-md shadow-red-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Akun
            </button>
        </div>
    </div>
</x-app-layout>