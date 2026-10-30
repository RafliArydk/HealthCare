<x-app-layout>
    <div class="mb-8"><h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h2><p class="text-gray-500 mt-2 text-sm">Kelola profil dan keamanan akunmu.</p></div>

    @if(session('status'))
        <div class="mb-6 rounded-xl bg-green-50 px-4 py-3 text-sm font-medium text-green-700">Perubahan berhasil disimpan.</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
            <div class="flex items-center gap-5 mb-8 pb-8 border-b border-gray-100">
                @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="Foto profil {{ Auth::user()->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-white shadow-sm">
                @else
                    <div class="w-20 h-20 bg-[#0ea5e9] text-white rounded-full flex items-center justify-center font-bold text-2xl">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                @endif
                <div><h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3><p class="text-sm text-gray-500">{{ Auth::user()->email }}</p><span class="inline-block mt-2 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded">Akun {{ Auth::user()->role }}</span></div>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2"><label for="profile_photo" class="block text-xs font-bold text-gray-700 mb-1.5">Foto profil</label><input id="profile_photo" name="profile_photo" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-[#0284c7] hover:file:bg-blue-100"><p class="mt-1 text-xs text-gray-400">JPG, PNG, atau WEBP, maksimal 5 MB.</p><x-input-error :messages="$errors->get('profile_photo')" class="mt-1" /></div>
                    <div class="md:col-span-2"><label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">Nama lengkap</label><input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]"><x-input-error :messages="$errors->get('name')" class="mt-1" /></div>
                    <div class="md:col-span-2"><label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">Email</label><input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:ring-[#0ea5e9] focus:border-[#0ea5e9]"><x-input-error :messages="$errors->get('email')" class="mt-1" /></div>
                </div>
                <button class="mt-8 px-6 py-2.5 bg-[#0ea5e9] text-white font-bold text-sm rounded-xl hover:bg-[#0284c7] transition">Simpan Profil</button>
            </form>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-fit">
            <h3 class="font-bold text-gray-900 mb-6">Keamanan</h3>
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf @method('PUT')
                <div><label for="current_password" class="block text-xs font-bold text-gray-700 mb-1">Kata sandi saat ini</label><input id="current_password" name="current_password" type="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-sm"><x-input-error :messages="$errors->get('current_password')" class="mt-1" /></div>
                <div><label for="password" class="block text-xs font-bold text-gray-700 mb-1">Kata sandi baru</label><input id="password" name="password" type="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-sm"><x-input-error :messages="$errors->get('password')" class="mt-1" /></div>
                <div><label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-1">Konfirmasi kata sandi</label><input id="password_confirmation" name="password_confirmation" type="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 text-sm"></div>
                <button class="w-full py-2 bg-gray-50 border border-gray-200 text-gray-700 font-bold text-xs rounded-xl hover:bg-gray-100 transition">Ubah Kata Sandi</button>
            </form>
        </div>

        <div class="lg:col-span-3 bg-red-50/50 rounded-3xl p-6 shadow-sm border border-red-100">
            <h3 class="font-bold text-red-700">Zona Berbahaya</h3><p class="text-xs text-red-600/80 my-3">Menghapus akun akan menghapus seluruh data secara permanen.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" class="flex flex-wrap gap-3 items-end">
                @csrf @method('DELETE')
                <div><label for="delete_password" class="block text-xs font-bold text-red-700 mb-1">Konfirmasi kata sandi</label><input id="delete_password" name="password" type="password" required class="bg-white border border-red-200 rounded-xl py-2 px-3 text-sm"></div>
                <button class="px-5 py-2.5 bg-red-500 text-white font-bold text-xs rounded-xl hover:bg-red-600 transition">Hapus Akun</button>
            </form>
        </div>
    </div>
</x-app-layout>
