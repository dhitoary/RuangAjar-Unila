# Project Overview & Feature Scope

## Background & Objectives
RuangAjar Unila adalah platform marketplace jasa edukasi untuk menghubungkan mahasiswa Universitas Lampung yang membutuhkan bimbingan belajar dengan mahasiswa tutor sebaya yang memiliki kemampuan akademik atau pengalaman mengajar.

Tujuan utama aplikasi:
- Memudahkan learner menemukan tutor berdasarkan fakultas, program studi, mata kuliah, rating, dan harga.
- Memberikan ruang bagi tutor mahasiswa Unila untuk menawarkan sesi belajar dan mengelola booking.
- Menyediakan dashboard admin untuk mengelola user, data tutor, data mahasiswa, dan verifikasi tutor.
- Menjadi prototype mata kuliah Agile Software Development dengan alur autentikasi, pencarian tutor, booking, pembayaran, dan review.

## Target Users & Roles
- Admin: Mengelola data pengguna, mahasiswa, tutor, verifikasi tutor, dan pengawasan sistem.
- Tutor: Mengelola profil, mata pelajaran, iklan/jasa, jadwal, status ketersediaan, booking, notifikasi, dan pengaturan akun.
- Learner: Mencari tutor, melihat detail tutor, melakukan booking, melihat sesi/riwayat, mengelola profil, dan memberi review.
- Public Visitor: Melihat landing page, kategori, hasil pencarian, detail tutor, dan testimoni sebelum login.

## Feature Scope
### In-Scope (Wajib Dibuat)
- Autentikasi login, register, dan logout berbasis role.
- Dashboard admin, tutor, dan learner.
- Manajemen tutor dan mahasiswa oleh admin.
- Verifikasi status tutor oleh admin.
- Pencarian tutor berdasarkan data akademik, mata pelajaran, dan harga.
- Detail tutor public.
- Pengelolaan mata pelajaran oleh tutor.
- Pengelolaan profil dan ketersediaan tutor.
- Pembuatan iklan tutor.
- Booking sesi tutor oleh learner.
- Riwayat booking dan sesi.
- Review/rating setelah sesi.
- Integrasi pembayaran Midtrans sandbox.

### Out-of-Scope (TIDAK Dibuat di Fase Ini)
- Aplikasi mobile native.
- Chat real-time antara learner dan tutor.
- Video conference internal.
- Payment gateway production penuh tanpa proses review credential.
- Sistem rekomendasi AI.
- Multi-universitas selain Universitas Lampung.
- Deployment production dengan CI/CD.
