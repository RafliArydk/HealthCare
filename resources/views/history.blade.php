<x-app-layout>
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Pemeriksaan</h2>
            <p class="text-gray-500 mt-2 text-sm">Semua riwayat scan dan konsultasi kesehatanmu tersimpan di sini.</p>
        </div>
        <a href="{{ route('history.export', request()->query()) }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Ekspor CSV
        </a>
    </div>

    <form method="GET" action="{{ route('history.index') }}" data-ajax-filter class="flex flex-wrap gap-3 mb-6">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari aktivitas..." class="w-64 bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
        <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
        <select name="type" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <option value="">Semua kategori</option>
            <option value="obat" @selected(($filters['type'] ?? '') === 'obat')>Obat</option>
            <option value="luka" @selected(($filters['type'] ?? '') === 'luka')>Luka</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl shadow-sm hover:bg-[#0284c7] transition">Terapkan</button>
        <a href="{{ route('history.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition">Reset filter</a>
    </form>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider font-bold">
                    <th class="p-5 w-1/4">Aktivitas</th>
                    <th class="p-5 w-1/3">Detail Analisis</th>
                    <th class="p-5">Tanggal</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($scans as $scan)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Aktivitas -->
                        <td class="p-5 flex items-center gap-3 font-bold text-gray-800">
                            @php($scanType = $scan->type ?? $scan->cnn_label)
                            <div class="w-8 h-8 rounded-lg {{ $scanType == 'luka' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }} flex items-center justify-center">
                                @if($scanType == 'luka')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                @endif
                            </div>
                            Scan {{ ucfirst($scanType ?? 'ditolak') }}
                        </td>

                        <!-- Detail -->
                        <td class="p-5 text-gray-600">
                            {{ Str::limit(strip_tags($scan->initial_analysis), 50) }}
                        </td>

                        <!-- Tanggal -->
                        <td class="p-5 text-gray-500">
                            {{ $scan->created_at->format('d M Y, H:i') }}
                        </td>

                        <!-- Status -->
                        <td class="p-5">
                            <span class="{{ $scan->status === 'accepted' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} px-3 py-1 rounded-full text-xs font-bold">{{ $scan->status === 'accepted' ? 'Selesai' : 'Ditolak' }}</span>
                        </td>

                        <!-- Aksi -->
                        <td class="p-5 text-center">
                            <a href="{{ route('chat.index', $scan->id) }}" class="inline-block p-2 border border-gray-200 rounded-lg text-gray-400 hover:text-[#0ea5e9] hover:border-[#0ea5e9] transition" title="Lihat Detail & Chat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <!-- Tampilan jika belum ada data -->
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm font-medium">Belum ada riwayat pemeriksaan.</p>
                                <a href="{{ route('scan.index') }}" class="mt-4 px-6 py-2 bg-[#0ea5e9] text-white rounded-xl text-sm font-bold shadow-sm hover:bg-[#0284c7] transition">Mulai Scan Sekarang</a>
                            </div>

                            @if($scans->hasPages())
                                <div class="mb-6">{{ $scans->links() }}</div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-[#f0f9ff] border border-blue-100 rounded-2xl p-6 text-sm text-gray-600 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Data di atas adalah data asli dari hasil scan yang telah kamu lakukan. Klik ikon mata untuk melihat kembali hasil analisis lengkap dan melanjutkan obrolan dengan AI.
    </div>
</x-app-layout>