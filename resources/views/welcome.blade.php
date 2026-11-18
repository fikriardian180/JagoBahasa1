<x-app-layout>
    <div class="space-y-16 py-6">
        
        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 text-xs font-bold border border-sky-200 dark:border-sky-800">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    YLIC YO-FEST 2026 • Pendidikan untuk Semua, Masa Depan untuk Bersama
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                    Inklusif, Interaktif & Berdampak: Platform LMS Bahasa Inggris <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-sky-500">JagoBahasa</span>
                </h1>

                <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    Solusi pembelajaran Bahasa Inggris berbasis web dengan <strong>Universal Accessibility (WCAG 2.1 AA)</strong>, <strong>Automated Speaking Lab</strong>, koreksi tata bahasa berbasis aturan, serta analitik dampak pembelajaran pre-test vs post-test yang dirancang untuk civitas akademika dan juri kompetisi.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('register') }}" class="px-6 py-3.5 bg-blue-900 hover:bg-blue-800 dark:bg-sky-500 dark:hover:bg-sky-400 dark:text-zinc-950 text-white font-bold rounded-2xl shadow-lg transition flex items-center gap-2">
                        <span>Mulai Belajar Gratis</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#sandbox" class="px-6 py-3.5 bg-white dark:bg-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-700 text-slate-800 dark:text-slate-200 font-bold rounded-2xl border border-slate-200 dark:border-zinc-700 shadow-sm transition">
                        Coba Demo Interaktif
                    </a>
                </div>
            </div>

            <!-- Right Hero: Interactive Live Sandbox (No Login Required) -->
            <div class="lg:col-span-5" id="sandbox" x-data="speakingSandbox()">
                <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-3xl shadow-xl border border-slate-200 dark:border-zinc-800 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400">Live Speaking & TTS Sandbox</span>
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-xs font-bold rounded-lg">Tanpa Login</span>
                    </div>

                    <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-2xl border border-slate-200 dark:border-zinc-700 space-y-2">
                        <span class="text-xs text-slate-500 font-semibold">Target Frasa Latihan:</span>
                        <p class="text-base sm:text-lg font-bold text-slate-900 dark:text-white" x-text="targetPhrase"></p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="playTTS()" class="flex-1 py-3 px-4 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                            Dengarkan Suara Asli
                        </button>
                        <button @click="simulateJuri()" class="flex-1 py-3 px-4 bg-amber-600 hover:bg-amber-500 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                            Simulasi Rekam Juri
                        </button>
                    </div>

                    <!-- Sandbox Result Panel -->
                    <template x-if="tested">
                        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl border border-emerald-200 dark:border-emerald-800 space-y-3 animate-fadeIn">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-800 dark:text-emerald-300">Hasil Analisis Pelafalan:</span>
                                <span class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400" x-text="score + '%'"></span>
                            </div>
                            <div class="text-xs text-slate-700 dark:text-slate-300 flex flex-wrap gap-1.5">
                                <span class="px-2 py-1 bg-emerald-200 dark:bg-emerald-900 text-emerald-900 dark:text-emerald-200 rounded font-bold">✓ Education [Tepat]</span>
                                <span class="px-2 py-1 bg-emerald-200 dark:bg-emerald-900 text-emerald-900 dark:text-emerald-200 rounded font-bold">✓ is [Tepat]</span>
                                <span class="px-2 py-1 bg-emerald-200 dark:bg-emerald-900 text-emerald-900 dark:text-emerald-200 rounded font-bold">✓ powerful [Tepat]</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- 1-Click Demo Login Panel for Judges (If SEED_DEMO=true) -->
        @if(config('lms.seed_demo'))
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2">
                    <span class="bg-amber-700 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest">Panel Khusus Dewan Juri</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold">Uji Coba Instan 1-Klik</h2>
                    <p class="text-amber-100 text-sm max-w-2xl">
                        Masuk ke dalam sistem secara instan tanpa perlu mendaftar untuk menguji fitur peran Mahasiswa, Dosen, maupun Administrator secara penuh.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('demo.login', 'student') }}" class="px-5 py-3 bg-white text-amber-900 hover:bg-amber-50 font-extrabold rounded-xl shadow transition text-sm">
                        👤 Masuk Mahasiswa
                    </a>
                    <a href="{{ route('demo.login', 'lecturer') }}" class="px-5 py-3 bg-white text-amber-900 hover:bg-amber-50 font-extrabold rounded-xl shadow transition text-sm">
                        👨‍🏫 Masuk Dosen
                    </a>
                    <a href="{{ route('demo.login', 'admin') }}" class="px-5 py-3 bg-white text-amber-900 hover:bg-amber-50 font-extrabold rounded-xl shadow transition text-sm">
                        🛡️ Masuk Admin
                    </a>
                </div>
            </div>
        @endif

        <!-- Civitas Segmentation Cards -->
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Dirancang Inklusif Untuk Seluruh Civitas</h2>
                <p class="text-slate-600 dark:text-slate-400">Setiap peran mendapatkan pengalaman yang disesuaikan dengan hak akses dan kebutuhan akademik spesifik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Mahasiswa -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 dark:bg-sky-950 text-sky-600 dark:text-sky-400 flex items-center justify-center font-bold text-xl">🎓</div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Mahasiswa</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Ikuti kelas dengan kode unik, pelajari 4 skills, latih pengucapan di Speaking Lab, dan raih XP.</p>
                </div>

                <!-- Card 2: Dosen -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold text-xl">👨‍🏫</div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Dosen / Pengajar</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Kelola course mandiri, buat kelas dengan kode bergabung, pantau mahasiswa tertinggal, dan unduh rekap nilai.</p>
                </div>

                <!-- Card 3: Tenaga Kependidikan -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xl">🏛️</div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tenaga Kependidikan</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Akses pembelajaran mandiri institusional untuk meningkatkan kapasitas profesional staf kampus.</p>
                </div>

                <!-- Card 4: Alumni & Tamu -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-slate-200 dark:border-zinc-800 shadow-sm space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-xl">🌟</div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Alumni & Juri Tamu</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Terhubung kembali dengan institusi dan eksplorasi seluruh course publik berstatus terbuka.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function speakingSandbox() {
        return {
            targetPhrase: 'Education is the most powerful weapon to change the world.',
            tested: false,
            score: 0,
            playTTS() {
                if ('speechSynthesis' in window) {
                    const u = new SpeechSynthesisUtterance(this.targetPhrase);
                    u.lang = 'en-US';
                    window.speechSynthesis.speak(u);
                } else {
                    alert('TTS tidak didukung.');
                }
            },
            simulateJuri() {
                this.tested = true;
                this.score = 96.5;
            }
        }
    }
    </script>
</x-app-layout>
