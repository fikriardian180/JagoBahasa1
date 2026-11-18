<x-app-layout>
    <div class="space-y-8">
        <!-- Welcome & Motivation Bar -->
        <div class="bg-gradient-to-r from-blue-900 to-sky-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="bg-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Dashboard Pembelajar</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold">Halo, {{ $user->name }}!</h2>
                <p class="text-sky-100 text-sm">Terus pertahankan semangat belajar dan tingkatkan keterampilan bahasa Inggrismu hari ini.</p>
            </div>

            <div class="flex items-center gap-4 bg-blue-950/50 backdrop-blur px-6 py-4 rounded-2xl border border-sky-800/50">
                <div class="text-center">
                    <span class="text-xs text-sky-300 font-semibold uppercase">Streak</span>
                    <p class="text-2xl font-extrabold text-amber-400">🔥 {{ $user->current_streak }} Hari</p>
                </div>
                <div class="w-px h-10 bg-sky-800"></div>
                <div class="text-center">
                    <span class="text-xs text-sky-300 font-semibold uppercase">Total XP</span>
                    <p class="text-2xl font-extrabold text-sky-200">⚡ {{ $user->xp_points }} XP</p>
                </div>
            </div>
        </div>

        <!-- Join Classroom Form -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Gabung Kelas Baru</h3>
            <form action="{{ route('classrooms.join') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="join_code" placeholder="Masukkan Kode Kelas (mis. ENG-B1-2026)" required
                       class="flex-1 px-4 py-3 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 text-sm">
                <button type="submit" class="px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white font-bold rounded-xl text-sm transition">
                    Gabung Kelas
                </button>
            </form>
            @error('join_code')
                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
            @enderror
            @session('success')
                <p class="text-xs text-emerald-600 font-semibold">{{ session('success') }}</p>
            @endsession
        </div>

        <!-- Enrolled Classes & Courses Grid -->
        <div class="space-y-4">
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Kelas & Kursus yang Anda Ikuti</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4">
                    <span class="px-3 py-1 bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300 text-xs font-bold rounded-lg">Level B1</span>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">English for Academic Excellence</h4>
                    <p class="text-xs text-slate-500">Dosen: Dr. Ahmad Fauzi, M.Pd.</p>
                    <div class="w-full bg-slate-200 dark:bg-zinc-800 rounded-full h-2.5">
                        <div class="bg-sky-600 h-2.5 rounded-full" style="width: 45%"></div>
                    </div>
                    <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Progres: 45% Selesai</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
