<x-app-layout>
    <!-- Header Halaman -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Monitoring Scan</h2>
            <p class="text-gray-500 mt-1 text-sm">Pantau aktivitas scan yang tersimpan di database.</p>
        </div>
        <!-- TOMBOL EXPORT CSV -->
        <a href="{{ route('admin.export.csv', request()->query()) }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Ekspor Dataset CSV
        </a>
    </div>

    <!-- 4 Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Scan Hari Ini -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Scan hari ini</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalScans) }}</h3>
                    <p class="text-xs font-semibold text-gray-400 mt-1">Total data</p>
            </div>
        </div>

        <!-- Berhasil -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Berhasil</span>
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($successfulScans) }}</h3>
                    <p class="text-xs font-semibold text-green-500 mt-1">{{ $totalScans ? round($successfulScans / $totalScans * 100, 1) : 0 }}% keberhasilan</p>
            </div>
        </div>

        <!-- Perlu Review -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Perlu review</span>
                <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($rejectedScans) }}</h3>
                    <p class="text-xs font-semibold text-gray-400 mt-1">Scan ditolak</p>
            </div>
        </div>

        <!-- Chat Aktif -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-sm font-medium text-gray-500">Chat aktif</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($activeChats) }}</h3>
                    <p class="text-xs font-semibold text-gray-400 mt-1">Sesi 30 menit terakhir</p>
            </div>
        </div>
    </div>

    <!-- Tabel Monitoring -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">

        <!-- Filter Bar -->
        <form method="GET" data-ajax-filter class="p-6 border-b border-gray-100 flex flex-wrap items-end gap-3">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, layanan, detail..." class="w-full md:w-80 bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <label class="flex flex-col gap-1 text-[11px] font-semibold text-gray-500">
                Dari tanggal
                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500">
            </label>
            <label class="flex flex-col gap-1 text-[11px] font-semibold text-gray-500">
                Sampai tanggal
                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500">
            </label>
            <select name="status" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500">
                <option value="">Semua status</option>
                <option value="accepted" @selected(($filters['status'] ?? '') === 'accepted')>Berhasil</option>
                <option value="rejected" @selected(($filters['status'] ?? '') === 'rejected')>Ditolak</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl shadow-sm hover:bg-[#0284c7] transition">Terapkan</button>
            <a href="{{ route('admin.monitoring') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition">Reset</a>
        </form>

        <!-- Tabel Dinamis -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider font-bold">
                        <th class="p-5 w-1/4">Pengguna</th>
                        <th class="p-5">Layanan</th>
                        <th class="p-5">Label CNN</th>
                        <th class="p-5">Waktu</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($scans as $scan)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Pengguna & Consent -->
                        <td class="p-5 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ $scan->user ? strtoupper(substr($scan->user->name, 0, 2)) : '?' }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $scan->user ? $scan->user->name : 'User Dihapus' }}</p>
                                <p class="text-[11px] text-gray-500">Consent: {{ $scan->consent_training ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </td>

                        <!-- Layanan -->
                        <td class="p-5 text-gray-700 capitalize">AI Scan {{ $scan->type ?? $scan->cnn_label ?? 'Tidak relevan' }}</td>

                        <!-- Detail / Label -->
                        <td class="p-5 text-gray-500">
                            <span class="font-bold uppercase">{{ $scan->cnn_label ?? '-' }}</span>
                            @if($scan->confidence_score)
                                <span class="text-xs">({{ round($scan->confidence_score * 100) }}%)</span>
                            @endif
                        </td>

                        <!-- Waktu -->
                        <td class="p-5 text-gray-500">{{ $scan->created_at->format('d M, H:i') }}</td>

                        <!-- Status -->
                        <td class="p-5">
                            @if(in_array($scan->status, ['accepted', 'success'], true))
                                <span class="bg-green-50 text-green-600 px-3 py-1 rounded-full text-xs font-bold">Berhasil</span>
                            @elseif($scan->status == 'rejected')
                                <span class="bg-red-50 text-red-600 px-3 py-1 rounded-full text-xs font-bold">Ditolak</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">{{ $scan->status }}</span>
                            @endif
                        </td>

                        <!-- Aksi (Lihat Gambar) -->
                        <td class="p-5 text-center">
                            <a href="{{ asset('storage/' . $scan->image_path) }}" target="_blank" class="p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition inline-block" title="Lihat Gambar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-500">Belum ada data scan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $scans->links() }}</div>
    </div>
</x-app-layout>