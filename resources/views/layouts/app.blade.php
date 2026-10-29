<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>HealthCare</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8fafc]">
        <div class="flex h-screen overflow-hidden">

            <!-- ===== SIDEBAR KIRI ===== -->
            <aside class="w-72 bg-white border-r border-gray-100 flex-col hidden md:flex z-20">

                <!-- Logo Area -->
                <div class="h-20 flex items-center px-8 border-b border-gray-50">
                    <div class="bg-[#0ea5e9] text-white p-1.5 rounded-xl mr-3 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 tracking-tight">HealthCareAI</span>
                </div>

                @if(Auth::user()->role === 'admin')
                    <!-- ================= SIDEBAR ADMIN ================= -->
                    <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto">
                        <div>
                            <p class="px-4 text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-widest">Menu Utama</p>
                            <div class="space-y-1">
                                <!-- Dashboard Admin -->
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Dashboard
                                </a>

                                <!-- Monitoring Scan -->
                                <a href="{{ route('admin.monitoring') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.monitoring') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    Monitoring Scan
                                </a>

                                <!-- Data Pengguna -->
                                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Data Pengguna
                                </a>

                                <!-- Laporan & Analitik -->
                                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.reports') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Laporan & Analitik
                                </a>
                            </div>
                        </div>

                        <div>
                            <p class="px-4 text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-widest">Preferensi</p>
                            <div class="space-y-1">
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('settings.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Pengaturan
                                </a>
                                <a href="{{ route('help.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('help.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Pusat Bantuan
                                </a>
                            </div>
                        </div>
                    </nav>

                    <!-- Footer Admin -->
                    <div class="p-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-[#0ea5e9] flex items-center justify-center font-bold text-sm">
                                    AH
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Admin HealthCare</p>
                                    <p class="text-[11px] text-gray-500">Administrator</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <!-- ================= SIDEBAR USER ================= -->
                    <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto">
                        <div>
                            <p class="px-4 text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-widest">Menu Utama</p>
                            <div class="space-y-1">
                                <!-- Dashboard User -->
                                <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        Ringkasan
                                    </div>
                                </a>

                                <!-- AI Scan -->
                                <a href="{{ route('scan.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('scan.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                        AI Scan
                                    </div>
                                </a>

                                <!-- CareBot Chat -->
                                <a href="{{ route('chat.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('chat.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        CareBot Chat
                                    </div>
                                </a>

                                <!-- Riwayat -->
                                <a href="{{ route('history.index') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('history.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Riwayat Pemeriksaan
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div>
                            <p class="px-4 text-[10px] font-bold text-gray-400 mb-3 uppercase tracking-widest">Preferensi</p>
                            <div class="space-y-1">
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('settings.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Pengaturan
                                </a>
                                <a href="{{ route('help.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('help.index') ? 'bg-[#e0f2fe] text-[#0284c7] font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 font-medium' }} rounded-xl transition group">
                                    <svg class="w-5 h-5 group-hover:text-[#0ea5e9] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Pusat Bantuan
                                </a>
                            </div>
                        </div>
                    </nav>

                    <!-- Promo Card -->
                    <div class="px-4 pb-4">
                        <div class="bg-[#e0f2fe] rounded-2xl p-5 relative overflow-hidden">
                            <div class="absolute -top-4 -right-4 text-[#bae6fd] opacity-50">
                                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-bold text-gray-900 text-sm mb-1">Butuh jawaban?</h4>
                                <p class="text-[11px] text-gray-600 mb-4 leading-relaxed">Mulai percakapan untuk pertanyaan kesehatan umum.</p>
                                <a href="{{ route('chat.index') }}" class="inline-flex items-center justify-center w-full bg-white text-[#0ea5e9] text-xs font-bold py-2 rounded-lg shadow-sm hover:bg-gray-50 transition">
                                    Mulai chat
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer User -->
                    <div class="p-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#e0f2fe] text-[#0284c7] flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-gray-500 capitalize">Akun {{ Auth::user()->role }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-1.5 rounded-lg hover:bg-red-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </aside>

            <!-- ===== KONTEN KANAN ===== -->
            <main class="flex-1 flex flex-col overflow-hidden relative bg-[#f0f9ff]">
                <!-- Topbar -->
                <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-6 lg:px-8 z-10">
                    <!-- Breadcrumb Dinamis -->
                    <div class="flex items-center text-sm">
                        <span class="text-gray-400 font-medium">HealthCare AI</span>
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="font-bold text-gray-800">
                            @if(request()->routeIs('admin.dashboard'))
                                Dashboard Admin
                            @elseif(request()->routeIs('admin.monitoring'))
                                Monitoring Scan
                            @elseif(request()->routeIs('admin.users'))
                                Data Pengguna
                            @elseif(request()->routeIs('admin.reports'))
                                Laporan & Analitik
                            @elseif(request()->routeIs('scan.index'))
                                AI Scan
                            @elseif(request()->routeIs('chat.index'))
                                CareBot Chat
                            @elseif(request()->routeIs('history.index'))
                                Riwayat
                            @elseif(request()->routeIs('settings.index'))
                                Pengaturan
                            @elseif(request()->routeIs('help.index'))
                                Pusat Bantuan
                            @else
                                Dashboard
                            @endif
                        </span>
                    </div>

                    <div class="flex items-center gap-5 ml-auto">
                        <!-- Search Bar -->
                        <div class="relative hidden md:block w-64">
                            <input type="text" placeholder="Cari fitur..." class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl py-2 pl-4 pr-10 focus:outline-none focus:border-[#0ea5e9] focus:ring-1 focus:ring-[#0ea5e9] transition">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Notification Bell -->
                        <button class="text-gray-400 hover:text-gray-600 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-0 right-0 block w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                        <!-- Profil User -->
                        <div class="flex items-center gap-3 border-l border-gray-200 pl-5">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Konten Dinamis -->
                <div class="flex-1 overflow-y-auto p-6 md:p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>