<x-app-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Data Pengguna</h2>
        <p class="text-gray-500 mt-1 text-sm">Kelola akun pengguna yang terdaftar.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Total akun</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Aktif 30 hari</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($activeUsers) }}</h3></div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100"><p class="text-sm text-gray-500">Pendaftaran 7 hari</p><h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($newUsers) }}</h3></div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <form method="GET" data-ajax-filter class="p-6 border-b border-gray-100 flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama atau email..." class="w-full md:w-80 bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 focus:ring-[#0ea5e9] focus:border-[#0ea5e9]">
            <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="bg-white border border-gray-200 text-sm rounded-xl py-2.5 px-4 text-gray-500">
            <button type="submit" class="px-5 py-2.5 bg-[#0ea5e9] text-white text-sm font-bold rounded-xl">Terapkan</button>
            <a href="{{ route('admin.users') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl">Reset</a>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead><tr class="bg-gray-50/50 border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wider font-bold"><th class="p-5">Pengguna</th><th class="p-5">Email</th><th class="p-5">Bergabung</th><th class="p-5">Aktivitas terakhir</th></tr></thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-5 flex items-center gap-3"><div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($user->name, 0, 2)) }}</div><div><p class="font-bold text-gray-800">{{ $user->name }}</p><p class="text-[11px] text-gray-500">Pengguna</p></div></td>
                            <td class="p-5 text-gray-600">{{ $user->email }}</td>
                            <td class="p-5 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-5 text-gray-500">{{ $user->updated_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-10 text-center text-gray-500">Tidak ada pengguna yang cocok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $users->links() }}</div>
    </div>
</x-app-layout>
