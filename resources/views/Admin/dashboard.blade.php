<x-app-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div><h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Monitoring</h2><p class="text-gray-500 mt-1 text-sm">Ringkasan aktivitas platform dari database aktual.</p></div>
        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl shadow-sm hover:bg-gray-50 transition">Perbarui data</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Total pengguna</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Total AI scan</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalScans) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Percakapan chatbot</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalChats) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Scan ditolak</p><h3 class="text-3xl font-bold text-red-600 mt-2">{{ number_format($totalRejected) }}</h3></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-900 text-lg mb-6">Aktivitas 7 hari terakhir</h3>
            @php($maxActivity = max(1, collect($dailyActivity)->max(fn ($day) => $day['scans'] + $day['chats'])))
            <div class="grid grid-cols-7 gap-3 items-end h-56">
                @foreach($dailyActivity as $day)
                    @php($total = $day['scans'] + $day['chats'])
                    <div class="group relative flex flex-col items-center gap-2 h-full justify-end">
                        <div class="pointer-events-none absolute bottom-7 left-1/2 z-10 w-32 -translate-x-1/2 translate-y-2 rounded-lg bg-gray-900 px-3 py-2 text-center text-[11px] leading-5 text-white opacity-0 shadow-lg transition duration-150 group-hover:translate-y-0 group-hover:opacity-100">
                            <strong class="block">{{ $day['date'] }}</strong>
                            <span class="block">Scan: {{ number_format($day['scans']) }}</span>
                            <span class="block">Chat: {{ number_format($day['chats']) }}</span>
                            <span class="block border-t border-white/20 pt-1">Total: {{ number_format($total) }}</span>
                        </div>
                        <div class="flex items-end gap-1 h-full w-full">
                            <div class="flex-1 bg-[#0ea5e9] rounded-t-sm transition-opacity group-hover:opacity-80" style="height: {{ $total ? max(4, $day['scans'] / $maxActivity * 100) : 0 }}%"></div>
                            <div class="flex-1 bg-[#bae6fd] rounded-t-sm transition-opacity group-hover:opacity-80" style="height: {{ $total ? max(4, $day['chats'] / $maxActivity * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $day['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100"><h3 class="font-bold text-gray-900 text-lg mb-6">Komposisi aktivitas</h3>@php($totalDistribution = max(1, array_sum($distribution)))<div class="space-y-5"><div><div class="flex justify-between text-sm mb-1"><span>Scan obat</span><strong>{{ round($distribution['obat'] / $totalDistribution * 100, 1) }}%</strong></div><div class="h-2 bg-blue-100 rounded-full"><div class="h-2 bg-[#0ea5e9] rounded-full" style="width: {{ $distribution['obat'] / $totalDistribution * 100 }}%"></div></div></div><div><div class="flex justify-between text-sm mb-1"><span>Scan luka</span><strong>{{ round($distribution['luka'] / $totalDistribution * 100, 1) }}%</strong></div><div class="h-2 bg-green-100 rounded-full"><div class="h-2 bg-green-500 rounded-full" style="width: {{ $distribution['luka'] / $totalDistribution * 100 }}%"></div></div></div><div><div class="flex justify-between text-sm mb-1"><span>Chatbot</span><strong>{{ round($distribution['chat'] / $totalDistribution * 100, 1) }}%</strong></div><div class="h-2 bg-sky-100 rounded-full"><div class="h-2 bg-sky-300 rounded-full" style="width: {{ $distribution['chat'] / $totalDistribution * 100 }}%"></div></div></div></div></div>
    </div>
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex justify-between items-center mb-6"><h3 class="font-bold text-gray-900 text-lg">Aktivitas terbaru</h3><a href="{{ route('admin.monitoring') }}" class="text-sm font-bold text-[#0ea5e9] hover:underline">Lihat monitoring</a></div>
        <div class="space-y-3">
            @forelse($recentLogs as $log)
                <div class="flex justify-between items-center p-3 rounded-xl border border-gray-100"><div><p class="text-sm font-bold text-gray-900">{{ str_replace('_', ' ', $log->event_type) }}</p><p class="text-xs text-gray-500">{{ $log->user?->name ?? 'Sistem' }} · {{ $log->created_at->diffForHumans() }}</p></div><span class="text-[10px] bg-blue-50 text-blue-600 font-bold px-2.5 py-1 rounded-md">Audit</span></div>
            @empty
                <p class="text-sm text-gray-500">Belum ada aktivitas audit.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
