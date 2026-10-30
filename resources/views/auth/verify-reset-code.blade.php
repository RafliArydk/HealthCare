<x-guest-layout>
    <div class="min-h-screen bg-[#f8fafc] flex items-center justify-center p-4">
        <div class="w-full max-w-[390px] rounded-2xl bg-white border border-[#d9effc] shadow-[0_12px_35px_rgba(14,165,233,0.08)] p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div class="w-10 h-10 rounded-xl bg-[#0ea5e9] text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v12H4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 7 8 6 8-6"/></svg>
                </div>
                <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-[10px] font-bold text-[#0284c7]">Langkah 2 dari 3</span>
            </div>

            <h1 class="text-xl font-bold tracking-tight text-[#172033]">Cek email kamu</h1>
            <p class="mt-1 text-xs leading-5 text-slate-500">Kami mengirim kode 6 digit ke <strong>{{ \Illuminate\Support\Str::mask($email, '*', 2, max(0, strpos($email, '@') - 2)) }}</strong>. Kode berlaku selama 10 menit.</p>

            <form method="POST" action="{{ route('password.verify.store') }}" id="verifyCodeForm" class="mt-4">
                @csrf
                <input type="hidden" name="code" id="verificationCode">
                <div class="grid grid-cols-6 gap-1.5 sm:gap-2">
                    @for ($index = 0; $index < 6; $index++)
                        <input type="text" inputmode="numeric" maxlength="1" autocomplete="{{ $index === 0 ? 'one-time-code' : 'off' }}"
                            class="verification-digit h-12 w-full rounded-xl border-[#c7e8fb] text-center text-lg font-bold text-[#172033] focus:border-[#0ea5e9] focus:ring-[#0ea5e9]"
                            aria-label="Digit {{ $index + 1 }}">
                    @endfor
                </div>
                <x-input-error :messages="$errors->get('code')" class="mt-2" />

                <p class="mt-3 text-[11px] text-slate-500">Belum menerima kode?</p>

                <button type="submit" class="mt-3 w-full rounded-xl bg-[#0ea5e9] py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-[#0284c7] focus:outline-none focus:ring-2 focus:ring-[#7dd3fc]">
                    Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('password.email') }}" class="mt-1">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" id="resendButton" disabled class="text-[11px] font-bold text-[#0284c7] disabled:cursor-not-allowed disabled:text-slate-400">
                    Kirim ulang dalam <span id="countdown">00:45</span>
                </button>
            </form>

            <a href="{{ route('password.request') }}" class="mt-5 block text-center text-xs font-bold text-[#0284c7] hover:text-[#0369a1]">Ganti email</a>
        </div>
    </div>

    @push('scripts')
        <script>
            const digits = [...document.querySelectorAll('.verification-digit')];
            const code = document.getElementById('verificationCode');
            const form = document.getElementById('verifyCodeForm');

            digits.forEach((input, index) => {
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/\D/g, '').slice(0, 1);
                    if (input.value && digits[index + 1]) digits[index + 1].focus();
                });
                input.addEventListener('keydown', (event) => {
                    if (event.key === 'Backspace' && !input.value && digits[index - 1]) digits[index - 1].focus();
                });
            });

            form.addEventListener('submit', () => {
                code.value = digits.map((input) => input.value).join('');
            });

            let remaining = 45;
            const countdown = document.getElementById('countdown');
            const resendButton = document.getElementById('resendButton');
            const timer = setInterval(() => {
                remaining -= 1;
                countdown.textContent = `00:${String(remaining).padStart(2, '0')}`;
                if (remaining <= 0) {
                    clearInterval(timer);
                    resendButton.disabled = false;
                    resendButton.textContent = 'Kirim ulang kode';
                }
            }, 1000);
        </script>
    @endpush
</x-guest-layout>
