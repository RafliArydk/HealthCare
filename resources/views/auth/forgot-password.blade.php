<x-guest-layout>
    <div class="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div class="w-full max-w-[390px] rounded-2xl bg-white border border-[#d9effc] shadow-[0_12px_35px_rgba(14,165,233,0.08)] p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zm-3 3v8m0 0h3m-3 0H9"/></svg>
                </div>
                <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-[10px] font-bold text-[#0284c7]">Langkah 1 dari 3</span>
            </div>

            <h1 class="text-xl font-bold tracking-tight text-[#172033]">Lupa kata sandi?</h1>
            <p class="mt-1 text-xs leading-5 text-slate-500">Masukkan email akunmu. Kami akan mengirim kode verifikasi untuk mengatur ulang kata sandi.</p>

            <x-auth-session-status class="mt-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                @csrf
                <label for="email" class="block text-xs font-semibold text-[#172033]">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="mt-1.5 block w-full rounded-xl border-[#c7e8fb] px-3 py-2.5 text-xs placeholder:text-slate-400 focus:border-[#0ea5e9] focus:ring-[#0ea5e9]"
                    placeholder="nama@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />

                <button type="submit" class="mt-4 w-full rounded-xl bg-[#0ea5e9] py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#0284c7] focus:outline-none focus:ring-2 focus:ring-[#7dd3fc]">
                    Kirim Kode
                </button>
            </form>

            <a href="{{ route('login') }}" class="mt-5 flex items-center justify-center gap-2 text-xs font-bold text-[#0284c7] hover:text-[#0369a1]">
                <span aria-hidden="true">&lsaquo;</span> Kembali ke Masuk
            </a>
        </div>
    </div>
</x-guest-layout>
