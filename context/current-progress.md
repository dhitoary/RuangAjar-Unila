# Current Progress (Scratchpad)

## Active Task
Menyesuaikan dan meringkas penjelasan Use Case Diagram berdasarkan gambar final.

## Files Modified (Current Session)
- `context/system-instructions.md` -> Instruksi kerja AI, coding rules, dan batas keamanan proyek.
- `context/project-overview.md` -> Ringkasan tujuan, user role, dan scope fitur RuangAjar Unila.
- `context/architecture.md` -> Stack, pola arsitektur, struktur repo, dan standar error handling.
- `context/database-schema.md` -> Ringkasan relasi dan definisi tabel dari `database/ruangajar.sql`.
- `context/task-backlog.md` -> Milestone, backlog, dan done list proyek.
- `context/current-progress.md` -> Status aktif sesi dokumentasi context.
- `context/testing-guide.md` -> Panduan validasi manual dan command pengecekan dasar.
- `context/decisions-log.md` -> ADR awal proyek.
- `context/changelog.md` -> Riwayat pembuatan context dengan timestamp sampai menit.
- `context/system-instructions.md` -> Ditambahkan aturan clean code, maintainability, scalability, dan efektivitas penulisan kode.
- `context/architecture.md` -> Ditambahkan standar arsitektur untuk perubahan kode yang maintainable dan scalable.
- `context/stakeholder-features-flow.md` -> Dokumen fitur per stakeholder, alur kerja sistem, aturan lintas role, dan peta fitur ke folder/file.
- `context/current-progress.md` -> Memperbarui status aktif sesi dokumentasi stakeholder flow.
- `context/changelog.md` -> Mencatat penambahan dokumen stakeholder flow dengan timestamp sampai menit.
- `docs/setup.md` -> Panduan setup project pertama kali dengan Laragon, import database, konfigurasi, smoke test, dan troubleshooting.
- `context/current-progress.md` -> Memperbarui status aktif sesi dokumentasi setup.
- `context/changelog.md` -> Mencatat penambahan dokumentasi setup dengan timestamp sampai menit.
- `src/config/database.php` -> Mengubah port MySQL dari `3307` ke `3306` agar sesuai database lokal yang sedang dipakai.
- `context/current-progress.md` -> Mencatat perbaikan koneksi database lokal.
- `context/changelog.md` -> Mencatat perubahan konfigurasi database lokal.
- `docs/usecase.md` -> Diagram use case PlantUML global untuk Public, Learner, Tutor, Admin, dan Midtrans.
- `docs/activitydiagram-public.md` -> Activity diagram PlantUML untuk alur public visitor.
- `docs/activitydiagram-admin.md` -> Activity diagram PlantUML untuk alur admin.
- `docs/activitydiagram-tutor.md` -> Activity diagram PlantUML untuk alur tutor.
- `docs/activitydiagram-learner.md` -> Activity diagram PlantUML untuk alur learner, booking, payment, dan review.
- `context/current-progress.md` -> Mencatat status pembuatan diagram PlantUML.
- `context/changelog.md` -> Mencatat penambahan diagram PlantUML.
- `docs/usecase.md` -> Diperbarui menjadi diagram use case dengan boundary sistem besar, aktor di sisi luar, dan relasi include/extend yang lebih menyerupai referensi.
- `docs/activitydiagram-public.md` -> Diperbarui menjadi activity diagram swimlane Public Visitor dan Sistem.
- `docs/activitydiagram-admin.md` -> Diperbarui menjadi activity diagram swimlane Admin dan Sistem.
- `docs/activitydiagram-tutor.md` -> Diperbarui menjadi activity diagram swimlane Tutor dan Sistem.
- `docs/activitydiagram-learner.md` -> Diperbarui menjadi activity diagram swimlane Learner dan Sistem.
- `context/current-progress.md` -> Mencatat pembaruan gaya diagram sesuai referensi.
- `context/changelog.md` -> Mencatat pembaruan diagram PlantUML.
- `docs/usecase.md` -> Disederhanakan menjadi use case inti dengan aktor Public, Learner, Tutor, Admin, dan Midtrans.
- `docs/activitydiagram-public.md` -> Dipecah menjadi beberapa activity diagram per fitur public dalam satu file.
- `docs/activitydiagram-admin.md` -> Dipecah menjadi beberapa activity diagram per fitur admin dalam satu file.
- `docs/activitydiagram-tutor.md` -> Dipecah menjadi beberapa activity diagram per fitur tutor dalam satu file.
- `docs/activitydiagram-learner.md` -> Dipecah menjadi beberapa activity diagram per fitur learner dalam satu file.
- `context/current-progress.md` -> Mencatat penyederhanaan diagram sesuai contoh terbaru.
- `context/changelog.md` -> Mencatat penyederhanaan diagram PlantUML.
- `docs/usecase.md` -> Menghapus Midtrans sebagai aktor, mengelompokkan use case berdasarkan role, dan menambahkan catatan bahwa Midtrans adalah payment gateway eksternal.
- `context/current-progress.md` -> Mencatat perbaikan use case agar lebih rapi.
- `context/changelog.md` -> Mencatat perbaikan use case dan koreksi posisi Midtrans.
- `docs/usecase.md` -> Dibuat ulang dengan satu boundary sistem besar, aktor di sisi luar, use case oval di dalam, serta layout helper agar lebih menyerupai `docs/contohusecase.png`.
- `context/current-progress.md` -> Mencatat pembaruan use case berdasarkan contoh gambar.
- `context/changelog.md` -> Mencatat pembaruan use case agar mengikuti contoh gambar.
- `docs/usecase.md` -> Menghapus layout helper horizontal yang membuat diagram melebar, memindahkan Tutor/Admin ke sisi kanan, dan mengelompokkan use case dalam package agar lebih rapi.
- `context/current-progress.md` -> Mencatat perbaikan layout use case.
- `context/changelog.md` -> Mencatat perbaikan layout use case agar tidak berantakan saat dirender.
- `docs/usecase.md` -> Menambahkan keterangan use case per role dan penjelasan relasi include/extend.
- `context/current-progress.md` -> Mencatat penambahan keterangan teks use case.
- `context/changelog.md` -> Mencatat penambahan keterangan teks use case.
- `docs/laporan-ruangajar-unila.md` -> Laporan lengkap BAB I sampai BAB VI berdasarkan struktur yang diminta dan gaya referensi dokumen.
- `context/current-progress.md` -> Mencatat penyusunan laporan RuangAjar Unila.
- `context/changelog.md` -> Mencatat penambahan laporan proyek.
- `docs/laporan-ruangajar-unila.md` -> Memperbarui subbab 3.1 agar setiap anggota memiliki peran Scrum sekaligus kontribusi sebagai full-stack developer.
- `context/current-progress.md` -> Mencatat pembaruan bagian peran tim.
- `context/changelog.md` -> Mencatat pembaruan pembagian peran tim pada laporan.
- `docs/laporan-ruangajar-unila.md` -> Memperjelas pembagian full-stack: Dhito untuk Public Visitor dan Learner, Rayham untuk Admin, Firman untuk Tutor dan dokumentasi teknis.
- `context/current-progress.md` -> Mencatat pembaruan spesifik pembagian role fitur.
- `context/changelog.md` -> Mencatat pembaruan spesifik pembagian role fitur.
- `docs/laporan-ruangajar-unila.md` -> Menambahkan subbab 3.3 Analisis Kebutuhan Sistem, 3.3.1 Kebutuhan Fungsional, dan 3.3.2 Kebutuhan Nonfungsional.
- `docs/laporan-ruangajar-unila.md` -> Menyesuaikan penomoran Product Backlog Item dari 3.3 menjadi 3.4.
- `context/current-progress.md` -> Mencatat penambahan kebutuhan sistem pada laporan.
- `context/changelog.md` -> Mencatat penambahan kebutuhan fungsional dan nonfungsional.
- `docs/laporan-ruangajar-unila.md` -> Meringkas tabel kebutuhan nonfungsional menjadi 6 kriteria utama berbasis kondisi deployment.
- `context/current-progress.md` -> Mencatat peringkasan kebutuhan nonfungsional.
- `context/changelog.md` -> Mencatat peringkasan kebutuhan nonfungsional pada laporan.
- `docs/laporan-ruangajar-unila.md` -> Menambahkan penjelasan naratif pada subbab 4.2.2.1 Use Case Diagram Fitur Sprint 2.
- `docs/laporan-ruangajar-unila.md` -> Menambahkan penjelasan naratif pada subbab 4.2.2.2 Activity Diagram Fitur Sprint 2.
- `context/current-progress.md` -> Mencatat penambahan penjelasan UML.
- `context/changelog.md` -> Mencatat penambahan penjelasan Use Case Diagram dan Activity Diagram.
- `docs/laporan-ruangajar-unila.md` -> Meringkas dan menyesuaikan penjelasan subbab 4.2.2.1 dengan gambar final use case.
- `context/current-progress.md` -> Mencatat penyesuaian penjelasan use case final.
- `context/changelog.md` -> Mencatat penyesuaian penjelasan use case final.

## Blockers / Bugs Found
- `git status --short` gagal dijalankan karena error sandbox Windows `CreateProcessWithLogonW failed: 1056`; perubahan file tetap dilanjutkan karena hanya membuat dokumentasi context.
- Belum ada test runner otomatis seperti Composer/PHPUnit atau npm script yang terdeteksi.
- Error runtime: `mysqli_sql_exception: No connection could be made because the target machine actively refused it` terjadi karena aplikasi mencoba konek ke MySQL port `3307`, sementara database lokal tersedia di port `3306`.

## Next Immediate Action
- Review kembali subbab 4.2.2.1 setelah gambar final use case dimasukkan ke dokumen Word.
