<x-app-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div><h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Laporan & Analitik</h2><p class="text-gray-500 mt-1 text-sm">Ringkasan aktivitas berdasarkan data aktual.</p></div>
        <a href="{{ route('admin.export.csv', $filters) }}" class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl shadow-md hover:bg-[#0284c7] transition">Ekspor Dataset</a>
    </div>

    <form method="GET" class="mb-8 flex flex-wrap items-end gap-3">
        <label class="flex flex-col gap-1 text-[11px] font-semibold text-gray-500">
            Dari tanggal
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4">
        </label>
        <label class="flex flex-col gap-1 text-[11px] font-semibold text-gray-500">
            Sampai tanggal
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4">
        </label>
        <button class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl">Terapkan</button>
        <a href="{{ route('admin.reports') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl">Reset</a>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Total aktivitas</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalActivities) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Scan berhasil</p><h3 class="text-3xl font-bold text-green-600 mt-2">{{ number_format($accepted) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Scan ditolak</p><h3 class="text-3xl font-bold text-red-600 mt-2">{{ number_format($rejected) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Rasio berhasil</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $accepted + $rejected ? round($accepted / ($accepted + $rejected) * 100, 1) : 0 }}%</h3></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-900 text-lg mb-6">Aktivitas 7 hari terakhir</h3>
            <div class="grid grid-cols-7 gap-3 items-end h-56">
                @php($maxActivity = max(1, collect($dailyActivity)->max(fn ($day) => $day['scans'] + $day['chats'])))
                @foreach($dailyActivity as $day)
                    @php($total = $day['scans'] + $day['chats'])
                    <div class="group relative flex flex-col items-center gap-2 h-full justify-end">
                        <div class="pointer-events-none absolute bottom-7 left-1/2 z-10 w-32 -translate-x-1/2 translate-y-2 rounded-lg bg-gray-900 px-3 py-2 text-center text-[11px] leading-5 text-white opacity-0 shadow-lg transition duration-150 group-hover:translate-y-0 group-hover:opacity-100">
                            <strong class="block">{{ $day['date'] }}</strong>
                            <span class="block">Scan: {{ number_format($day['scans']) }}</span>
                            <span class="block">Chat: {{ number_format($day['chats']) }}</span>
                            <span class="block border-t border-white/20 pt-1">Total: {{ number_format($total) }}</span>
                        </div>
                        <div class="w-full bg-blue-100 rounded-t-lg transition-opacity group-hover:opacity-80" style="height: {{ max(6, ($total / $maxActivity) * 100) }}%">
                            <div class="w-full bg-[#0ea5e9] rounded-t-lg" style="height: {{ $total ? ($day['scans'] / $total) * 100 : 0 }}%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100"><h3 class="font-bold text-gray-900 text-lg mb-6">Distribusi scan</h3><div class="space-y-5"><div><div class="flex justify-between text-sm mb-1"><span>Obat</span><strong>{{ number_format($distribution['obat']) }}</strong></div><div class="h-2 bg-blue-100 rounded-full"><div class="h-2 bg-[#0ea5e9] rounded-full" style="width: {{ ($distribution['obat'] + $distribution['luka']) ? $distribution['obat'] / ($distribution['obat'] + $distribution['luka']) * 100 : 0 }}%"></div></div></div><div><div class="flex justify-between text-sm mb-1"><span>Luka</span><strong>{{ number_format($distribution['luka']) }}</strong></div><div class="h-2 bg-green-100 rounded-full"><div class="h-2 bg-green-500 rounded-full" style="width: {{ ($distribution['obat'] + $distribution['luka']) ? $distribution['luka'] / ($distribution['obat'] + $distribution['luka']) * 100 : 0 }}%"></div></div></div></div></div>
    </div>
</x-app-layout>
