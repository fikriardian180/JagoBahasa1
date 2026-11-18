<x-admin-layout>
    <div class="space-y-6">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Selamat Datang, {{ $user->name }}!</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Kelola kelas, course, dan pantau progres civitas akademika.</p>
            </div>
            <span class="px-4 py-2 bg-sky-100 text-sky-900 dark:bg-sky-950 dark:text-sky-300 font-bold rounded-xl uppercase text-xs">Peran: {{ $user->role }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Total Kelas Aktif</span>
                <p class="text-3xl font-extrabold text-blue-900 dark:text-sky-400">2</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Total Course</span>
                <p class="text-3xl font-extrabold text-blue-900 dark:text-sky-400">2</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-2">
                <span class="text-xs font-bold text-slate-500 uppercase">Total Peserta Didik</span>
                <p class="text-3xl font-extrabold text-blue-900 dark:text-sky-400">10</p>
            </div>
        </div>
    </div>
</x-admin-layout>
