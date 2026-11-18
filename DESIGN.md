# DESIGN SPECIFICATION (DESIGN.md)
## JagoBahasa — UI/UX, Visual Tokens & Component Architecture
**Acuan Utama:** `PRD.md` v1.1 (YLIC YO-FEST 2026 — *"Pendidikan untuk Semua, Masa Depan untuk Bersama"*)  
**Stack UI:** Laravel 12 Blade, Tailwind CSS, Alpine.js, Chart.js (Vite)  
**Target Standar:** WCAG 2.1 Level AA, Responsive Mobile-First (`360px` – `1440px`)

---

## 1. FILOSOFI DESAIN & PRINSIP ANTARMUKA

1. **Academic & Trustworthy:** Menggunakan estetika modern, bersih, dan terstruktur dengan ruang putih (*whitespace*) yang cukup agar materi bacaan bahasa Inggris mudah dicerna tanpa kelelahan mata.
2. **Inclusive by Default (WCAG 2.1 AA):** Seluruh elemen interaktif wajib memiliki rasio kontras teks minimal `4.5:1`, indikator fokus *keyboard* yang tegas (`focus-visible:ring-2`), target sentuh minimal `44x44 px` di layar sentuh, serta tidak pernah menyampaikan informasi **hanya** melalui warna (wajib disertai ikon atau label teks).
3. **Zero-Clutter Learning:** Pada halaman belajar (*Learning Room*), navigasi utama disederhanakan agar fokus pembelajar tertuju pada materi, audio, mikrofon *Speaking Lab*, dan umpan balik *Grammar*.
4. **Dual-Layout Separation:** Memisahkan secara visual antara ruang belajar/publik (`layouts/app.blade.php`) yang bernuansa hangat dan menyemangati, dengan ruang manajemen/analitik (`layouts/admin.blade.php`) yang padat informasi dan efisien.

---

## 2. DESIGN TOKENS (PALET WARNA, TIPOGRAFI & SPASI)

Seluruh warna didefinisikan menggunakan CSS Custom Properties pada `resources/css/app.css` agar peralihan antara **Mode Normal** dan **Mode Kontras Tinggi (*High Contrast*)** berjalan instan tanpa merusak tata letak.

### 2.1 Palet Warna (Standard Mode vs High Contrast Mode)

| Token CSS | Peran Visual | Mode Normal (Light) | High Contrast Mode | Rasio Kontras |
| :--- | :--- | :--- | :--- | :--- |
| `--bg-canvas` | Latar belakang utama halaman | `#F8FAFC` (Slate 50) | `#09090B` (Zinc 950) | — |
| `--bg-surface` | Latar belakang kartu, modal, navbar | `#FFFFFF` (White) | `#18181B` (Zinc 900) | — |
| `--text-primary` | Teks judul & paragraf bacaan utama | `#0F172A` (Slate 900) | `#FFFFFF` (Pure White) | > 15:1 |
| `--text-secondary` | Teks pendukung, label, metadata | `#475569` (Slate 600) | `#E4E4E7` (Zinc 200) | > 7:1 |
| `--brand-primary` | Warna utama (Tombol primer, aktif) | `#1E3A8A` (Blue 900) | `#38BDF8` (Sky 400) | > 8:1 |
| `--brand-accent` | Aksen CTA, highlight, XP & Streak | `#D97706` (Amber 600) | `#FACC15` (Yellow 400) | > 4.6:1 |
| `--semantic-success` | Status lulus, pelafalan tepat, progres | `#047857` (Emerald 700) | `#4ADE80` (Green 400) | > 5.4:1 |
| `--semantic-warning` | Peringatan, koreksi grammar minor | `#B45309` (Amber 700) | `#FBBF24` (Amber 400) | > 5.0:1 |
| `--semantic-danger` | Kata salah, error validasi, akun nonaktif | `#BE123C` (Rose 700) | `#FB7185` (Rose 400) | > 5.8:1 |
| `--border-subtle` | Garis batas kartu & pemisah tabel | `#E2E8F0` (Slate 200) | `#52525B` (Zinc 600) | — |

### 2.2 Tipografi & Aksesibilitas Huruf
- **Font Utama (UI & Navigasi):** `Plus Jakarta Sans` atau `Inter` (sans-serif geometris yang bersih).
- **Font Materi Bacaan (Reading Room):** `Merriweather` atau `Inter` dengan `line-height: 1.75` dan lebar maksimal paragraf `65ch` agar nyaman dibaca.
- **Font Ramah Disleksia (Toggle Aksesibilitas):** `OpenDyslexic` (bundel lokal di `public/fonts/` atau fallback `Comic Sans MS, sans-serif` jika font eksternal belum dimuat) dengan jarak antar-huruf (`letter-spacing: 0.05em`) dan jarak antar-kata (`word-spacing: 0.12em`) yang diperlebar.
- **Skala Ukuran Teks Dinamis:** Menggunakan unit `rem` pada seluruh komponen sehingga mengubah `html { font-size: 100% | 115% | 130% | 150% }` otomatis menskalakan seluruh tampilan secara proporsional tanpa teks terpotong.

---

## 3. ARSITEKTUR LAYOUT BLADE

### 3.1 `resources/views/layouts/app.blade.php` (User, Mahasiswa & Tamu)
```text
+-----------------------------------------------------------------------+
| [Skip to Main Content Link - sr-only focus:not-sr-only]               |
+-----------------------------------------------------------------------+
| @include('components.accessibility-toolbar')                          |
| [A-] [A+] | [Kontras Tinggi] | [Font Disleksia] | [Baca Halaman (TTS)]|
+-----------------------------------------------------------------------+
| TOP NAVBAR (Sticky, h-16, bg-surface, border-b)                       |
| [Logo JagoBahasa]   [Beranda] [Katalog Course] [Dashboard*] [Kelas*]  |
|                     [ID|EN]  [🔥 5 Streak*] [⚡ 420 XP*] [Profil v]   |
+-----------------------------------------------------------------------+
| <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 py-8">  |
|    {{ $slot }}                                                        |
| </main>                                                               |
+-----------------------------------------------------------------------+
| FOOTER (bg-surface, border-t)                                         |
| JagoBahasa — YLIC YO-FEST 2026 | Kebijakan Privasi | Panduan Akses    |
+-----------------------------------------------------------------------+
(* tampil saat user login)
```

### 3.2 `resources/views/layouts/admin.blade.php` (Panel Admin & Dosen)
```text
+-----------------------------------------------------------------------+
| [Skip to Main Content Link]                                           |
+-----------------------------------------------------------------------+
| @include('components.accessibility-toolbar')                          |
+-------------------+---------------------------------------------------+
| SIDEBAR (w-64)    | TOP HEADER BAR (h-16, bg-surface, border-b)       |
| (Drawer di Mobile)| [☰] Breadcrumb > Halaman Aktif   [Badge: DOSEN]   |
|                   |     [👁 Lihat Tampilan Siswa]     [Profil v]      |
| [Logo JagoBahasa] +---------------------------------------------------+
|                   | <main id="main-content" class="p-6">              |
| Menu Dinamis:     |                                                   |
| - Dashboard/Stats |    {{ $slot }}                                    |
| - Kelola Kelas    |    (Tabel Data, Grafik Analytics, Form CRUD)      |
| - Course & Materi |                                                   |
| - Kelola User*    |                                                   |
| - Institusi*      | </main>                                           |
+-------------------+---------------------------------------------------+
(* khusus role admin)
```

---

## 4. SPESIFIKASI KOMPONEN INTI (WIREFRAME & INTERAKSI)

### 4.1 Global Accessibility Toolbar (`resources/views/components/accessibility-toolbar.blade.php`)
- **Perilaku:** Bar horizontal ramping di bagian paling atas semua halaman. Menggunakan Alpine.js (`x-data="accessibilityManager()"`) yang membaca/menyimpan preferensi ke `localStorage` dan mengirim request sinkronisasi ke server (`PATCH /preferences/accessibility` via session web/CSRF) secara *debounced* jika pengguna sudah login.
- **Kontrol Wajib:**
  - `A-` / `A+` (4 tingkat skala: `100%`, `115%`, `130%`, `150%`).
  - Toggle **Kontras Tinggi** (`aria-pressed="true|false"`), menambahkan class `.theme-high-contrast` pada tag `<html>`.
  - Toggle **Font Disleksia** (`aria-pressed="true|false"`), menambahkan class `.font-dyslexic` pada tag `<body>`.
  - Toggle **Kurangi Animasi** (`aria-pressed="true|false"`), menambahkan class `.reduce-motion` pada tag `<html>`.
  - Kontrol **Baca Halaman (*Read Aloud*)**: Tombol *Play/Pause/Stop* menggunakan `window.speechSynthesis` yang membaca konten di dalam `#main-content` dengan indikator status suara aktif.

### 4.2 Landing Page (`resources/views/welcome.blade.php`)
- **Hero Section (2 Kolom di Desktop):**
  - **Kiri:** Badge tema *"YLIC YO-FEST 2026 • Pendidikan untuk Semua"*, judul besar yang menonjolkan pembelajaran bahasa Inggris inklusif bersama **JagoBahasa**, deskripsi singkat, dan tombol CTA utama (*Mulai Belajar Gratis* & *Coba Demo Interaktif*).
  - **Kanan (Interactive Live Sandbox — Tanpa Login):** Kartu interaktif langsung di *above-the-fold* berisi:
    1. Frasa contoh: *"Education is the most powerful weapon to change the world."*
    2. Tombol **Dengarkan Pelafalan** (`speechSynthesis`).
    3. Tombol **Uji Suara Anda** (rekam mikrofon atau klik **"Simulasi Demo Juri"**) yang langsung menampilkan skor kemiripan dan sorotan kata.
- **Panel Akses Cepat Dewan Juri (`@if(config('lms.seed_demo'))`):**
  - Kotak berbingkai aksen Amber berisi 3 tombol masuk instan 1-klik: **Masuk sebagai Mahasiswa**, **Masuk sebagai Dosen**, dan **Masuk sebagai Admin** beserta ringkasan skenario pengujian.
- **Kartu Segmentasi Civitas ("Untuk Siapa"):** 4 kartu grid responsif (*Mahasiswa, Dosen, Tenaga Kependidikan, Alumni & Umum*) dengan ikon, manfaat utama, dan tombol aksi.

### 4.3 Student Dashboard (`resources/views/student/dashboard.blade.php`)
- **Baris 1 (Ringkasan Motivasi — 4 Kartu Metrik):** Total XP, *Daily Streak* (hari berturut-turut), *Lesson* Selesai, dan Peringkat Kelas.
- **Baris 2 (Grid 12 Kolom):**
  - **Kolom Kiri (7 Kolom) — Peta Penguasaan 4 Skills:** Grafik Radar Chart.js (*Listening, Speaking, Reading, Writing*) dilengkapi tombol toggle *"Tampilkan sebagai Tabel Teks"* untuk aksesibilitas pembaca layar.
  - **Kolom Kanan (5 Kolom) — Lanjutkan Belajar & Gabung Kelas:** Kartu *resume lesson* terakhir dengan *progress bar*, diikuti form input **Kode Kelas** (mis. `ENG-7K2Q`) dan daftar kelas aktif.
- **Baris 3 (Leaderboard & Badges):** Papan peringkat Top 5 (filter: *Kelas Saya* / *Global*) dengan opsi privasi *"Sembunyikan nama saya (Anonim)"*, berdampingan dengan lencana (*Badges*) yang telah diraih.

### 4.4 Interactive Learning Room (`resources/views/student/learn.blade.php`)
Menggunakan pola navigasi **4 Tab Aksesibel** (`role="tablist"`, mendukung tombol panah kiri/kanan pada keyboard):

1. **Tab 1: Materi & Reading**
   - Pemutar audio materi dengan pilihan kecepatan (`0.75x`, `1.0x`, `1.25x`) dan tombol *"Tampilkan Transkrip"* di bawahnya.
   - Teks bacaan interaktif: kosakata kunci dari kolom `lessons.vocabulary` diberi garis bawah putus-putus (`border-b-2 border-dotted`). Saat diklik atau ditekan `Enter`, muncul *popover/drawer* berisi definisi bahasa Inggris, terjemahan Indonesia, contoh kalimat, dan tombol pelafalan kata.
2. **Tab 2: Speaking Lab**
   - Kartu target frasa yang harus diucapkan, pemberitahuan privasi singkat (*"Audio diproses langsung di browser dan tidak disimpan di server"*), dan tombol mikrofon besar (`min-h-[56px]`) dengan animasi gelombang suara saat merekam.
   - Tersedia tombol sekunder **"Gunakan Input Teks / Simulasi Demo"** apabila mikrofon tidak tersedia atau browser tidak mendukung `SpeechRecognition`.
   - **Panel Hasil Analisis (Dari Server):** Menampilkan skor persentase besar (`0–100%`), label status (*Sangat Baik / Perlu Latihan*), serta rincian per kata menggunakan kombinasi warna + ikon + label teks:
     - Kata tepat: latar hijau lembut + ikon centang `✓` (`[Tepat]`).
     - Kata kurang tepat/terlewat: latar merah lembut + ikon silang `✗` (`[Perlu Perbaikan]`).
3. **Tab 3: Writing & Grammar Check**
   - Instruksi tugas menulis (*grammar prompt*), area teks dengan penghitung karakter langsung (`0 / 500 karakter`), dan tombol *"Periksa Tata Bahasa"*.
   - **Panel Umpan Balik Pedagogis:** Menampilkan daftar koreksi dalam bentuk kartu terstruktur:
     - **Teks Asli** (dicoret merah) → **Saran Perbaikan** (tebal hijau).
     - **Alasan Pedagogis** (penjelasan aturan tata bahasa dalam bahasa yang mudah dipahami).
     - **Contoh Kalimat Benar** sebagai referensi tambahan.
4. **Tab 4: Evaluasi (Formative Quiz)**
   - Soal pilihan ganda satu per satu atau daftar vertikal dengan radio button besar yang mudah diklik.
   - Setiap jawaban yang dipilih langsung memunculkan kotak umpan balik instan (*Benar / Kurang Tepat*) beserta penjelasan pedagogis dari kolom `quiz_questions.explanation`, dan tombol **"Selesaikan Lesson & Klaim XP"** di akhir kuis.

### 4.5 Admin Impact Analytics (`resources/views/admin/analytics.blade.php`)
- **Filter Atas:** Dropdown pilih *Course*, pilih *Kelas*, dan tombol **"Ekspor Laporan Dampak (CSV)"**.
- **Grafik Utama (Grouped Bar Chart — Chart.js):** Membandingkan rata-rata skor **Pre-Test** vs **Post-Test** mahasiswa per *Course* dengan indikator selisih kenaikan (mis. `+28.4% Peningkatan`).
- **Tabel Ringkasan Dampak:** Menampilkan jumlah peserta, rata-rata skor awal, rata-rata skor akhir, tingkat penyelesaian *lesson*, dan distribusi keaktifan per peran civitas akademika.

---

## 5. PANDUAN MIKRO-INTERAKSI & STATUS UI

| Kondisi UI | Desain & Perilaku Wajib |
| :--- | :--- |
| **Loading / Proses Server** | Tombol aksi menampilkan *spinner* SVG dan teks status (mis. *"Menganalisis pelafalan..."*), atribut `disabled` aktif untuk mencegah pengiriman ganda (*double submit*). |
| **Empty State (Data Kosong)** | Jangan pernah menampilkan tabel atau halaman putih kosong. Sediakan ilustrasi ikon sederhana, pesan ramah (mis. *"Belum ada kelas yang diikuti"*), dan tombol aksi langsung (*"Gabung Kelas Pertama Anda"*). |
| **Notifikasi & Toast** | Muncul di pojok kanan atas dengan `role="status"` dan `aria-live="polite"` (mis. *"+50 XP! Lesson berhasil diselesaikan"*). |
| **Error Validasi Form** | Pesan error muncul tepat di bawah input terkait dengan warna `--semantic-danger`, ikon peringatan, dan terhubung via `aria-describedby`. |
| **Motion & Animasi** | Semua transisi CSS wajib membungkus efek gerak di dalam `@media (prefers-reduced-motion: no-preference)` dan menghormati toggle **Kurangi Animasi** (`.reduce-motion`) pada *Accessibility Toolbar*. |