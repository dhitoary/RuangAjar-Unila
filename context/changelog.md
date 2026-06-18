# Changelog

## [0.1.18] - 2026-06-18 17:11 WIB
### Changed
- Menyesuaikan ulang penjelasan Use Case Diagram pada subbab 4.2.2.1 berdasarkan gambar final `docs/image.png`.
- Meringkas uraian use case agar lebih padat dan sesuai dengan relasi pada diagram final.

## [0.1.17] - 2026-06-18 17:06 WIB
### Added
- Menambahkan penjelasan naratif Use Case Diagram pada subbab 4.2.2.1 di `docs/laporan-ruangajar-unila.md`.
- Menambahkan penjelasan naratif Activity Diagram pada subbab 4.2.2.2 di `docs/laporan-ruangajar-unila.md`.
- Menyesuaikan uraian UML dengan aktor Public Visitor, Learner, Tutor, Admin, serta posisi Midtrans sebagai payment gateway eksternal.

## [0.1.16] - 2026-06-18 16:36 WIB
### Changed
- Meringkas tabel Kebutuhan Nonfungsional pada `docs/laporan-ruangajar-unila.md` menjadi 6 kriteria utama.
- Menyesuaikan deskripsi kebutuhan nonfungsional agar berfokus pada kondisi sistem ketika telah dijalankan pada server atau hosting.

## [0.1.15] - 2026-06-18 16:26 WIB
### Added
- Menambahkan subbab 3.3 Analisis Kebutuhan Sistem pada `docs/laporan-ruangajar-unila.md`.
- Menambahkan tabel Kebutuhan Fungsional dan Kebutuhan Nonfungsional yang disesuaikan dengan role Public Visitor, Learner, Tutor, Admin, dan proses sistem.

### Changed
- Menyesuaikan penomoran Product Backlog Item dari 3.3 menjadi 3.4.

## [0.1.14] - 2026-06-18 16:14 WIB
### Changed
- Memperbarui subbab 3.1 pada `docs/laporan-ruangajar-unila.md` agar pembagian kontribusi full-stack dijelaskan berdasarkan role fitur.
- Menjelaskan bahwa Dhito Aryo Trengginas berfokus pada Public Visitor dan Learner, Muhammad Rayham Gumay pada Admin, serta Firman Farel Richardo pada Tutor dan dokumentasi teknis.

## [0.1.13] - 2026-06-18 16:08 WIB
### Changed
- Memperbarui subbab 3.1 pada `docs/laporan-ruangajar-unila.md` agar peran Scrum tetap tercatat, tetapi seluruh anggota juga dijelaskan sebagai full-stack developer.
- Menyesuaikan narasi pembagian peran supaya mencerminkan kontribusi frontend, backend, database, integrasi, dokumentasi, dan pengujian yang dikerjakan bersama.

## [0.1.12] - 2026-06-18 15:35 WIB
### Added
- Menambahkan `docs/laporan-ruangajar-unila.md` berisi laporan pengembangan sistem RuangAjar Unila dari BAB I sampai BAB VI.
- Menyusun laporan berdasarkan struktur penomoran yang diminta, meliputi pendahuluan, landasan teori, perencanaan pre-sprint, implementasi sprint, pengujian integrasi, serta kesimpulan dan saran.
- Menyesuaikan gaya penulisan laporan agar formal, naratif, dan mudah dipindahkan ke format Word/PDF.

## [0.1.11] - 2026-06-18 14:52 WIB
### Added
- Menambahkan keterangan teks setiap use case pada `docs/usecase.md`.
- Mengelompokkan keterangan berdasarkan role Public Visitor, Learner, Tutor, Admin, dan Proses Sistem.
- Menambahkan penjelasan relasi `<<include>>` dan `<<extend>>` sesuai kode PlantUML.

## [0.1.10] - 2026-06-18 14:47 WIB
### Changed
- Memperbaiki layout `docs/usecase.md` agar tidak melebar ekstrem saat dirender.
- Menghapus layout helper PlantUML yang menyebabkan garis panjang dan saling silang.
- Mengelompokkan use case dalam package Akses Umum, Fitur Learner, Fitur Tutor, Fitur Admin, dan Proses Sistem.

## [0.1.9] - 2026-06-18 14:43 WIB
### Changed
- Membuat ulang `docs/usecase.md` agar lebih menyerupai `docs/contohusecase.png`.
- Mempertahankan Midtrans sebagai catatan payment gateway eksternal, bukan aktor/stakeholder.
- Menambahkan layout helper PlantUML untuk membantu posisi use case lebih rapi seperti diagram referensi.

## [0.1.8] - 2026-06-18 14:20 WIB
### Changed
- Memperbaiki `docs/usecase.md` dengan menghapus Midtrans sebagai aktor/stakeholder.
- Mengelompokkan use case berdasarkan role Public, Learner, Tutor, Admin, dan Proses Sistem agar output PlantUML lebih rapi.
- Menambahkan catatan bahwa Midtrans digunakan sebagai payment gateway eksternal pada proses transaksi pembayaran.

## [0.1.7] - 2026-06-18 14:03 WIB
### Changed
- Menyederhanakan `docs/usecase.md` agar hanya memuat use case inti sesuai gaya contoh terbaru.
- Memecah activity diagram setiap stakeholder menjadi beberapa diagram per fitur dalam file stakeholder yang sama.
- Menjaga format PlantUML tetap hitam-putih, memakai swimlane stakeholder dan sistem, serta mudah dirender untuk laporan.

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
