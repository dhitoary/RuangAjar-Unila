# Testing & QA Guide

## Automated Testing
Belum ada test runner otomatis yang terdeteksi dari struktur repo saat ini.

Command pengecekan dasar yang dapat digunakan:
- Syntax check PHP per file: `php -l path/to/file.php`
- Syntax check banyak file via PowerShell: `Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }`

Jika test framework ditambahkan nanti, dokumentasikan command di bagian ini.

## Local Setup Validation
1. Pastikan Laragon/XAMPP berjalan.
2. Buat database MySQL bernama `ruangajar`.
3. Import `database/ruangajar.sql`.
4. Sesuaikan `src/config/database.php`, terutama host, user, password, database, dan port.
5. Buka `http://localhost/RuangAjar-Unila/src/frontend/pages/public/landing_page.php`.

## Manual QA Checklist
1. Public: Buka landing page dan pastikan aset gambar, CSS, dan navigasi tampil.
2. Public: Jalankan pencarian tutor dan pastikan hasil sesuai filter yang dipilih.
3. Public: Buka detail tutor dan pastikan data tutor, mata pelajaran, harga, rating, dan CTA tampil benar.
4. Auth: Login sebagai admin `admin@ruangajar.unila.ac.id` dengan password demo.
5. Admin: Buka dashboard, halaman mahasiswa, tutor, verifikasi, dan pengaturan.
6. Admin: Uji tambah/edit/hapus data non-kritis pada environment lokal.
7. Auth: Login sebagai tutor demo, misalnya `dimas@students.unila.ac.id`.
8. Tutor: Uji update profil, tambah/hapus mata pelajaran, buat iklan, ubah status ketersediaan, dan lihat jadwal.
9. Auth: Login sebagai learner demo, misalnya `budi@students.unila.ac.id`.
10. Learner: Cari tutor, buat booking, cek sesi saya, cek riwayat, dan submit review setelah status booking memungkinkan.
11. Payment: Uji flow Midtrans hanya dengan credential sandbox dan pastikan status booking tidak berubah ke `paid` tanpa verifikasi transaksi.
12. Security: Akses halaman admin/tutor/learner tanpa login dan pastikan diarahkan ke halaman login atau ditolak.

## Regression Areas
- Session dan role guard.
- Pencarian tutor dan filter harga/fakultas/program studi.
- Konsistensi data antara `users`, `tutor`, dan `mahasiswa`.
- Status booking: `pending`, `confirmed`, `completed`, `cancelled`.
- Payment status: `unpaid`, `pending`, `paid`, `failed`.
- Review hanya untuk booking yang valid.
