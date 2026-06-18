# Setup Project RuangAjar Unila di Local dengan Laragon

Dokumen ini menjelaskan langkah setup project RuangAjar Unila dari nol sampai berjalan di local menggunakan Laragon.

## 1. Prasyarat
Pastikan perangkat sudah memiliki:
- Laragon versi terbaru/stabil.
- PHP minimal 7.4 atau versi PHP bawaan Laragon yang kompatibel.
- MySQL/MariaDB dari Laragon.
- Browser modern seperti Chrome, Edge, atau Firefox.
- Git, jika ingin clone repository lewat terminal.

Project ini tidak memakai Composer atau npm sebagai syarat utama karena stack saat ini adalah PHP native/procedural, HTML, CSS, JavaScript native, dan MySQL.

## 2. Siapkan Folder Project
Project harus berada di dalam folder web root Laragon:

```text
C:\laragon\www\RuangAjar-Unila
```

Jika project belum ada, clone atau salin folder project ke:

```text
C:\laragon\www\
```

Struktur minimal setelah disalin:

```text
RuangAjar-Unila/
├── database/
│   └── ruangajar.sql
├── src/
│   ├── backend/
│   ├── config/
│   └── frontend/
├── index.php
└── README.md
```

## 3. Jalankan Laragon
1. Buka Laragon.
2. Klik `Start All`.
3. Pastikan service Apache/Nginx dan MySQL berjalan.

Jika MySQL gagal berjalan, cek apakah ada XAMPP/MySQL lain yang sedang memakai port yang sama. Matikan service yang bentrok atau ubah port MySQL di Laragon.

## 4. Cek Port MySQL Laragon
Project saat ini memakai konfigurasi:

```php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'ruangajar';
$port = 3307;
```

File konfigurasi berada di:

```text
src/config/database.php
```

Cara mengecek port MySQL di Laragon:
1. Buka Laragon.
2. Klik kanan area Laragon.
3. Pilih `MySQL` -> `my.ini`.
4. Cari nilai `port`.

Jika Laragon memakai port `3306`, ubah file `src/config/database.php` menjadi:

```php
$port = 3306;
```

Jika Laragon memakai port `3307`, biarkan:

```php
$port = 3307;
```

## 5. Buat Database
Gunakan HeidiSQL, phpMyAdmin, atau terminal MySQL.

### Opsi A: HeidiSQL dari Laragon
1. Buka Laragon.
2. Klik `Database`.
3. Login dengan user `root` dan password kosong jika masih default.
4. Buat database baru dengan nama:

```sql
ruangajar
```

5. Pilih database `ruangajar`.
6. Import file:

```text
database/ruangajar.sql
```

### Opsi B: phpMyAdmin
1. Buka:

```text
http://localhost/phpmyadmin
```

2. Login dengan user `root` dan password kosong jika masih default.
3. Klik `New`.
4. Buat database:

```sql
ruangajar
```

5. Masuk ke database `ruangajar`.
6. Klik tab `Import`.
7. Pilih file:

```text
C:\laragon\www\RuangAjar-Unila\database\ruangajar.sql
```

8. Klik `Go`.

## 6. Verifikasi Database
Setelah import berhasil, pastikan tabel berikut ada:
- `users`
- `tutor`
- `mahasiswa`
- `subjects`
- `tutor_mapel`
- `iklan_tutor`
- `bookings`
- `reviews`

Pastikan juga tabel `users`, `tutor`, `mahasiswa`, dan `subjects` memiliki data awal.

## 7. Konfigurasi Database Project
Buka:

```text
src/config/database.php
```

Sesuaikan dengan konfigurasi Laragon lokal:

```php
<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'ruangajar';
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

Checklist konfigurasi:
- `$host` biasanya `127.0.0.1`.
- `$user` biasanya `root`.
- `$pass` biasanya kosong pada Laragon default.
- `$db` harus `ruangajar`.
- `$port` harus sama dengan port MySQL Laragon.

## 8. Konfigurasi Midtrans Sandbox
Buka:

```text
src/config/midtrans_config.php
```

Default project masih memakai placeholder:

```php
define('MIDTRANS_SERVER_KEY', 'YOUR_SERVER_KEY_HERE');
define('MIDTRANS_CLIENT_KEY', 'YOUR_CLIENT_KEY_HERE');
define('MIDTRANS_MERCHANT_ID', 'YOUR_MERCHANT_ID_HERE');
define('MIDTRANS_IS_PRODUCTION', false);
```

Untuk menjalankan fitur non-payment, placeholder ini bisa dibiarkan.

Untuk menguji pembayaran:
1. Buat akun Midtrans sandbox.
2. Ambil `Server Key`, `Client Key`, dan `Merchant ID`.
3. Isi file `src/config/midtrans_config.php`.
4. Pastikan `MIDTRANS_IS_PRODUCTION` tetap `false` selama development.

## 9. Jalankan Project di Browser
Buka salah satu URL berikut:

Root project:

```text
http://localhost/RuangAjar-Unila/
```

Landing page langsung:

```text
http://localhost/RuangAjar-Unila/src/frontend/pages/public/landing_page.php
```

Halaman login:

```text
http://localhost/RuangAjar-Unila/src/frontend/pages/auth/login.php
```

Jika Laragon memakai pretty URL otomatis seperti `ruangajar-unila.test`, URL dapat menyesuaikan konfigurasi Laragon:

```text
http://ruangajar-unila.test/
```

## 10. Akun Demo
Gunakan akun berikut untuk uji coba.

### Admin
- Email: `admin@ruangajar.unila.ac.id`
- Password: `password`

### Tutor
- Email: `dimas@students.unila.ac.id`
- Email: `rizky@students.unila.ac.id`
- Password: `password`

### Learner / Mahasiswa
- Email: `budi@students.unila.ac.id`
- Email: `citra@students.unila.ac.id`
- Password: `password`

## 11. Smoke Test Setelah Setup
Lakukan pengecekan singkat ini untuk memastikan project berjalan:

1. Buka landing page.
2. Pastikan CSS dan gambar tampil.
3. Buka halaman login.
4. Login sebagai admin.
5. Pastikan dashboard admin tampil.
6. Logout.
7. Login sebagai tutor.
8. Pastikan dashboard tutor tampil.
9. Logout.
10. Login sebagai learner.
11. Cari tutor dan buka detail tutor.
12. Jika menguji booking, pastikan data subject tutor tersedia.

## 12. Troubleshooting
### Error: `Koneksi gagal`
Penyebab umum:
- MySQL Laragon belum berjalan.
- Database `ruangajar` belum dibuat.
- File `database/ruangajar.sql` belum diimport.
- Port MySQL di `src/config/database.php` tidak sama dengan port Laragon.
- Username/password MySQL berbeda dari default.

Solusi:
- Klik `Start All` di Laragon.
- Cek database melalui HeidiSQL/phpMyAdmin.
- Sesuaikan `$host`, `$user`, `$pass`, `$db`, dan `$port` di `src/config/database.php`.

### Error: `Unknown database 'ruangajar'`
Solusi:
- Buat database bernama `ruangajar`.
- Import ulang `database/ruangajar.sql`.

### Halaman putih / blank page
Penyebab umum:
- Error PHP tidak tampil.
- Include path salah.
- Koneksi database gagal sebelum render.

Solusi:
- Cek log Apache/Nginx Laragon.
- Pastikan URL mengarah ke folder project yang benar.
- Jalankan syntax check untuk file PHP yang baru diubah:

```powershell
php -l path\to\file.php
```

### CSS atau gambar tidak tampil
Penyebab umum:
- Project tidak berada di `C:\laragon\www\RuangAjar-Unila`.
- URL root berbeda dari yang dipakai di path asset.
- Browser menyimpan cache lama.

Solusi:
- Pastikan folder project benar.
- Buka lewat `http://localhost/RuangAjar-Unila/`.
- Hard refresh browser dengan `Ctrl + F5`.

### Login selalu gagal
Penyebab umum:
- Data dummy belum terimport.
- Password hash di database tidak sesuai data demo.
- Login memakai role/page yang tidak sesuai.

Solusi:
- Pastikan tabel `users` berisi akun demo.
- Import ulang `database/ruangajar.sql`.
- Gunakan email dan password dari bagian Akun Demo.

### Midtrans gagal
Penyebab umum:
- Key Midtrans masih placeholder.
- Internet tidak tersedia.
- Menggunakan credential production saat mode sandbox.

Solusi:
- Isi `src/config/midtrans_config.php` dengan credential sandbox.
- Pastikan `MIDTRANS_IS_PRODUCTION` bernilai `false`.
- Uji fitur utama non-payment terlebih dahulu.

## 13. Checklist Setup Selesai
- [ ] Laragon berjalan.
- [ ] Project berada di `C:\laragon\www\RuangAjar-Unila`.
- [ ] Database `ruangajar` sudah dibuat.
- [ ] `database/ruangajar.sql` sudah diimport.
- [ ] Port MySQL di `src/config/database.php` sudah sesuai.
- [ ] Landing page bisa dibuka.
- [ ] Login admin berhasil.
- [ ] Login tutor berhasil.
- [ ] Login learner berhasil.
- [ ] Fitur pencarian/detail tutor bisa dibuka.

Jika semua checklist terpenuhi, project sudah siap dikembangkan di local.
