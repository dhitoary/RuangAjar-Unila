# RuangAjar Unila
**Platform Penghubung Mahasiswa & Tutor Sebaya Universitas Lampung**

> **Project Mata Kuliah Agile Software Development**  
> Tema: *Platform Tutor Sebaya Universitas Lampung*

---

## Anggota Kelompok

| No | Nama | NPM |
| :--- | :--- | :--- | 
| 1. | Dhito Aryo Trengginas | 2315061015 |
| 2. | Muhammad Rayham Gumay | 2355061007 |
| 3. | Firman Farel Richardo | 2315061099 | 

---

## Deskripsi Proyek

**RuangAjar Unila** adalah platform marketplace jasa edukasi yang dirancang untuk menjembatani kesenjangan antara mahasiswa Unila yang membutuhkan bimbingan belajar dengan mahasiswa yang berprestasi yang mencari pengalaman mengajar tambahan.

### Fitur Utama:
1. **Admin:** Manajemen pengguna, validasi, dan pengawasan.
2. **Public:** Pencarian tutor real-time berdasarkan Fakultas, Program Studi, & Harga.
3. **Tutor (Mahasiswa Unila):** Kelola sesi mengajar dan lihat riwayat booking.
4. **Learner (Mahasiswa Unila):** Booking jadwal tutor pilihan sesuai mata kuliah Universitas.

---

## Teknologi yang Digunakan

* **Frontend:** HTML5, Vanilla CSS, JavaScript (Native)
* **Backend:** PHP (Native/Procedural)
* **Database:** MySQL
* **Payment Gateway:** Midtrans (Menunggu Integrasi Penuh)

---

## Database Schema

Database **ruangajar** dirancang menggunakan arsitektur relasional, terdiri dari tabel utama:
- `users`: Autentikasi dan hak akses (Admin, Tutor, Learner)
- `tutor` & `mahasiswa`: Data diri akademik spesifik mahasiswa Unila (NPM, Fakultas, Angkatan)
- `tutor_mapel` & `subjects`: Relasi mata kuliah yang diajarkan
- `bookings` & `reviews`: Logika sistem pemesanan dan penilaian

---

## Akses Login (Data Uji Coba)

Untuk menguji fitur dalam aplikasi, silakan masuk menggunakan kredensial percobaan berikut:

### 1. Akun Admin
Akses halaman dashboard master.
- **URL**: `http://localhost/RuangAjar-Unila/src/backend/admin/login.php` *(sesuaikan dengan root localhost Anda)*
- **Email**: `admin@ruangajar.unila.ac.id`
- **Password**: `password` *(atau admin123 jika belum diupdate)*

### 2. Akun Tutor
Akses profil pengajar untuk menerima jadwal.
- **Email**: `dimas@students.unila.ac.id` (Contoh Tutor FT)
- **Email**: `rizky@students.unila.ac.id` (Contoh Tutor FMIPA)
- **Password**: `password`

### 3. Akun Mahasiswa (Learner)
Akses sistem pemesanan dan review tutor.
- **Email**: `budi@students.unila.ac.id` (Contoh Mahasiswa FMIPA)
- **Email**: `citra@students.unila.ac.id` (Contoh Mahasiswa Teknik)
- **Password**: `password`

---

## Cara Menjalankan Aplikasi

### Prasyarat
- XAMPP / Laragon (PHP 7.4+, MySQL 5.7+)
- Browser modern (Chrome, Firefox, Edge)

### Langkah Instalasi
1. **Clone Repository**
   Tempatkan folder di dalam `C:\laragon\www\` (untuk Laragon) atau `C:\xampp\htdocs\` (untuk XAMPP).
   
2. **Setup Database**
   - Buka phpMyAdmin atau HeidiSQL.
   - Buat database baru dengan nama `ruangajar`.
   - Lakukan Import menggunakan struktur SQL yang telah diperbarui (termasuk dummy data `update_schema_unila.sql`).

3. **Konfigurasi Database**
   Buka file `src/config/database.php` dan sesuaikan kredensial Anda. Pastikan **port MySQL** sudah sesuai (misal `3306` atau `3307`).

4. **Jalankan Aplikasi**
   Buka browser dan akses direktori utamanya: `http://localhost/RuangAjar-Unila/src/frontend/pages/public/landing_page.php`

---

## Lisensi & Ucapan Terima Kasih

Proyek ini dibuat untuk memenuhi tugas **Mata Kuliah Agile Software Development** - Universitas Lampung. Terima kasih kepada dosen pengampu, serta seluruh pihak yang telah mendukung kelancaran pembuatan prototype sistem ini.

**© 2026 RuangAjar Unila**
