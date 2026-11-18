# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## JagoBahasa — Inclusive English Learning Management System (LMS)
**Kompetisi:** Youth Learning Innovation Competition (YLIC) YO-FEST 2026  
**Tema:** *"Pendidikan untuk Semua, Masa Depan untuk Bersama"*  
**Versi Dokumen:** 1.1 (Single Source of Truth untuk AI Agent & Developer)

---

## 1. RINGKASAN PRODUK & PROBLEM STATEMENT

### 1.1 Latar Belakang Masalah
Pembelajaran bahasa Inggris di lingkungan pendidikan tinggi sering kali terhambat oleh tiga masalah utama:
1. **Minimnya Umpan Balik Aktif pada Keterampilan Produktif (*Speaking* & *Writing*):** Platform LMS konvensional hanya berfokus pada distribusi materi PDF dan kuis pilihan ganda, sehingga mahasiswa tidak memiliki sarana latihan pelafalan (*pronunciation*) maupun koreksi tata bahasa (*grammar*) mandiri yang interaktif.
2. **Kurangnya Aksesibilitas Inklusif:** Sebagian besar aplikasi pembelajaran digital belum memfasilitasi kebutuhan pengguna dengan hambatan penglihatan (*low vision*), disleksia, maupun keterbatasan perangkat/koneksi.
3. **Sulitnya Mengukur Dampak Belajar:** Pengajar kesulitan memantau kemajuan belajar secara terukur dari titik awal (*pre-test*) hingga akhir (*post-test*) per keterampilan berbahasa (*Listening, Speaking, Reading, Writing*).

### 1.2 Solusi & Tujuan Produk
**JagoBahasa** adalah platform LMS berbasis web untuk pembelajaran Bahasa Inggris (level CEFR A1–B2 dan persiapan TOEFL/IELTS) yang dirancang inklusif bagi **seluruh civitas akademika** (mahasiswa, dosen, tenaga kependidikan, serta alumni/tamu/juri). Aplikasi ini dikembangkan secara cepat di lingkungan lokal (SQLite/MySQL), mendukung arsitektur kontainer Docker, serta siap di-deploy secara **online (HTTPS)** menggunakan **Vercel + Cloudflare R2** untuk keperluan penilaian juri.

### 1.3 Nilai Kebaruan (Core Innovations)
1. **Universal Accessibility Mode (WCAG 2.1 Level AA):** *Text-to-Speech* (*Read Aloud*) pada seluruh bacaan, skala ukuran font dinamis (`100%–200%`), *High Contrast Mode*, font ramah disleksia, pengurangan animasi, serta navigasi *keyboard* penuh.
2. **Automated Speaking Lab:** Latihan pelafalan berbasis *Web Speech API* dengan perhitungan skor kemiripan di sisi server, penandaan kesalahan per kata (warna + label teks), serta *Demo Fallback* untuk browser tanpa dukungan mikrofon.
3. **Hybrid Smart Grammar Feedback:** Koreksi tulisan esai singkat dengan penjelasan pedagogis menggunakan mesin aturan ringan (*Rule-Based*) sebagai *default* agar bebas *Out-of-Memory* (OOM) di server mana pun, dengan opsi integrasi *LanguageTool* dan *fallback* otomatis.
4. **Contextual Gamification:** Sistem *XP*, *Daily Streak* (dengan *Lazy Streak Reset* tanpa ketergantungan cron), *Badges*, dan *Leaderboard* berbasis pencapaian 4 keterampilan bahasa.
5. **Learning Impact Analytics:** Evaluasi *Pre-Test* dan *Post-Test* otomatis di level *Course* untuk membuktikan peningkatan skor belajar secara kuantitatif.

---

## 2. TARGET PENGGUNA & HAK AKSES (RBAC)

Satu akun memiliki satu peran utama (`role`) yang ditegakkan menggunakan *Middleware* (didaftarkan di `bootstrap/app.php`) dan *Laravel Policies*:

| Peran (`role`) | Deskripsi Pengguna | Hak Akses Utama | Layout |
| :--- | :--- | :--- | :--- |
| **`admin`** | Pengelola sistem / institusi | Kelola seluruh pengguna, verifikasi staf, institusi/domain, kode undangan dosen, semua *course* & kuis, pengaturan situs, serta *Analytics* dampak pembelajaran global. | `admin.blade.php` |
| **`lecturer`** | Dosen / pengajar | Buat & kelola *course* miliknya, buat kelas dengan kode bergabung unik, pantau progres mahasiswa per kelas, identifikasi mahasiswa tertinggal, ekspor rekap nilai CSV. | `admin.blade.php` |
| **`student`** | Mahasiswa aktif | Mengikuti kelas via kode gabung, mengakses materi 4 *skills*, *Speaking Lab*, *Writing Check*, kuis, melihat grafik radar pribadi, dan masuk *Leaderboard*. | `app.blade.php` |
| **`staff`** | Tenaga kependidikan | Belajar mandiri pada *course* institusi/publik (hak akses belajar sama dengan `student`, tidak masuk *leaderboard* kelas kecuali bergabung). | `app.blade.php` |
| **`guest`** | Alumni / umum / juri tamu | Belajar mandiri pada *course* berstatus `public`. | `app.blade.php` |

### Aturan Pendaftaran & Akses Cepat Juri
- **Pemetaan Domain Otomatis:** Email berdomain mahasiswa (mis. `@student.unida.gontor.ac.id`) otomatis menjadi `student`; email berdomain institusi lain (mis. `@unida.gontor.ac.id`) ditandai `is_institutional = true` dan masuk antrean verifikasi menjadi `staff`; domain publik menjadi `guest`.
- **Akun Dosen & Admin:** Dibuat oleh `admin` atau melalui **kode undangan sekali pakai** (`invitations`). Pendaftar mandiri tidak dapat memilih peran `lecturer` atau `admin`.
- **Mode Demo & Juri (`SEED_DEMO=true`):**
  - Menyediakan tombol **Auto-Verify Email** saat registrasi baru agar juri tidak terhambat konfigurasi SMTP.
  - Menampilkan panel **1-Click Demo Login** di *Landing Page* untuk masuk instan sebagai `Student`, `Lecturer`, atau `Admin`.

---

## 3. PRIORITAS FITUR (MoSCoW)

| Prioritas | Fitur / Komponen | Keterangan |
| :--- | :--- | :--- |
| **Must-Have** | Autentikasi, RBAC (5 peran), pemisahan layout `app.blade.php` & `admin.blade.php` | Pondasi keamanan dan pemisahan antarmuka user vs pengelola. |
| **Must-Have** | *Global Accessibility Toolbar* (`A+/A-`, *High Contrast*, *Dyslexia Font*, *Read Aloud*) | Implementasi utama tema inklusivitas *"Pendidikan untuk Semua"*. |
| **Must-Have** | *Landing Page* dengan demo interaktif tanpa login & *1-Click Demo Login* | Memungkinkan juri menguji inovasi dalam 10 detik pertama. |
| **Must-Have** | *Interactive Learning Room* 4 Tab (*Reading*, *Speaking Lab*, *Writing Check*, *Quiz*) | Pengalaman belajar inti dengan skor server-side & umpan balik pedagogis. |
| **Must-Have** | *Gamification* (XP anti-farming, *Lazy Streak*, *Badges*, *Leaderboard*) & *Dashboard* 4 Skills | Menjaga motivasi belajar dan visualisasi progres. |
| **Must-Have** | *Lecturer Class Management* (Kode gabung) & *Admin Impact Analytics* (*Pre-Test* vs *Post-Test*) | Bukti relevansi pedagogis dan evaluasi dampak pembelajaran. |
| **Must-Have** | Kompatibilitas Lokal (SQLite/MySQL) + *Deployment Online* (Vercel + Cloudflare R2 & Docker) | Memastikan aplikasi lancar dikembangkan di lokal dan *online* saat penilaian. |
| **Should-Have** | Lokalisasi dua bahasa (`lang/id` dan `lang/en`) & ekspor laporan CSV | Mendukung aksesibilitas bahasa dan administrasi dosen/admin. |
| **Could-Have** | Impor massal pengguna via CSV & integrasi opsional *LanguageTool* self-host | Fitur pendukung skala institusi besar. |
| **Won't-Have (v1)** | Penyimpanan rekaman audio mentah pengguna & aplikasi mobile native | Audio diproses langsung menjadi teks demi privasi dan efisiensi storage. |

---

## 4. USER STORIES & ACCEPTANCE CRITERIA

### US-01: Eksplorasi Inklusif Tanpa Login (Juri / Tamu)
- **As a** Dewan Juri atau pengunjung tamu, **I want to** mencoba fitur aksesibilitas, *Read Aloud*, dan demo *Speaking Lab* langsung di halaman utama tanpa membuat akun, **so that** saya dapat menilai kualitas inovasi platform dengan cepat.
- **Acceptance Criteria:**
  - *Landing Page* memuat mini-demo *Speaking* (mendukung mikrofon HTTPS dan *Demo Fallback* teks), tombol *Read Aloud*, dan kontrol aksesibilitas.
  - Jika `SEED_DEMO=true`, tersedia tombol *1-Click Login* untuk peran `Student`, `Lecturer`, dan `Admin`.

### US-02: Pengaturan Aksesibilitas Persisten
- **As a** pengguna dengan kebutuhan khusus (*low vision* / disleksia), **I want to** menyesuaikan ukuran huruf, kontras tinggi, jenis huruf, dan pembaca layar di seluruh halaman, **so that** saya dapat belajar dengan nyaman tanpa hambatan visual.
- **Acceptance Criteria:**
  - Komponen `accessibility-toolbar.blade.php` terpasang di `app.blade.php` dan `admin.blade.php`.
  - Preferensi tersimpan di `localStorage` untuk tamu dan tersinkron ke kolom JSON `users.accessibility_prefs` untuk pengguna login.
  - Setiap halaman memiliki *skip link* (`#main-content`), atribut ARIA valid, rasio kontras ≥ 4.5:1, dan transkrip teks untuk setiap audio.

### US-03: Latihan Berbicara & Menulis dengan Umpan Balik Pedagogis
- **As a** mahasiswa (`student`), **I want to** berlatih mengucapkan frasa bahasa Inggris dan menulis paragraf singkat dengan koreksi otomatis, **so that** saya mengetahui bagian mana yang salah beserta alasannya.
- **Acceptance Criteria:**
  - *Speaking Lab* mengirim transkrip ke server (`SpeechScoringService`) untuk menghitung skor `0–100%` dan menampilkan status benar/salah per kata dengan label teks.
  - *Writing Check* menggunakan `RuleBasedGrammarService` secara default dan menampilkan kesalahan, perbaikan, alasan tata bahasa, serta contoh kalimat benar.
  - XP per *lesson* hanya diberikan satu kali saat status berubah menjadi `completed` (anti-farming).

### US-04: Manajemen Kelas & Analisis Dampak Pembelajaran
- **As a** dosen (`lecturer`) dan pengelola (`admin`), **I want to** membagikan kode kelas, memantau mahasiswa yang tertinggal, serta membandingkan nilai *pre-test* dan *post-test*, **so that** efektivitas pembelajaran dapat dievaluasi secara objektif.
- **Acceptance Criteria:**
  - Dosen dapat membuat kelas dan menyalin kode gabung unik (mis. `ENG-7K2Q`), melihat mahasiswa yang tidak aktif ≥ 7 hari, dan mengunduh CSV nilai.
  - Admin dapat melihat grafik perbandingan rata-rata skor *Pre-Test* vs *Post-Test* per *Course* dan mengekspor laporan dampak ke CSV.

---

## 5. ARSITEKTUR TEKNIS & STACK TEKNOLOGI

| Komponen | Spesifikasi Teknis |
| :--- | :--- |
| **Framework Backend** | **Laravel 12** (PHP 8.3+), Laravel Breeze (Blade), FormRequest Validation, Policies, Middleware via `bootstrap/app.php` |
| **Frontend & UI** | Blade Templates, Tailwind CSS, Alpine.js, Chart.js (dikompilasi via Vite) |
| **Struktur Layout** | `resources/views/layouts/app.blade.php` (User/Tamu) & `resources/views/layouts/admin.blade.php` (Admin/Dosen) |
| **Database** | **Pengembangan Lokal:** SQLite / MySQL lokal. **Produksi Online:** MySQL Cloud (TiDB Cloud / Aiven) atau MySQL 8 Docker |
| **Object Storage** | **Pengembangan Lokal:** `local` disk. **Produksi Online:** Cloudflare R2 (`FILESYSTEM_DISK=r2` via driver `s3`) |
| **Hosting & Server** | Mendukung **Vercel Serverless** (`vercel.json` + `api/index.php`) serta **Docker Compose + Caddy 2** (HTTPS otomatis) |
| **Browser API** | Web Speech API (`SpeechRecognition` & `speechSynthesis`) dengan *fallback* otomatis |

### Spesifikasi Dua Layout Utama
1. **`resources/views/layouts/app.blade.php`:** Digunakan untuk *Landing Page*, *Dashboard* pembelajar (`student`, `staff`, `guest`), katalog *course*, *Learning Room*, dan *Leaderboard*. Memuat *skip-link*, `components.accessibility-toolbar`, navbar responsif (indikator *Streak* & *XP* bagi user login), `<main id="main-content">`, dan footer.
2. **`resources/views/layouts/admin.blade.php`:** Digunakan khusus untuk panel manajemen `/lecturer/*` dan `/admin/*`. Memuat *skip-link*, `components.accessibility-toolbar`, *collapsible sidebar* responsif (menu dinamis sesuai peran `lecturer` vs `admin`), *top header bar* dengan breadcrumb serta tombol cepat *"Lihat Tampilan Siswa"*, dan area kerja lebar penuh.

---

## 6. SKEMA DATABASE (15 TABEL)

Gunakan *foreign key* dengan `cascadeOnDelete` yang sesuai, index pada kolom pencarian utama, serta `SoftDeletes` pada `users`, `courses`, dan `classrooms`.

1. **`users`**: `id`, `name`, `email` (unique), `email_verified_at`, `password`, `role` (`admin|lecturer|student|staff|guest`), `institution_id` (nullable), `student_number` (nullable), `is_institutional` (bool), `is_active` (bool), `xp_points`, `current_streak`, `longest_streak`, `last_active_date`, `locale` (`id|en`), `show_on_leaderboard` (bool), `accessibility_prefs` (JSON), `timestamps`, `deleted_at`.
2. **`institutions`**: `id`, `name`, `email_domain`, `default_role`, `is_active`.
3. **`courses`**: `id`, `owner_id` (FK `users`), `title`, `slug` (unique), `level` (`A1|A2|B1|B2`), `category` (`general|academic|toefl_ielts`), `description`, `thumbnail`, `visibility` (`public|institution|class_only`), `is_published` (bool), `timestamps`, `deleted_at`.
4. **`modules`**: `id`, `course_id` (FK `courses`), `title`, `skill_focus` (`listening|speaking|reading|writing`), `order_number`.
5. **`lessons`**: `id`, `module_id` (FK `modules`), `title`, `content_text`, `audio_url` (nullable), `transcript` (nullable, wajib jika ada audio), `vocabulary` (JSON), `speaking_target_phrase`, `grammar_prompt`, `xp_reward`, `order_number`.
6. **`classrooms`**: `id`, `lecturer_id` (FK `users`), `course_id` (FK `courses`), `name`, `join_code` (unique), `academic_year`, `is_active` (bool), `deleted_at`.
7. **`enrollments`**: `id`, `classroom_id` (FK `classrooms`), `user_id` (FK `users`), `joined_at`. Unique `(classroom_id, user_id)`.
8. **`quizzes`**: `id`, `course_id` (FK wajib ke `courses`), `module_id` (FK `nullable` ke `modules` — diisi untuk `formative`, kosong untuk `pre_test` & `post_test`), `title`, `type` (`formative|pre_test|post_test`).
9. **`quiz_questions`**: `id`, `quiz_id` (FK `quizzes`), `question_text`, `options` (JSON), `correct_answer`, `explanation`.
10. **`quiz_attempts`**: `id`, `user_id` (FK `users`), `quiz_id` (FK `quizzes`), `score`, `answers` (JSON), `taken_at`.
11. **`user_progress`**: `id`, `user_id` (FK `users`), `lesson_id` (FK `lessons`), `status` (`in_progress|completed`), `speaking_score` (nullable), `quiz_score` (nullable), `writing_score` (nullable), `attempts`, `completed_at`. Unique `(user_id, lesson_id)`.
12. **`writing_submissions`**: `id`, `user_id` (FK `users`), `lesson_id` (FK `lessons`), `body`, `feedback` (JSON), `score`, `created_at`.
13. **`badges` & `user_badges`**: `code`, `name`, `description`, `icon`, `criteria`; tabel pivot `user_badges` (`user_id`, `badge_id`, `awarded_at`).
14. **`xp_logs`**: `id`, `user_id` (FK `users`), `source` (`lesson|quiz|speaking|writing|streak|badge`), `points`, `created_at`.
15. **`invitations`**: `id`, `code` (unique), `role`, `created_by` (FK `users`), `used_by` (nullable), `expires_at`.

---

## 7. KONFIGURASI LINGKUNGAN & DEPLOYMENT (LOKAL KE ONLINE)

### 7.1 Abstraksi Storage & Serverless Compatibility
1. **Cloudflare R2 (`FILESYSTEM_DISK=r2`):** Konfigurasi disk `r2` pada `config/filesystems.php` menggunakan driver `s3` (`league/flysystem-aws-s3-v3`). Semua penyimpanan dan pemanggilan media wajib memakai `Storage::put(...)` dan `Storage::url($path)`. Dilarang keras memakai `asset('storage/...')` secara hardcode.
2. **Vercel Serverless (`vercel.json` & `api/index.php`):**
   - Buat `api/index.php` yang meneruskan request ke `public/index.php`, serta `vercel.json` untuk menyajikan aset Vite (`build/**`) dan me-route request dinamis ke runtime PHP.
   - Di `AppServiceProvider::boot()`, jika terdeteksi berjalan di Vercel (`isset($_ENV['VERCEL'])`), arahkan storage sementara ke `/tmp` (`$this->app->useStoragePath('/tmp/storage')`) agar terhindar dari *Read-only file system*.
   - **Lazy Streak Reset:** Pengecekan reset *Daily Streak* dijalankan di dalam `GamificationService` saat pengguna membuka dashboard atau menyelesaikan aktivitas (tidak bergantung pada cron daemon).
3. **Laravel 12 Middleware & Proxy (`bootstrap/app.php`):** Daftarkan alias middleware peran (`role`) serta konfigurasi `$middleware->trustProxies(at: '*')` di dalam `bootstrap/app.php` agar URL aset selalu `https://` di balik Vercel maupun reverse proxy.

### 7.2 Template `.env.example` (Dual-Mode)
```env
# ==============================================================================
# MODE 1: PENGEMBANGAN LOKAL (DEFAULT SAAT CODING)
# ==============================================================================
APP_NAME=JagoBahasa
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta
SEED_DEMO=true

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=jagobahasa
# DB_USERNAME=root
# DB_PASSWORD=

FILESYSTEM_DISK=local
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
GRAMMAR_DRIVER=rules

# ==============================================================================
# MODE 2: DEPLOY ONLINE VERCEL + CLOUDFLARE R2 (UNTUK PENILAIAN JURI)
# ==============================================================================
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=[https://jagobahasa.vercel.app](https://jagobahasa.vercel.app)
# DB_CONNECTION=mysql
# DB_HOST=gateway01.ap-southeast-1.prod.aws.tidbcloud.com
# DB_PORT=4000
# DB_DATABASE=jagobahasa
# DB_USERNAME=user_cloud
# DB_PASSWORD=password_cloud
# MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
# FILESYSTEM_DISK=r2
# R2_ACCESS_KEY_ID=
# R2_SECRET_ACCESS_KEY=
# R2_BUCKET=jagobahasa-assets
# R2_ENDPOINT=https://<ACCOUNT_ID>.r2.cloudflarestorage.com
# R2_URL=https://pub-<PUBLIC_HASH>.r2.dev
# SESSION_DRIVER=cookie
# CACHE_STORE=database
```

---

## 8. NON-FUNCTIONAL REQUIREMENTS & KEAMANAN

- **Keamanan:** Proteksi CSRF, *throttling* pada login/registrasi/endpoint penilaian skor, sanitasi output (`{{ }}`), validasi `FormRequest`, serta otorisasi berbasis *Policy* antar peran/kelas. Audio suara pengguna tidak disimpan di server.
- **Performa & Kapasitas:** Eager loading Eloquent (bebas *N+1 query*), aset dikompilasi via Vite, waktu muat halaman < 3 detik pada jaringan 4G, dan konsumsi memori ringan (`GRAMMAR_DRIVER=rules`).
- **Aksesibilitas & Responsivitas:** Lulus audit Lighthouse Accessibility ≥ 90, target sentuh minimal `44x44 px`, responsif pada lebar layar `360px`, `768px`, dan `1280px`.

---

## 9. ROADMAP EKSEKUSI BERTAHAP UNTUK AI AGENT

> **Instruksi Penting untuk AI Agent:** Kerjakan secara berurutan per fase. Jangan melompat ke fase berikutnya sebelum fase aktif selesai diuji dan berjalan tanpa error.

| Fase | Ruang Lingkup Pekerjaan | Kriteria Selesai (Deliverable) |
| :--- | :--- | :--- |
| **Fase 1** | Setup **Laravel 12** + Breeze (Blade), konfigurasi `.env.example` (Mode Lokal & Vercel/R2), `trustProxies` & role middleware di `bootstrap/app.php`, `config/filesystems.php` (disk `r2`), 15 Migrations & Models lengkap dengan relasi, serta `DatabaseSeeder` (20 akun demo, 2 *Course* lengkap dengan 4 modul & *Pre/Post-Test*, 2 kelas aktif dengan riwayat progres). | Aplikasi berjalan di lokal (`php artisan migrate:fresh --seed` sukses) dan semua peran dapat login tanpa halaman kosong. |
| **Fase 2** | Pembuatan `layouts/app.blade.php` & `layouts/admin.blade.php`, komponen `components/accessibility-toolbar.blade.php`, *Landing Page* (demo interaktif tanpa login + *1-Click Demo Login*), RBAC (*Middleware* & *Policies*), registrasi berbasis domain, dan fitur gabung kelas via kode. | *Landing Page* berfungsi interaktif tanpa login; tampilan user (`app`) dan admin/dosen (`admin`) terpisah sesuai peran. |
| **Fase 3** | *Student Dashboard* (grafik radar 4 *skills*, *streak*, *leaderboard*), *Interactive Learning Room* 4 tab (*Reading* + kamus klik, *Speaking Lab* + skor server-side & *Demo Fallback*, *Writing Check* dengan `RuleBasedGrammarService`, *Formative Quiz*), serta `GamificationService` (*XP*, *Lazy Streak*, *Badges*). | Satu *lesson* dapat diselesaikan penuh dari awal hingga akhir, dan skor/XP/badge langsung terbarui. |
| **Fase 4** | *Lecturer Panel* (kelola kelas, daftar mahasiswa tertinggal, ekspor CSV) dan *Admin Panel* (manajemen user & verifikasi staf, manajemen *course*/kuis, serta *Impact Analytics* perbandingan *Pre-Test* vs *Post-Test* + ekspor CSV). | Dosen dapat memantau progres kelasnya; Admin dapat melihat grafik dampak pembelajaran. |
| **Fase 5** | Konfigurasi *deployment* online Vercel (`vercel.json`, `api/index.php`, `/tmp` storage path di `AppServiceProvider`), file Docker (`Dockerfile`, `docker-compose.yml`, `Caddyfile`), audit aksesibilitas & responsivitas, rate limiting, dan `README.md` lengkap. | Lighthouse Accessibility ≥ 90; aplikasi siap di-push ke GitHub dan di-deploy online ke Vercel + Cloudflare R2. |

---

## 10. DEFINITION OF DONE & SKENARIO DEMO JURI (3 MENIT)

### Checklist Akhir
- [ ] Berjalan mulus di database lokal saat pengembangan dan siap di-deploy online ke **Vercel + Cloudflare R2** (HTTPS aktif) tanpa error *Read-only file system* maupun *Mixed Content*.
- [ ] Seluruh 5 peran dapat masuk dan terarah ke layout masing-masing (`app.blade.php` atau `admin.blade.php`).
- [ ] Fitur aksesibilitas (`A+/A-`, *High Contrast*, *Dyslexia Font*, *Read Aloud*) berfungsi penuh di seluruh halaman.
- [ ] *Speaking Lab* dan *Writing Check* memberikan skor serta umpan balik pedagogis yang akurat.
- [ ] Halaman *Admin Analytics* menampilkan grafik perbandingan skor *Pre-Test* dan *Post-Test* dari data seeder.

### Alur Demo Video / Presentasi Juri (3 Menit)
1. **0:00–0:30 (Landing Page & Inklusivitas):** Buka tautan online HTTPS situs, tunjukkan misi *"Pendidikan untuk Semua"*, aktifkan *High Contrast Mode*, perbesar font `A+`, dan jalankan *Read Aloud* tanpa login.
2. **0:30–1:15 (Demo Speaking Tanpa Login):** Uji coba pengucapan frasa pada mini-demo *Speaking Lab* dan tunjukkan analisis skor otomatis per kata.
3. **1:15–2:00 (Pengalaman Mahasiswa):** Klik *1-Click Login (Student)* → tunjukkan grafik radar 4 *skills* & *leaderboard* → masuk ke *Learning Room* (*Reading* → *Writing Grammar Feedback* → *Quiz* + perolehan XP).
4. **2:00–2:30 (Pengalaman Dosen):** Klik *1-Click Login (Lecturer)* → tunjukkan kode bergabung kelas, pemantauan mahasiswa yang tertinggal, dan ekspor rekap nilai CSV.
5. **2:30–3:00 (Dampak Pembelajaran & Arsitektur):** Klik *1-Click Login (Admin)* → tunjukkan halaman *Learning Impact Analytics* (peningkatan skor *pre-test* ke *post-test*) sebagai bukti efektivitas pedagogis media.