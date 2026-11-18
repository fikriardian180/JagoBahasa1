<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JagoBahasa') }} — Panel Manajemen (YLIC 2026)</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased bg-slate-100 dark:bg-zinc-950 flex flex-col justify-between">
    
    <!-- Skip to Main Content Link -->
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    <div class="min-h-screen flex flex-col">
        <!-- Accessibility Toolbar -->
        @include('components.accessibility-toolbar')

        <div class="flex-1 flex" x-data="{ sidebarOpen: false }">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-zinc-900 border-r border-slate-200 dark:border-zinc-800 transition-transform duration-300 md:translate-x-0 md:static flex flex-col">
                
                <!-- Brand Header -->
                <div class="h-16 flex items-center px-6 border-b border-slate-200 dark:border-zinc-800">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2.5 font-extrabold text-xl text-blue-900 dark:text-sky-400">
                        <span class="bg-blue-900 text-white dark:bg-sky-500 dark:text-zinc-950 p-2 rounded-xl shadow">JB</span>
                        <span>JagoBahasa Admin</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-semibold">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-sky-50 dark:bg-sky-950/50 text-blue-900 dark:text-sky-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard Utama
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Kelola Course & Materi
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Kelola Kelas & Kode Gabung
                    </a>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Kelola Pengguna & Institusi
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-zinc-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            Analisis Dampak Pembelajaran
                        </a>
                    @endif
                </div>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-slate-200 dark:border-zinc-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/30 dark:hover:bg-rose-900/50 text-rose-600 dark:text-rose-400 rounded-xl font-bold text-sm transition">Keluar</button>
                    </form>
                </div>
            </aside>

            <!-- Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Header Bar -->
                <header class="h-16 bg-white dark:bg-zinc-900 border-b border-slate-200 dark:border-zinc-800 px-6 flex items-center justify-between z-30">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-md text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-zinc-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-base sm:text-lg font-bold text-slate-800 dark:text-slate-100">
                            Panel {{ auth()->check() ? strtoupper(auth()->user()->role) : 'PENGELOLA' }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('welcome') }}" class="px-3 py-1.5 bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Lihat Tampilan Siswa
                        </a>
                        <div class="text-sm font-semibold text-slate-700 dark:text-slate-200 pl-3 border-l border-slate-200 dark:border-zinc-800">
                            {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                        </div>
                    </div>
                </header>

                <!-- Main Workspace Slot -->
                <main id="main-content" class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>
</html>
