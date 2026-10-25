<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#f8fafc] p-4 md:p-8">
        
        <!-- Container Utama -->
        <div class="flex w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden min-h-[700px] border border-gray-100">
            
            <!-- KIRI: Form Login -->
            <!-- Background Titik-titik Biru -->
            <div class="flex w-full flex-col justify-center px-8 md:w-1/2 lg:px-16 bg-white p-8 relative" 
                 style="background-image: radial-gradient(#bae6fd 2.5px, transparent 2.5px); background-size: 24px 24px;">
                
                <!-- Card Form Putih -->
                <div class="w-full max-w-md mx-auto bg-white p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 relative z-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Masuk</h1>
                    <p class="text-gray-500 mb-6 text-sm">Selamat datang kembali! Silakan masuk ke akunmu.</p>

                    <!-- Session Status (Muncul kalau ada pesan sukses reset password, dll) -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4" placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-xs font-semibold text-gray-600 mb-1">Kata sandi</label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm py-3 px-4 pr-10" placeholder="Masukkan kata sandi" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mb-6 mt-2">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0ea5e9] shadow-sm focus:ring-[#0ea5e9] cursor-pointer" name="remember">
                                <span class="ms-2 text-xs text-gray-600">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-xs text-[#0ea5e9] font-semibold hover:underline" href="{{ route('password.request') }}">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-[#0ea5e9] text-white py-3 rounded-xl font-semibold hover:bg-[#0284c7] transition shadow-md shadow-blue-200">
                            Masuk
                        </button>

                        <p class="mt-6 text-center text-xs text-gray-600">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-[#0ea5e9] font-bold hover:underline">Daftar</a>
                        </p>
                    </form>
                </div>
                
                <p class="mt-6 text-center text-[10px] text-gray-400 relative z-10">
                    Bukan pengganti diagnosis dokter. Darurat? Hubungi 119.
                </p>
            </div>

            <!-- KANAN: Banner Biru -->
            <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-[#0ea5e9] to-[#0284c7] p-12 flex-col justify-between relative overflow-hidden">
                
                <!-- ===== ORNAMEN BACKGROUND BIRU ===== -->
                <!-- 1. Lingkaran Solid Transparan di Kiri Bawah -->
                <div class="absolute -bottom-32 -left-32 w-[30rem] h-[30rem] bg-white opacity-10 rounded-full"></div>
                
                <!-- 2. Lingkaran Outline (Bolong) di Kanan Atas -->
                <div class="absolute -top-24 -right-24 w-80 h-80 border-[30px] border-white opacity-15 rounded-full"></div>
                
                <!-- 3. Tanda Plus (+) Melayang -->
                <div class="absolute top-1/3 left-12 text-white opacity-40 text-7xl font-thin">+</div>
                <div class="absolute bottom-24 right-20 text-white opacity-30 text-5xl font-thin">+</div>
                <div class="absolute top-12 right-1/4 text-white opacity-20 text-6xl font-thin">+</div>
                <!-- =================================== -->

                <!-- Logo -->
                <div class="relative z-10 flex items-center gap-3 text-white">
                    <div class="bg-white text-[#0ea5e9] p-1.5 rounded-full shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <span class="text-xl font-bold">HealthCare</span>
                </div>

                <!-- Teks Utama -->
                <div class="relative z-10 mt-12 mb-auto">
                    <h1 class="text-4xl font-bold text-white mb-4 leading-tight drop-shadow-sm">
                        Hello,<br>Welcome Back!
                    </h1>
                    <p class="text-blue-50 text-sm leading-relaxed max-w-md font-medium">
                        AI-powered drug/wound scanner apps instantly identify medications or analyze wound conditions via a phone's camera. Utilizing AI technology, provide accurate information and appropriate initial treatment recommendations.
                    </p>
                </div>

                <!-- Footer Banner -->
                <div class="relative z-10 text-[11px] text-blue-100 flex items-center gap-2 mt-8 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Data kamu terenkripsi dan tidak dibagikan
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>