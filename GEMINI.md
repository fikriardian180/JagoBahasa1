<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, or code comments work, read these installed skill files directly (use these paths even if a same-named global skill exists):
- Core filter, always on: `antislop`: `.gemini/skills/antislop/SKILL.md`
Before starting, follow the core's "Two Usage Modes" section in strict order: explicit session instruction first, then global preference, then ask. A session instruction always wins. For a resolved mode, say `antislop active: <mode> (session override).` or `antislop active: <mode> (global preference).` once before presenting findings or making edits, using the actual mode and source. Acknowledging the user's request without naming the source does not replace this notice.
Only an explicit choice of antislop during or after selects a session mode. A request to review, audit, or avoid file edits does not select a mode; read the global preference in that case. Another skill's mode does not select antislop's mode.
If the mode is unresolved, ask during/after and end the response; wait for the answer before any UI review, planning, or concept. For read-only tasks, put the active-mode notice only at the start of the final answer, never in progress messages. For editing tasks, announce before the first edit and omit it from the final answer.
To update antislop later: `npx antislop-ai --update`, or run `npx antislop-ai` and pick Overwrite them.
<!-- antislop:end -->

# GEMINI CLI PROJECT INSTRUCTIONS — JagoBahasa

## 1. Sumber Acuan Wajib
- Selalu baca `PRD.md` dan `DESIGN.md` sebelum menulis atau mengubah kode.
- Kerjakan secara berurutan sesuai **Roadmap Fase 1–5** di `PRD.md`. Dilarang melompati fase.
- Gunakan konvensi **Laravel 12** (daftarkan middleware dan `trustProxies` di `bootstrap/app.php`, bukan `Kernel.php`).

## 2. Code Quality Guardrails
- **No Placeholder / Incomplete Code:** Dilarang menulis komentar malas seperti `// TODO: implement this`, `// rest of code here`, atau fungsi kosong. Setiap file yang dibuat harus utuh dan langsung berjalan.
- **No Over-Engineering:** Jangan membuat *Repository Pattern*, *DTO*, atau *Trait* berlapis yang tidak diminta di `PRD.md`. Gunakan Eloquent langsung dan Service class hanya sesuai spesifikasi (`SpeechScoringService`, `GamificationService`, `GrammarFeedbackService`).
- **No Unrequested Dependencies:** Jangan menambahkan package Composer atau NPM baru di luar daftar `PRD.md` tanpa izin eksplisit.
- **Clean & Minimal Diffs:** Saat memperbaiki bug, ubah hanya baris yang relevan tanpa menulis ulang keseluruhan file yang sudah benar.
- **Zero Conversational Filler:** Langsung eksekusi perubahan file dan berikan ringkasan teknis singkat (maksimal 3–5 poin) setelah selesai.