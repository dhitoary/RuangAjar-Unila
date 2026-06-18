# Database Schema & Data Models

## Entity Relationship Summary
Database `ruangajar` memakai MySQL relasional. Tabel `users` menyimpan akun autentikasi dan role global. Data profil tutor disimpan pada `tutor`, sedangkan data learner/mahasiswa disimpan pada `mahasiswa`. Tutor memiliki banyak `subjects`, `tutor_mapel`, dan `iklan_tutor`. Learner membuat `bookings` terhadap tutor dan subject tertentu. Setelah booking selesai, learner dapat membuat `reviews`.

Relasi utama:
- `subjects.tutor_id` -> `tutor.id`
- `tutor_mapel.tutor_id` -> `tutor.id`
- `iklan_tutor.tutor_id` -> `tutor.id`
- `bookings.learner_id` -> `mahasiswa.id`
- `bookings.tutor_id` -> `tutor.id`
- `bookings.subject_id` -> `subjects.id`
- `reviews.booking_id` -> `bookings.id`
- `reviews.learner_id` -> `mahasiswa.id`
- `reviews.tutor_id` -> `tutor.id`

## Table Definitions
### `users`
- `id` (INT, Primary Key, Auto Increment)
- `nama_lengkap` (VARCHAR(100), Not Null)
- `email` (VARCHAR(100), Unique, Not Null)
- `password` (VARCHAR(255), Not Null)
- `role` (ENUM: `admin`, `tutor`, `learner`, Not Null)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `tutor`
- `id` (INT, Primary Key, Auto Increment)
- `nama_lengkap` (VARCHAR(100), Not Null)
- `email` (VARCHAR(100), Unique, Not Null)
- `npm` (VARCHAR(20), Nullable)
- `angkatan` (INT, Default 2022)
- `fakultas` (VARCHAR(100), Default `FMIPA`)
- `telepon` (VARCHAR(15), Nullable)
- `keahlian` (VARCHAR(50), Nullable)
- `pendidikan` (VARCHAR(100), Nullable)
- `pengalaman_mengajar` (INT, Default 0)
- `harga_per_sesi` (INT, Default 0)
- `deskripsi` (TEXT, Nullable)
- `status` (ENUM: `Aktif`, `Non-Aktif`, `Cuti`, Default `Non-Aktif`)
- `rating` (DECIMAL(3,2), Default 0.00)
- `foto_profil` (VARCHAR(255), Nullable)
- `password` (VARCHAR(255), Nullable)
- `email_notification` (TINYINT(1), Default 1)
- `booking_notification` (TINYINT(1), Default 1)
- `reminder_notification` (TINYINT(1), Default 1)
- `availability_status` (ENUM: `Tersedia`, `Sibuk`, `Tidak Tersedia`, Default `Tersedia`)
- `availability_note` (VARCHAR(255), Nullable)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `mahasiswa`
- `id` (INT, Primary Key, Auto Increment)
- `nim` (VARCHAR(20), Nullable)
- `angkatan` (INT, Default 2024)
- `fakultas` (VARCHAR(100), Default `FMIPA`)
- `nama_lengkap` (VARCHAR(100), Not Null)
- `email` (VARCHAR(100), Unique, Not Null)
- `jenjang` (ENUM: `SD`, `SMP`, `SMA`, Nullable)
- `sekolah` (VARCHAR(100), Nullable)
- `kelas` (VARCHAR(50), Nullable)
- `minat` (TEXT, Nullable)
- `status` (ENUM: `Aktif`, `Cuti`, `Non-Aktif`, Default `Aktif`)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `subjects`
- `id` (INT, Primary Key, Auto Increment)
- `tutor_id` (INT, FK -> `tutor.id`, Not Null)
- `subject_name` (VARCHAR(100), Not Null)
- `description` (TEXT, Nullable)
- `price` (INT, Not Null, Default 0)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `tutor_mapel`
- `id` (INT, Primary Key, Auto Increment)
- `tutor_id` (INT, FK -> `tutor.id`, Not Null)
- `nama_mapel` (VARCHAR(50), Not Null)
- `jenjang` (ENUM: `SD`, `SMP`, `SMA`, `Umum`, Not Null)

### `iklan_tutor`
- `id` (INT, Primary Key, Auto Increment)
- `tutor_id` (INT, FK -> `tutor.id`, Not Null)
- `judul` (VARCHAR(255), Not Null)
- `deskripsi` (TEXT, Not Null)
- `subject` (VARCHAR(100), Not Null)
- `jenjang` (ENUM: `SD`, `SMP`, `SMA`, `Umum`, Not Null)
- `harga` (INT, Not Null)
- `kota` (VARCHAR(100), Nullable)
- `pengalaman` (VARCHAR(255), Nullable)
- `status` (ENUM: `aktif`, `non-aktif`, Default `aktif`)
- `foto` (VARCHAR(255), Nullable)
- `video_url` (VARCHAR(255), Nullable)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `bookings`
- `id` (INT, Primary Key, Auto Increment)
- `learner_id` (INT, FK -> `mahasiswa.id`, Not Null)
- `tutor_id` (INT, FK -> `tutor.id`, Not Null)
- `subject_id` (INT, FK -> `subjects.id`, Not Null)
- `booking_date` (DATE, Not Null)
- `booking_time` (TIME, Not Null)
- `duration` (INT, Default 60)
- `status` (ENUM: `pending`, `confirmed`, `completed`, `cancelled`, Default `pending`)
- `payment_status` (ENUM: `unpaid`, `pending`, `paid`, `failed`, Default `unpaid`)
- `snap_token` (VARCHAR(255), Nullable)
- `midtrans_order_id` (VARCHAR(100), Nullable)
- `notes` (TEXT, Nullable)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)

### `reviews`
- `id` (INT, Primary Key, Auto Increment)
- `tutor_id` (INT, FK -> `tutor.id`, Not Null)
- `learner_id` (INT, FK -> `mahasiswa.id`, Not Null)
- `booking_id` (INT, FK -> `bookings.id`, Not Null)
- `rating` (INT, Not Null, CHECK 1 sampai 5)
- `review_text` (TEXT, Nullable)
- `created_at` (TIMESTAMP, Default CURRENT_TIMESTAMP)
