```plantuml
@startuml
title RuangAjar Unila\n(Platform Tutor Sebaya Universitas Lampung)

left to right direction
skinparam monochrome true
skinparam shadowing false
skinparam actorStyle stick
skinparam packageStyle rectangle
skinparam defaultFontName Arial
skinparam linetype ortho
skinparam rectangle {
  BackgroundColor white
  BorderColor black
}
skinparam package {
  BackgroundColor white
  BorderColor black
}
skinparam usecase {
  BackgroundColor white
  BorderColor black
}
skinparam ArrowColor black

actor "Public\nVisitor" as Public
actor "Learner" as Learner

rectangle "RuangAjar Unila" {
  package "Akses Umum" {
    (Register) as UC_Register
    (Login) as UC_Login
    (Melihat Informasi\nPlatform) as UC_Info
    (Mencari Tutor) as UC_Search
    (Melihat Detail\nTutor) as UC_Detail
  }

  package "Fitur Learner" {
    (Mengelola Profil) as UC_LearnerProfile
    (Membuat Booking) as UC_Booking
    (Melakukan\nPembayaran) as UC_Payment
    (Melihat Riwayat\natau Sesi) as UC_History
    (Memberi Review) as UC_Review
  }

  package "Fitur Tutor" {
    (Mengelola Profil\nTutor) as UC_TutorProfile
    (Mengelola\nMata Pelajaran) as UC_Subject
    (Mengelola\nIklan Tutor) as UC_Ads
    (Mengatur\nKetersediaan) as UC_Availability
    (Mengelola\nStatus Booking) as UC_StatusBooking
  }

  package "Fitur Admin" {
    (Melihat Dashboard\nAdmin) as UC_AdminDashboard
    (Mengelola\nData Tutor) as UC_ManageTutor
    (Mengelola\nData Mahasiswa) as UC_ManageStudent
    (Memverifikasi\nTutor) as UC_VerifyTutor
  }

  package "Proses Sistem" {
    (Validasi Akun) as UC_ValidateAccount
    (Validasi Data\nBooking) as UC_ValidateBooking
    (Membuat Transaksi\nPembayaran) as UC_CreateTransaction
    (Menerima Notifikasi\nPembayaran) as UC_PaymentNotification
  }
}

actor "Tutor" as Tutor
actor "Admin" as Admin

Public --> UC_Info
Public --> UC_Search
Public --> UC_Detail
Public --> UC_Register
Public --> UC_Login

Learner --> UC_Login
Learner --> UC_Search
Learner --> UC_Detail
Learner --> UC_LearnerProfile
Learner --> UC_Booking
Learner --> UC_Payment
Learner --> UC_History
Learner --> UC_Review

Tutor --> UC_Login
Tutor --> UC_TutorProfile
Tutor --> UC_Subject
Tutor --> UC_Ads
Tutor --> UC_Availability
Tutor --> UC_StatusBooking

Admin --> UC_Login
Admin --> UC_AdminDashboard
Admin --> UC_ManageTutor
Admin --> UC_ManageStudent
Admin --> UC_VerifyTutor

UC_Login ..> UC_ValidateAccount : <<include>>
UC_Detail ..> UC_Search : <<extend>>
UC_Booking ..> UC_ValidateBooking : <<include>>
UC_Payment ..> UC_CreateTransaction : <<include>>
UC_PaymentNotification ..> UC_Payment : <<extend>>
UC_Review ..> UC_History : <<extend>>
UC_VerifyTutor ..> UC_ManageTutor : <<extend>>

note bottom of UC_CreateTransaction
Midtrans adalah payment gateway eksternal,
bukan stakeholder atau aktor sistem.
end note

@enduml
```

# Keterangan Use Case

## Public Visitor
- **Register**: Public visitor membuat akun baru agar dapat masuk sebagai learner atau tutor sesuai kebutuhan pendaftaran.
- **Login**: Public visitor masuk ke sistem menggunakan email dan password yang sudah terdaftar.
- **Melihat Informasi Platform**: Public visitor melihat landing page, informasi layanan, kategori tutor, dan testimoni.
- **Mencari Tutor**: Public visitor mencari tutor berdasarkan keyword atau filter yang tersedia.
- **Melihat Detail Tutor**: Public visitor membuka informasi detail tutor, seperti profil, mata pelajaran, harga, rating, dan review.

## Learner
- **Login**: Learner masuk ke sistem untuk mengakses fitur privat seperti booking, riwayat, dan review.
- **Mencari Tutor**: Learner mencari tutor yang sesuai dengan kebutuhan belajar.
- **Melihat Detail Tutor**: Learner memeriksa detail tutor sebelum melakukan booking.
- **Mengelola Profil**: Learner memperbarui data profil mahasiswa yang digunakan di dalam sistem.
- **Membuat Booking**: Learner memilih tutor, subject, tanggal, jam, durasi, dan catatan untuk membuat pemesanan sesi.
- **Melakukan Pembayaran**: Learner melakukan pembayaran booking melalui proses transaksi yang terhubung dengan payment gateway.
- **Melihat Riwayat atau Sesi**: Learner melihat daftar booking, status sesi, dan status pembayaran.
- **Memberi Review**: Learner memberikan rating dan ulasan setelah sesi selesai.

## Tutor
- **Login**: Tutor masuk ke sistem untuk mengelola layanan tutor dan booking.
- **Mengelola Profil Tutor**: Tutor memperbarui data profil, deskripsi, harga, keahlian, dan informasi akademik.
- **Mengelola Mata Pelajaran**: Tutor menambah, mengubah, atau menghapus mata pelajaran/subject yang diajarkan.
- **Mengelola Iklan Tutor**: Tutor membuat atau mengubah iklan jasa tutor yang ditampilkan ke calon learner.
- **Mengatur Ketersediaan**: Tutor mengatur status ketersediaan seperti tersedia, sibuk, atau tidak tersedia.
- **Mengelola Status Booking**: Tutor melihat booking masuk dan memperbarui status booking sesuai progres sesi.

## Admin
- **Login**: Admin masuk ke sistem untuk mengakses dashboard dan fitur pengelolaan data.
- **Melihat Dashboard Admin**: Admin melihat ringkasan data sistem seperti tutor, mahasiswa, user, dan aktivitas booking.
- **Mengelola Data Tutor**: Admin menambah, mengubah, menghapus, atau memeriksa data tutor.
- **Mengelola Data Mahasiswa**: Admin menambah, mengubah, menghapus, atau memeriksa data mahasiswa/learner.
- **Memverifikasi Tutor**: Admin memvalidasi data tutor dan mengubah status tutor agar dapat digunakan pada sistem.

## Proses Sistem
- **Validasi Akun**: Sistem memvalidasi email, password, dan role saat user melakukan login.
- **Validasi Data Booking**: Sistem memeriksa learner, tutor, subject, tanggal, jam, durasi, dan kelayakan data sebelum booking disimpan.
- **Membuat Transaksi Pembayaran**: Sistem membuat transaksi pembayaran dan menyimpan data transaksi seperti token/order ID.
- **Menerima Notifikasi Pembayaran**: Sistem menerima notifikasi dari payment gateway dan memperbarui status pembayaran booking.

## Relasi Include dan Extend
- **Login** `<<include>>` **Validasi Akun**: Setiap proses login wajib menjalankan validasi akun.
- **Melihat Detail Tutor** `<<extend>>` **Mencari Tutor**: Detail tutor biasanya dibuka setelah user menemukan tutor dari hasil pencarian.
- **Membuat Booking** `<<include>>` **Validasi Data Booking**: Booking wajib divalidasi sebelum disimpan.
- **Melakukan Pembayaran** `<<include>>` **Membuat Transaksi Pembayaran**: Pembayaran membutuhkan transaksi yang dibuat oleh sistem.
- **Menerima Notifikasi Pembayaran** `<<extend>>` **Melakukan Pembayaran**: Notifikasi pembayaran terjadi setelah proses pembayaran berjalan.
- **Memberi Review** `<<extend>>` **Melihat Riwayat atau Sesi**: Review diberikan dari riwayat/sesi yang sudah selesai.
- **Memverifikasi Tutor** `<<extend>>` **Mengelola Data Tutor**: Verifikasi tutor merupakan bagian lanjutan dari pengelolaan data tutor.
