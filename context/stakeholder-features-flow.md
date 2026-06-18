# Stakeholder Features & System Flow

## Purpose
Dokumen ini memetakan fitur berdasarkan stakeholder dan menjelaskan alur kerja utama sistem RuangAjar Unila. Gunakan file ini sebagai acuan saat membuat fitur baru, memperbaiki bug, menyusun QA checklist, atau menjelaskan scope aplikasi kepada stakeholder.

## Stakeholders
### Public Visitor
Public visitor adalah pengguna yang belum login dan ingin mengenal layanan, mencari tutor, atau melihat informasi awal sebelum mendaftar/masuk.

Fitur utama:
- Melihat landing page RuangAjar Unila.
- Melihat kategori atau daftar tutor.
- Mencari tutor berdasarkan keyword, fakultas, program studi/mata pelajaran, harga, atau rating jika filter tersedia.
- Melihat detail profil tutor, mata pelajaran, harga, rating, dan deskripsi.
- Melihat testimoni.
- Masuk ke halaman login atau registrasi.

Output yang diharapkan:
- Visitor memahami layanan dan dapat menemukan tutor yang relevan.
- Visitor diarahkan login/register saat ingin melakukan aksi privat seperti booking.

### Learner / Mahasiswa
Learner adalah mahasiswa yang mencari bantuan belajar dan melakukan pemesanan sesi tutor.

Fitur utama:
- Register sebagai learner.
- Login dan logout.
- Mengakses dashboard learner.
- Mencari tutor.
- Melihat detail tutor.
- Memilih mata pelajaran dan jadwal sesi.
- Membuat booking.
- Melakukan proses pembayaran melalui Midtrans sandbox jika pembayaran diaktifkan.
- Melihat sesi aktif dan riwayat booking.
- Melihat status booking dan payment status.
- Memberikan review/rating setelah sesi selesai.
- Mengelola profil.

Output yang diharapkan:
- Learner dapat menemukan tutor, membuat booking valid, membayar, mengikuti sesi, dan memberi feedback.

### Tutor
Tutor adalah mahasiswa Unila yang menawarkan jasa bimbingan belajar.

Fitur utama:
- Register sebagai tutor.
- Login dan logout.
- Mengakses dashboard tutor.
- Mengelola profil tutor.
- Mengubah password.
- Mengatur status ketersediaan.
- Mengelola mata pelajaran/subject yang diajarkan.
- Membuat dan mengelola iklan tutor.
- Melihat daftar booking dari learner.
- Mengubah status booking sesuai proses belajar.
- Melihat jadwal dan mahasiswa yang dibimbing.
- Mengatur preferensi notifikasi.
- Menghapus akun jika flow tersedia.

Output yang diharapkan:
- Tutor dapat mempublikasikan layanan, menerima booking, mengelola jadwal, dan menyelesaikan sesi belajar.

### Admin
Admin adalah pengelola sistem yang bertanggung jawab atas data master, validasi, dan pengawasan platform.

Fitur utama:
- Login dan logout sebagai admin.
- Mengakses dashboard admin.
- Melihat ringkasan data pengguna, tutor, mahasiswa, dan aktivitas sistem.
- Mengelola data mahasiswa.
- Mengelola data tutor.
- Menghapus user jika diperlukan.
- Memverifikasi tutor.
- Membuka halaman pengaturan admin.
- Mengawasi data yang tidak valid atau perlu koreksi.

Output yang diharapkan:
- Admin dapat menjaga kualitas data, memvalidasi tutor, dan memastikan sistem berjalan sesuai kebutuhan prototype.

### External Payment Provider
Midtrans sandbox berperan sebagai layanan eksternal untuk membuat transaksi dan memberi notifikasi status pembayaran.

Fitur utama:
- Menerima request pembuatan transaksi dari backend.
- Mengembalikan snap token atau response transaksi.
- Mengirim notifikasi status pembayaran.

Output yang diharapkan:
- Sistem mendapatkan status pembayaran yang dapat dipakai untuk memperbarui `bookings.payment_status`.

## System Flow
### 1. Public Discovery Flow
1. User membuka landing page.
2. Sistem menampilkan informasi layanan, CTA, kategori, tutor unggulan/testimoni jika tersedia.
3. User menggunakan pencarian atau membuka kategori.
4. Sistem mengambil data tutor/subject/review dari database.
5. User membuka detail tutor.
6. Sistem menampilkan profil tutor, subject, harga, rating, dan opsi booking.
7. Jika user belum login dan menekan booking, sistem mengarahkan ke login/register.

Data utama:
- `tutor`
- `subjects`
- `tutor_mapel`
- `reviews`
- `iklan_tutor`

### 2. Authentication & Role Routing Flow
1. User membuka halaman login/register.
2. Sistem menerima input email, password, dan role jika register.
3. Backend memvalidasi input.
4. Untuk login, backend mencari user di `users` dan memverifikasi password.
5. Jika valid, sistem menyimpan session user dan role.
6. Sistem mengarahkan user ke dashboard sesuai role:
- Admin -> dashboard admin.
- Tutor -> dashboard tutor.
- Learner -> dashboard mahasiswa/learner.
7. Jika logout, sistem menghancurkan session dan mengarahkan user ke halaman publik/login.

Data utama:
- `users`
- `tutor`
- `mahasiswa`

Catatan penting:
- Role harus dicek ulang pada setiap halaman/proses privat.
- Password tidak boleh dibandingkan sebagai plaintext.

### 3. Learner Booking Flow
1. Learner login.
2. Learner mencari tutor atau membuka detail tutor.
3. Learner memilih subject, tanggal, jam, durasi, dan catatan jika tersedia.
4. Backend memvalidasi learner session, tutor, subject, jadwal, dan input booking.
5. Sistem membuat record di `bookings` dengan status awal `pending` dan payment status awal `unpaid` atau `pending` sesuai flow pembayaran.
6. Jika pembayaran aktif, sistem membuat transaksi Midtrans dan menyimpan `snap_token` serta `midtrans_order_id`.
7. Learner menyelesaikan pembayaran di Midtrans sandbox.
8. Sistem menerima notifikasi pembayaran dan memperbarui `payment_status`.
9. Tutor/admin dapat mengonfirmasi atau memproses status booking.
10. Setelah sesi selesai, status booking menjadi `completed`.

Data utama:
- `bookings`
- `mahasiswa`
- `tutor`
- `subjects`

Status utama:
- `bookings.status`: `pending`, `confirmed`, `completed`, `cancelled`
- `bookings.payment_status`: `unpaid`, `pending`, `paid`, `failed`

### 4. Tutor Service Management Flow
1. Tutor login.
2. Tutor membuka dashboard.
3. Tutor melengkapi atau memperbarui profil.
4. Tutor menambahkan subject/mata pelajaran dan harga.
5. Tutor membuat iklan tutor jika diperlukan.
6. Tutor mengatur status ketersediaan.
7. Sistem menampilkan tutor pada pencarian public/learner jika status dan data memenuhi syarat.
8. Tutor menerima booking dari learner.
9. Tutor memperbarui status booking sesuai progres sesi.

Data utama:
- `tutor`
- `subjects`
- `tutor_mapel`
- `iklan_tutor`
- `bookings`

Catatan penting:
- Tutor hanya boleh mengubah data miliknya sendiri.
- Perubahan status booking harus memastikan booking memang terkait dengan tutor yang sedang login.

### 5. Review & Rating Flow
1. Learner login dan membuka riwayat/sesi.
2. Sistem menampilkan booking learner.
3. Learner memilih booking yang sudah selesai.
4. Backend memvalidasi bahwa booking milik learner tersebut dan statusnya layak direview.
5. Learner mengirim rating 1 sampai 5 dan review text.
6. Sistem menyimpan review ke `reviews`.
7. Sistem memperbarui atau menghitung ulang rating tutor jika fitur tersebut diterapkan.
8. Review tampil di detail tutor/testimoni sesuai kebutuhan halaman.

Data utama:
- `reviews`
- `bookings`
- `mahasiswa`
- `tutor`

Catatan penting:
- Satu booking idealnya hanya bisa direview satu kali.
- Rating harus divalidasi pada backend.

### 6. Admin Verification & Data Management Flow
1. Admin login.
2. Admin membuka dashboard admin.
3. Admin melihat data tutor/mahasiswa/user.
4. Admin melakukan tambah, edit, hapus, atau verifikasi sesuai halaman yang tersedia.
5. Backend memvalidasi admin session dan input.
6. Sistem memperbarui tabel terkait.
7. Perubahan data langsung mempengaruhi tampilan public, tutor, atau learner sesuai domain datanya.

Data utama:
- `users`
- `tutor`
- `mahasiswa`
- `subjects`
- `bookings`

Catatan penting:
- Operasi hapus harus mempertimbangkan foreign key cascade.
- Perubahan data user harus menjaga konsistensi antara `users`, `tutor`, dan `mahasiswa`.

### 7. Payment Notification Flow
1. Learner membuat booking dan transaksi Midtrans.
2. Sistem menyimpan `snap_token` dan `midtrans_order_id` pada booking.
3. Midtrans mengirim notifikasi ke endpoint backend.
4. Backend memvalidasi payload notifikasi dan order id.
5. Backend mencocokkan order id dengan `bookings.midtrans_order_id`.
6. Jika transaksi valid, backend memperbarui `payment_status`.
7. Jika pembayaran berhasil, sistem dapat melanjutkan status booking sesuai aturan bisnis.

Data utama:
- `bookings.snap_token`
- `bookings.midtrans_order_id`
- `bookings.payment_status`

Catatan penting:
- Jangan mengubah status pembayaran hanya dari input frontend.
- Endpoint notifikasi pembayaran harus aman dari update palsu.

## Cross-Stakeholder Rules
- Public visitor tidak boleh mengakses fitur privat tanpa login.
- Learner hanya boleh melihat dan mengubah data booking miliknya sendiri.
- Tutor hanya boleh mengelola profil, subject, iklan, dan booking miliknya sendiri.
- Admin memiliki akses pengelolaan data, tetapi perubahan tetap harus tervalidasi.
- Semua input dari form, query string, AJAX, dan webhook harus divalidasi di backend.
- Semua output dari database yang ditampilkan ke HTML harus di-escape.
- Semua fitur yang mengubah data harus memiliki alur sukses, gagal validasi, dan gagal otorisasi yang jelas.

## Feature-to-File Map
### Public Visitor
- Pages: `src/frontend/pages/public`
- Assets: `src/assets`, `src/frontend/assets`

### Auth
- Pages: `src/frontend/pages/auth`
- Processes: `src/backend/auth`
- Tables: `users`, `tutor`, `mahasiswa`

### Learner
- Pages: `src/frontend/pages/learner`
- Processes: `src/backend/learner`
- Tables: `mahasiswa`, `bookings`, `subjects`, `tutor`, `reviews`

### Tutor
- Pages: `src/frontend/pages/tutor`
- Processes: `src/backend/tutor`
- Tables: `tutor`, `subjects`, `tutor_mapel`, `iklan_tutor`, `bookings`

### Admin
- Pages: `src/frontend/pages/admin`
- Processes: `src/backend/admin`
- Tables: `users`, `tutor`, `mahasiswa`, `subjects`, `bookings`

## Definition of Done for Feature Workflows
- Stakeholder pengguna fitur jelas.
- Role/session guard diterapkan.
- Input tervalidasi di backend.
- Query memakai prepared statement untuk input user.
- Data yang berubah sesuai schema `database/ruangajar.sql`.
- Alur sukses dan gagal bisa diuji manual.
- Dokumentasi context terkait diperbarui bila flow, schema, atau keputusan arsitektur berubah.
