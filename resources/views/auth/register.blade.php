<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 md:p-8">
        
        <!-- Container Utama -->
        <div class="flex w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[750px] border border-gray-100">
            
            <!-- KIRI: Banner Biru -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-[#0ea5e9] to-[#0284c7] p-12 flex-col justify-between relative overflow-hidden">
                
                <!-- ===== ORNAMEN BACKGROUND BIRU ===== -->
                <!-- 1. Lingkaran Solid Transparan di Kanan Atas -->
                <div class="absolute -top-32 -right-32 w-[30rem] h-[30rem] bg-white opacity-10 rounded-full"></div>
                
                <!-- 2. Lingkaran Outline (Bolong) di Kiri Bawah -->
                <div class="absolute -bottom-24 -left-24 w-80 h-80 border-[30px] border-white opacity-15 rounded-full"></div>
                
                <!-- 3. Tanda Plus (+) Melayang -->
                <div class="absolute top-24 right-16 text-white opacity-40 text-7xl font-thin">+</div>
                <div class="absolute bottom-1/3 right-12 text-white opacity-30 text-5xl font-thin">+</div>
                <div class="absolute top-1/2 left-10 text-white opacity-20 text-6xl font-thin">+</div>
                <!-- =================================== -->

                <!-- Logo -->
                <div class="relative z-10 flex items-center gap-3 text-white">
                    <div class="bg-white text-[#0ea5e9] p-1.5 rounded-full shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <span class="text-xl font-bold">HealthCare</span>
                </div>

                <!-- Teks & Floating Cards -->
                <div class="relative z-10 mt-6 mb-auto">
                    <h1 class="text-4xl font-bold text-white mb-3 leading-tight drop-shadow-sm">
                        Mulai jaga kesehatanmu<br>hari ini
                    </h1>
                    <p class="text-blue-100 mb-10 text-sm font-medium">
                        Buat akun gratis dan dapatkan panduan awal dari AI dalam hitungan detik.
                    </p>

                    <!-- Simulasi UI Melayang -->
                    <div class="relative h-64 w-full">
                        <!-- Card 1: Luka -->
                        <div class="absolute top-0 left-0 bg-white p-3 rounded-xl shadow-xl border border-blue-50 w-64 transform -rotate-2 z-20">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    <span class="text-xs font-semibold text-gray-700">Luka lecet ringan</span>
                                </div>
                                <span class="text-xs bg-blue-50 text-blue-600 font-bold px-2 py-1 rounded">92%</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full"><div class="bg-blue-400 h-1.5 rounded-full w-[92%]"></div></div>
                        </div>
                        
                        <!-- Card 2: Chat -->
                        <div class="absolute top-16 right-0 bg-white p-3 rounded-xl shadow-xl border border-blue-50 w-56 transform rotate-2 z-10">
                            <div class="bg-[#0ea5e9] text-white text-[10px] p-2 rounded-lg rounded-tr-none inline-block mb-2 float-right">Perlu ganti perban tiap hari?</div>
                            <div class="clear-both"></div>
                            <div class="bg-gray-100 text-gray-700 text-[10px] p-2 rounded-lg rounded-tl-none inline-block">Umumnya sekali sehari, atau saat basah.</div>
                            <div class="clear-both"></div>
                        </div>

                        <!-- Card 3: Warning -->
                        <div class="absolute bottom-4 left-4 bg-white p-3 rounded-xl shadow-xl border-l-4 border-red-400 w-60 z-30">
                            <div class="flex gap-2 items-start">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="text-[10px] text-gray-600 font-medium">Segera ke dokter bila luka bernanah atau demam.</span>
                            </div>
                        </div>

                        <!-- Card 4: Obat -->
                        <div class="absolute bottom-[-10px] right-8 bg-white p-2 rounded-full shadow-xl border border-blue-50 z-30 flex items-center gap-2 px-4">
                            <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <span class="text-[10px] font-bold text-gray-700">Paracetamol 500 mg dikenali</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Banner -->
                <div class="relative z-10 text-[11px] text-blue-100 flex items-center gap-2 mt-8 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Data kamu terenkripsi dan tidak dibagikan
                </div>
            </div>

            <!-- KANAN: Form Register -->
            <!-- Background Titik-titik Biru (Diperbesar & Diperjelas) -->
            <div class="flex w-full flex-col justify-center px-8 md:w-1/2 lg:px-16 bg-white p-8 relative" 
                 style="background-image: radial-gradient(#bae6fd 2.5px, transparent 2.5px); background-size: 24px 24px;">
                
                <!-- Card Form Putih -->
                <div class="w-full max-w-md mx-auto bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 relative z-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Buat akun</h1>
                    <p class="text-gray-500 mb-6 text-sm">Hanya butuh satu menit.</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-xs font-semibold text-gray-600 mb-1">Nama lengkap</label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4" placeholder="Nama kamu" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4" placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-xs font-semibold text-gray-600 mb-1">Kata sandi</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 pr-10" placeholder="Minimal 8 karakter" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            
                            <!-- Bar Kekuatan Sandi -->
                            <div class="mt-2">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-[10px] text-gray-500" id="strength-text">Kekuatan sandi: Sedang</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div id="strength-bar" class="h-1.5 rounded-full w-1/2 bg-blue-400 transition-all duration-300"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1">Konfirmasi kata sandi</label>
                            <div class="relative">
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 pr-10" placeholder="Ulangi kata sandi" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>

                        <!-- Syarat & Ketentuan -->
                        <div class="mb-6 flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 text-[#0ea5e9] cursor-pointer">
                            </div>
                            <label for="terms" class="ml-2 text-xs font-normal text-gray-600 cursor-pointer leading-tight">
                                Saya setuju dengan <a href="#" class="text-[#0ea5e9] font-semibold hover:underline">Syarat & Ketentuan</a> serta kebijakan privasi.
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-[#0ea5e9] text-white py-3 rounded-xl font-semibold hover:bg-[#0284c7] transition shadow-md shadow-blue-200">
                            Daftar
                        </button>

                        <p class="mt-4 text-center text-xs text-gray-600">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#0ea5e9] font-bold hover:underline">Masuk</a>
                        </p>
                    </form>
                </div>
                
                <p class="mt-6 text-center text-[10px] text-gray-400 relative z-10">
                    Bukan pengganti diagnosis dokter. Darurat? Hubungi 119.
                </p>
            </div>
        </div>
    </div>

    <!-- Script Kekuatan Sandi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthText = document.getElementById('strength-text');
            const strengthBar = document.getElementById('strength-bar');

            passwordInput.addEventListener('input', function() {
                const val = passwordInput.value;
                let score = 0;
                
                if (val.length >= 8) score++;
                if (val.match(/[a-z]/)) score++;
                if (val.match(/[A-Z]/)) score++;
                if (val.match(/[0-9]/)) score++;
                if (val.match(/[^a-zA-Z0-9]/)) score++;

                if (val.length === 0) {
                    strengthText.innerText = 'Kekuatan sandi: Menunggu';
                    strengthText.className = 'text-[10px] text-gray-500';
                    strengthBar.style.width = '0%';
                    strengthBar.className = 'h-1.5 rounded-full w-0 transition-all duration-300';
                } else if (score <= 2) {
                    strengthText.innerText = 'Kekuatan sandi: Lemah';
                    strengthText.className = 'text-[10px] text-red-500 font-semibold';
                    strengthBar.style.width = '33%';
                    strengthBar.className = 'h-1.5 rounded-full bg-red-500 transition-all duration-300';
                } else if (score <= 4) {
                    strengthText.innerText = 'Kekuatan sandi: Sedang';
                    strengthText.className = 'text-[10px] text-yellow-500 font-semibold';
                    strengthBar.style.width = '66%';
                    strengthBar.className = 'h-1.5 rounded-full bg-yellow-400 transition-all duration-300';
                } else {
                    strengthText.innerText = 'Kekuatan sandi: Kuat';
                    strengthText.className = 'text-[10px] text-green-500 font-semibold';
                    strengthBar.style.width = '100%';
                    strengthBar.className = 'h-1.5 rounded-full bg-green-500 transition-all duration-300';
                }
            });
        });
    </script>
</x-guest-layout>