<x-guest-layout>
    <div class="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div class="w-full max-w-[390px] rounded-2xl bg-white border border-[#d9effc] shadow-[0_12px_35px_rgba(14,165,233,0.08)] p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 4 6v5c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V6l-8-3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 12 2 2 4-4"/></svg>
                </div>
                <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-[10px] font-bold text-[#0284c7]">Langkah 3 dari 3</span>
            </div>

            <h1 class="text-xl font-bold tracking-tight text-[#172033]">Atur ulang kata sandi</h1>
            <p class="mt-1 text-xs leading-5 text-slate-500">Buat kata sandi baru yang kuat untuk melindungi akunmu.</p>

            <form method="POST" action="{{ route('password.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->input('token', $request->route('token')) }}">

                <label for="email" class="block text-xs font-semibold text-[#172033]">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username"
                    class="mt-1.5 block w-full rounded-xl border-[#c7e8fb] bg-slate-50 px-3 py-2.5 text-xs text-slate-500 focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />

                <label for="password" class="mt-3 block text-xs font-semibold text-[#172033]">Kata sandi baru</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                        class="mt-1.5 block w-full rounded-xl border-[#c7e8fb] px-3 py-2.5 pr-10 text-xs focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                    <button type="button" data-toggle-password="password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" aria-label="Tampilkan kata sandi">◉</button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />

                <label for="password_confirmation" class="mt-3 block text-xs font-semibold text-[#172033]">Konfirmasi kata sandi</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                        class="mt-1.5 block w-full rounded-xl border-[#c7e8fb] px-3 py-2.5 pr-10 text-xs focus:border-[#0ea5e9] focus:ring-[#0ea5e9]">
                    <button type="button" data-toggle-password="password_confirmation" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500" aria-label="Tampilkan kata sandi">◉</button>
                </div>

                <div class="mt-3 space-y-1 rounded-xl bg-[#eff8fe] p-3 text-[11px] text-slate-600">
                    <p data-rule="length">● Minimal 8 karakter</p>
                    <p data-rule="number">● Mengandung angka</p>
                    <p data-rule="uppercase">● Mengandung huruf kapital</p>
                </div>

                <button type="submit" class="mt-3 w-full rounded-xl bg-[#0ea5e9] py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#0284c7] focus:outline-none focus:ring-2 focus:ring-[#7dd3fc]">
                    Simpan Kata Sandi
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const password = document.getElementById('password');
            const rules = {
                length: (value) => value.length >= 8,
                number: (value) => /\d/.test(value),
                uppercase: (value) => /[A-Z]/.test(value),
            };

            password?.addEventListener('input', () => {
                Object.entries(rules).forEach(([name, check]) => {
                    const element = document.querySelector(`[data-rule="${name}"]`);
                    element.classList.toggle('text-[#0284c7]', check(password.value));
                });
            });

            document.querySelectorAll('[data-toggle-password]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.togglePassword);
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });
        </script>
    @endpush
</x-guest-layout>
