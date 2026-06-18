# Architecture Decisions Log (ADR)

## [ADR-001] Menggunakan PHP Native/Procedural untuk Prototype
- **Context**: Proyek dibuat untuk mata kuliah Agile Software Development dan sudah memiliki struktur PHP native dengan halaman dan process file terpisah.
- **Decision**: Mempertahankan PHP native/procedural sebagai stack utama selama fase prototype.
- **Consequences**: Development cepat dan mudah dijalankan di Laragon/XAMPP, tetapi disiplin validasi, session guard, dan prepared statement harus dijaga manual.

## [ADR-002] Menggunakan MySQL sebagai Database Relasional
- **Context**: Aplikasi membutuhkan relasi antara user, tutor, mahasiswa, subject, booking, dan review.
- **Decision**: Menggunakan MySQL dengan schema utama di `database/ruangajar.sql`.
- **Consequences**: Cocok untuk Laragon/XAMPP dan mudah diuji lewat phpMyAdmin/HeidiSQL. Semua perubahan schema harus disinkronkan dengan dokumentasi dan file SQL.

## [ADR-003] Role Aplikasi Dipisah Menjadi Admin, Tutor, Learner, dan Public
- **Context**: Aplikasi memiliki workflow berbeda untuk pengelolaan sistem, pengajaran, pemesanan, dan akses umum.
- **Decision**: Menetapkan role `admin`, `tutor`, dan `learner` di tabel `users`; public visitor tidak memiliki row session khusus.
- **Consequences**: Guard halaman dan proses backend harus mengecek role secara konsisten.

## [ADR-004] Midtrans Dimulai dari Sandbox
- **Context**: Pembayaran online dibutuhkan, tetapi credential production dan proses settlement nyata belum menjadi fokus fase awal.
- **Decision**: Menggunakan konfigurasi Midtrans sandbox di `src/config/midtrans_config.php`.
- **Consequences**: Aman untuk demo dan QA, tetapi sebelum production perlu verifikasi notifikasi, secret management, dan credential asli.
