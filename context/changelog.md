# Changelog

## [0.1.6] - 2026-06-18 13:25 WIB
### Changed
- Memperbarui `docs/usecase.md` agar lebih menyerupai referensi: boundary sistem besar, aktor di sisi luar, use case oval, dan relasi `<<include>>`/`<<extend>>`.
- Memperbarui activity diagram public, admin, tutor, dan learner menjadi format swimlane stakeholder vs sistem seperti referensi.

## [0.1.5] - 2026-06-18 13:16 WIB
### Added
- Menambahkan `docs/usecase.md` berisi kode PlantUML use case diagram sistem RuangAjar Unila.
- Menambahkan activity diagram PlantUML untuk stakeholder public, admin, tutor, dan learner pada folder `docs/`.
- Memperbarui `current-progress.md` untuk mencatat dokumentasi diagram sistem.

## [0.1.4] - 2026-06-18 12:23 WIB
### Fixed
- Mengubah port MySQL di `src/config/database.php` dari `3307` ke `3306` untuk menyesuaikan database lokal yang sedang dipakai.
- Mencatat penyebab error koneksi database lokal pada `current-progress.md`.

## [0.1.3] - 2026-06-18 12:16 WIB
### Added
- Menambahkan `docs/setup.md` sebagai panduan setup project pertama kali dari nol menggunakan Laragon.
- Menambahkan langkah import `database/ruangajar.sql`, konfigurasi `src/config/database.php`, akses URL lokal, akun demo, smoke test, dan troubleshooting.

## [0.1.2] - 2026-06-18 12:12 WIB
### Added
- Menambahkan `stakeholder-features-flow.md` berisi fitur setiap stakeholder dan alur kerja utama sistem.
- Menambahkan pemetaan fitur ke folder frontend/backend dan tabel database terkait.
- Menambahkan aturan lintas stakeholder serta definition of done untuk workflow fitur.

## [0.1.1] - 2026-06-18 12:09 WIB
### Added
- Menambahkan aturan clean code, maintainability, scalability, dan efektivitas penulisan kode pada `system-instructions.md`.
- Menambahkan standar arsitektur untuk perubahan kode yang mudah dirawat dan scalable pada `architecture.md`.
- Memperbarui `current-progress.md` agar status dokumentasi konteks terbaru tercatat.

## [0.1.0] - 2026-06-18 12:06 WIB
### Added
- Membuat dokumentasi konteks awal proyek di folder `context/`.
- Menambahkan `system-instructions.md` sebagai panduan persona AI, coding rules, dan batas keamanan.
- Menambahkan `project-overview.md` berisi latar belakang, user roles, dan scope fitur RuangAjar Unila.
- Menambahkan `architecture.md` berisi stack, pola arsitektur, peta repo, dan standar coding.
- Menambahkan `database-schema.md` berdasarkan `database/ruangajar.sql`.
- Menambahkan `task-backlog.md` untuk milestone, backlog, dan done list proyek.
- Menambahkan `current-progress.md` sebagai scratchpad sesi kerja.
- Menambahkan `testing-guide.md` sebagai panduan QA manual dan pengecekan dasar.
- Menambahkan `decisions-log.md` sebagai ADR awal proyek.

### Notes
- Timestamp changelog memakai format tanggal, jam, dan menit sesuai waktu lokal WIB.
