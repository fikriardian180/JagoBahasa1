<div x-data="accessibilityManager()" 
     class="bg-slate-900 text-slate-100 px-4 py-2 text-xs sm:text-sm flex flex-wrap items-center justify-between gap-2 border-b border-slate-800"
     role="region" aria-label="Toolbar Aksesibilitas Global">
    
    <div class="flex items-center gap-2 sm:gap-4 flex-wrap">
        <span class="font-bold text-sky-400 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Aksesibilitas:
        </span>

        <!-- Font Sizing -->
        <div class="inline-flex rounded shadow-sm" role="group" aria-label="Ukuran Huruf">
            <button @click="decreaseFont()" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 rounded-l border border-slate-700 font-bold" aria-label="Perkecil Ukuran Huruf">A-</button>
            <button @click="resetFont()" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 border-t border-b border-slate-700" aria-label="Reset Ukuran Huruf">Normal</button>
            <button @click="increaseFont()" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 rounded-r border border-slate-700 font-bold" aria-label="Perbesar Ukuran Huruf">A+</button>
        </div>

        <!-- High Contrast Toggle -->
        <button @click="toggleHighContrast()" 
                :class="highContrast ? 'bg-amber-600 text-white' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'"
                class="px-2.5 py-1 rounded border border-slate-700 transition flex items-center gap-1"
                :aria-pressed="highContrast">
            <span>Kontras Tinggi</span>
        </button>

        <!-- Dyslexia Font Toggle -->
        <button @click="toggleDyslexicFont()" 
                :class="dyslexicFont ? 'bg-amber-600 text-white' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'"
                class="px-2.5 py-1 rounded border border-slate-700 transition"
                :aria-pressed="dyslexicFont">
            Font Disleksia
        </button>

        <!-- Reduce Motion Toggle -->
        <button @click="toggleReduceMotion()" 
                :class="reduceMotion ? 'bg-amber-600 text-white' : 'bg-slate-800 text-slate-200 hover:bg-slate-700'"
                class="px-2.5 py-1 rounded border border-slate-700 transition"
                :aria-pressed="reduceMotion">
            Kurangi Animasi
        </button>
    </div>

    <!-- Read Aloud (TTS) Controls -->
    <div class="flex items-center gap-2">
        <button @click="readAloud()" 
                class="px-3 py-1 bg-sky-700 hover:bg-sky-600 text-white rounded font-medium flex items-center gap-1.5 transition"
                aria-label="Baca Halaman dengan Suara">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15H3.8a1.76 1.76 0 01-1.76-1.76V9.412c0-.972.788-1.76 1.76-1.76h1.636l2.147-6.15A1.76 1.76 0 0111 5.882zM19.5 12a4.5 4.5 0 00-1.5-3.375M21.5 16.5a7.5 7.5 0 000-9"/></svg>
            <span x-text="isSpeaking ? 'Berhenti Membaca' : 'Baca Halaman (TTS)'"></span>
        </button>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('accessibilityManager', () => ({
        fontScale: localStorage.getItem('jb_font_scale') || '100%',
        highContrast: localStorage.getItem('jb_high_contrast') === 'true',
        dyslexicFont: localStorage.getItem('jb_dyslexic_font') === 'true',
        reduceMotion: localStorage.getItem('jb_reduce_motion') === 'true',
        isSpeaking: false,

        init() {
            this.applySettings();
        },

        applySettings() {
            // Font Scale
            document.documentElement.style.fontSize = this.fontScale;
            
            // High Contrast
            if (this.highContrast) {
                document.documentElement.classList.add('theme-high-contrast');
            } else {
                document.documentElement.classList.remove('theme-high-contrast');
            }

            // Dyslexia Font
            if (this.dyslexicFont) {
                document.body.classList.add('font-dyslexic');
            } else {
                document.body.classList.remove('font-dyslexic');
            }

            // Reduce Motion
            if (this.reduceMotion) {
                document.documentElement.classList.add('reduce-motion');
            } else {
                document.documentElement.classList.remove('reduce-motion');
            }
        },

        saveAndSync() {
            localStorage.setItem('jb_font_scale', this.fontScale);
            localStorage.setItem('jb_high_contrast', this.highContrast);
            localStorage.setItem('jb_dyslexic_font', this.dyslexicFont);
            localStorage.setItem('jb_reduce_motion', this.reduceMotion);
            this.applySettings();

            // Sync with backend if authenticated
            fetch('/preferences/accessibility', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    font_scale: this.fontScale,
                    high_contrast: this.highContrast,
                    dyslexic_font: this.dyslexicFont,
                    reduce_motion: this.reduceMotion
                })
            }).catch(err => console.error('Sync preference error:', err));
        },

        increaseFont() {
            if (this.fontScale === '100%') this.fontScale = '115%';
            else if (this.fontScale === '115%') this.fontScale = '130%';
            else if (this.fontScale === '130%') this.fontScale = '150%';
            this.saveAndSync();
        },

        decreaseFont() {
            if (this.fontScale === '150%') this.fontScale = '130%';
            else if (this.fontScale === '130%') this.fontScale = '115%';
            else if (this.fontScale === '115%') this.fontScale = '100%';
            this.saveAndSync();
        },

        resetFont() {
            this.fontScale = '100%';
            this.saveAndSync();
        },

        toggleHighContrast() {
            this.highContrast = !this.highContrast;
            this.saveAndSync();
        },

        toggleDyslexicFont() {
            this.dyslexicFont = !this.dyslexicFont;
            this.saveAndSync();
        },

        toggleReduceMotion() {
            this.reduceMotion = !this.reduceMotion;
            this.saveAndSync();
        },

        readAloud() {
            if (!('speechSynthesis' in window)) {
                alert('Web Speech API tidak didukung di browser ini.');
                return;
            }

            if (this.isSpeaking) {
                window.speechSynthesis.cancel();
                this.isSpeaking = false;
                return;
            }

            const mainContent = document.getElementById('main-content');
            const textToRead = mainContent ? mainContent.innerText : document.body.innerText;
            
            const utterance = new SpeechSynthesisUtterance(textToRead);
            utterance.lang = 'id-ID';
            utterance.rate = 1.0;
            
            utterance.onend = () => {
                this.isSpeaking = false;
            };

            utterance.onerror = () => {
                this.isSpeaking = false;
            };

            window.speechSynthesis.speak(utterance);
            this.isSpeaking = true;
        }
    }));
});
</script>
