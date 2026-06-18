# System Architecture & Design Patterns

## Tech Stack
- Frontend: HTML5, Vanilla CSS, JavaScript native.
- Backend: PHP native/procedural.
- Database: MySQL, database name `ruangajar`.
- Payment Gateway: Midtrans sandbox.
- Runtime lokal: Laragon/XAMPP, PHP 7.4+ atau versi stabil yang kompatibel.
- Web entry point: `index.php` redirect ke `src/frontend/pages/public/landing_page.php`.

## Architecture Style & Patterns
- Architecture style: Monolith sederhana berbasis PHP native.
- Backend process files berada di `src/backend/{role-or-domain}`.
- Frontend pages berada di `src/frontend/pages/{role-or-domain}`.
- Shared layout berada di `src/frontend/layouts`.
- Shared configuration berada di `src/config`.
- Static assets berada di `src/assets` dan `src/frontend/assets`.
- Database source of truth berada di `database/ruangajar.sql`.

## Repository Map
- `index.php`: Redirect root aplikasi ke landing page public.
- `README.md`: Dokumentasi umum proyek, fitur, credential demo, dan cara menjalankan aplikasi.
- `database/ruangajar.sql`: Schema dan data awal MySQL.
- `src/config/database.php`: Koneksi MySQL memakai `mysqli_connect`.
- `src/config/midtrans_config.php`: Konfigurasi Midtrans sandbox.
- `src/backend/auth`: Proses login, register, logout.
- `src/backend/admin`: CRUD mahasiswa/tutor, delete user, verifikasi tutor.
- `src/backend/tutor`: Proses profil, mata pelajaran, iklan, jadwal, booking, notifikasi.
- `src/backend/learner`: Proses booking, sesi, review, transaksi, dan notifikasi pembayaran.
- `src/frontend/pages/public`: Landing page, kategori, search result, detail tutor, testimoni.
- `src/frontend/pages/auth`: Halaman login/register/logout.
- `src/frontend/pages/admin`: Dashboard dan view admin.
- `src/frontend/pages/tutor`: Dashboard dan halaman kerja tutor.
- `src/frontend/pages/learner`: Dashboard dan halaman kerja learner.

## Coding Standards & Error Handling
- Pertahankan pola PHP native/procedural sampai ada keputusan ADR untuk migrasi framework.
- Query database harus memakai prepared statement untuk input user.
- Simpan validasi utama di backend process file, bukan hanya di JavaScript.
- Gunakan redirect dengan session flash/error message untuk form berbasis halaman.
- Gunakan response JSON untuk endpoint AJAX seperti pencarian, sesi, transaksi, dan notifikasi.
- Jangan menampilkan detail error database ke user umum; logika debug hanya untuk local development.
- Selalu cek role dan session sebelum mengakses halaman atau proses privat.
- Semua path include/require sebaiknya memakai `__DIR__` atau path relatif yang stabil dari file pemanggil.

## Clean Code, Maintainability, Scalability
- Struktur perubahan harus mengikuti domain yang sudah ada: `auth`, `admin`, `tutor`, `learner`, atau `public`.
- File backend proses bertanggung jawab atas validasi, otorisasi, transaksi database, dan redirect/JSON response.
- File frontend page bertanggung jawab atas struktur HTML, pemanggilan data yang diperlukan, dan render tampilan.
- Layout umum seperti header, sidebar, dan footer harus digunakan ulang melalui `src/frontend/layouts`.
- Helper baru hanya dibuat bila mengurangi duplikasi nyata atau menyatukan aturan penting seperti session guard, format response, atau sanitasi output.
- Nama fungsi/helper harus berbasis aksi dan domain, misalnya `requireTutorSession`, `findTutorSubjects`, atau `formatRupiah`.
- Query yang menampilkan daftar besar harus mendukung filter, limit, sorting, atau pagination agar tetap scalable.
- Hindari query N+1 pada daftar tutor, booking, subjects, atau reviews. Prefer JOIN/agregasi yang eksplisit.
- Hindari dependency global yang tidak jelas. Jika sebuah file membutuhkan koneksi database/session/config, include secara eksplisit.
- Perubahan schema harus disertai update pada `database/ruangajar.sql`, `context/database-schema.md`, dan checklist QA terkait.
- Perubahan flow penting harus dicatat di `context/decisions-log.md` jika mempengaruhi arah arsitektur.
- Perubahan yang sudah berhasil diterapkan harus dicatat di `context/changelog.md` dengan tanggal, jam, dan menit.
