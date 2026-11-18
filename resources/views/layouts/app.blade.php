<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JagoBahasa') }} — Inklusif LMS (YLIC 2026)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased flex flex-col justify-between selection:bg-sky-500 selection:text-white">
    
    <!-- Skip to Main Content Link -->
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    <div>
        <!-- Accessibility Toolbar -->
        @include('components.accessibility-toolbar')

        <!-- Navigation Bar -->
        <nav class="sticky top-0 z-40 bg-white dark:bg-zinc-900 border-b border-slate-200 dark:border-zinc-800 shadow-sm" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-8">
                        <!-- Logo -->
                        <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 font-extrabold text-xl text-blue-900 dark:text-sky-400">
                            <span class="bg-blue-900 text-white dark:bg-sky-500 dark:text-zinc-950 p-2 rounded-xl shadow">JB</span>
                            <span>JagoBahasa</span>
                        </a>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-700 dark:text-slate-300">
                            <a href="{{ route('welcome') }}" class="hover:text-blue-900 dark:hover:text-sky-400 transition">Beranda</a>
                            <a href="#" class="hover:text-blue-900 dark:hover:text-sky-400 transition">Katalog Course</a>
                            @auth
                                <a href="#" class="hover:text-blue-900 dark:hover:text-sky-400 transition">Dashboard Saya</a>
                                <a href="#" class="hover:text-blue-900 dark:hover:text-sky-400 transition">Leaderboard</a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Side / Auth & Gamification Badges -->
                    <div class="hidden md:flex items-center gap-4">
                        @auth
                            <div class="flex items-center gap-3 bg-slate-100 dark:bg-zinc-800 px-3 py-1.5 rounded-full text-xs font-bold text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-zinc-700">
                                <span title="Daily Streak">🔥 {{ auth()->user()->current_streak ?? 0 }} Streak</span>
                                <span class="text-slate-300 dark:text-zinc-600">|</span>
                                <span title="Total XP">⚡ {{ auth()->user()->xp_points ?? 0 }} XP</span>
                            </div>

                            <!-- User Dropdown Menu -->
                            <div class="relative" x-data="{ dropdownOpen: false }">
                                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:text-blue-900 dark:hover:text-sky-400">
                                    <span>{{ auth()->user()->name }}</span>
                                    <span class="text-xs bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-200 px-2 py-0.5 rounded uppercase">{{ auth()->user()->role }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="dropdownOpen" @click.outside="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-zinc-900 rounded-lg shadow-lg border border-slate-200 dark:border-zinc-800 py-1 z-50">
                                    @if(in_array(auth()->user()->role, ['admin', 'lecturer']))
                                        <a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800">Panel Pengelolaan</a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-zinc-800">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-blue-900 dark:hover:text-sky-400">Masuk</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 dark:bg-sky-500 dark:hover:bg-sky-400 dark:text-zinc-950 text-white text-sm font-bold rounded-xl shadow transition">Daftar Gratis</a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = !open" class="p-2 rounded-md text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="md:hidden border-t border-slate-200 dark:border-zinc-800 px-4 pt-2 pb-4 space-y-2">
                <a href="{{ route('welcome') }}" class="block py-2 text-slate-700 dark:text-slate-300 font-semibold">Beranda</a>
                @auth
                    <div class="py-2 border-t border-slate-200 dark:border-zinc-800 text-xs font-bold text-amber-600">
                        🔥 {{ auth()->user()->current_streak }} Streak | ⚡ {{ auth()->user()->xp_points }} XP
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-rose-600 font-semibold">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-slate-700 dark:text-slate-300 font-semibold">Masuk</a>
                    <a href="{{ route('register') }}" class="block py-2 text-blue-900 dark:text-sky-400 font-bold">Daftar Gratis</a>
                @endauth
            </div>
        </nav>

        <!-- Main Content Slot -->
        <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-zinc-900 border-t border-slate-200 dark:border-zinc-800 py-6 mt-12 text-center text-xs text-slate-500 dark:text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>JagoBahasa — Kompetisi YLIC YO-FEST 2026 • <em>Pendidikan untuk Semua, Masa Depan untuk Bersama</em></p>
            <div class="flex gap-4">
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
                <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                <a href="#" class="hover:underline">Panduan Aksesibilitas</a>
            </div>
        </div>
    </footer>
</body>
</html>
