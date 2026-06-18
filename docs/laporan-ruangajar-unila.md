# LAPORAN PENGEMBANGAN SISTEM RUANGAJAR UNILA

## Platform Tutor Sebaya Universitas Lampung

Disusun untuk mendokumentasikan proses perencanaan, perancangan, implementasi, dan pengujian aplikasi **RuangAjar Unila** pada proyek mata kuliah Agile Software Development.

---

# BAB I: PENDAHULUAN

## 1.1. Latar Belakang Masalah

Perkembangan teknologi informasi mendorong berbagai kegiatan akademik untuk beralih ke layanan digital yang lebih cepat, transparan, dan mudah diakses. Di lingkungan perguruan tinggi, kebutuhan terhadap bimbingan belajar tidak hanya muncul dari proses pembelajaran formal di kelas, tetapi juga dari kebutuhan mahasiswa untuk memperoleh pendampingan tambahan terhadap mata kuliah tertentu. Pada sisi lain, terdapat mahasiswa yang memiliki kemampuan akademik, pengalaman asistensi, atau keahlian tertentu yang berpotensi untuk menjadi tutor sebaya bagi mahasiswa lain.

Universitas Lampung sebagai institusi pendidikan tinggi memiliki lingkungan akademik yang beragam, terdiri dari berbagai fakultas, program studi, angkatan, serta bidang keilmuan. Keragaman tersebut membuka peluang terbentuknya ekosistem belajar kolaboratif antar mahasiswa. Namun, proses menemukan tutor sebaya yang sesuai masih sering dilakukan secara informal melalui rekomendasi teman, grup percakapan, atau relasi personal. Cara tersebut kurang terstruktur karena calon learner tidak selalu memperoleh informasi lengkap mengenai keahlian tutor, harga sesi, rating, ketersediaan, maupun riwayat pembelajaran.

Permasalahan lain yang muncul adalah belum adanya wadah terpusat yang mampu mempertemukan mahasiswa pencari bimbingan dengan mahasiswa tutor dalam satu sistem yang mudah digunakan. Tanpa sistem yang terorganisasi, proses pencarian tutor, pemesanan jadwal, pencatatan sesi, serta pemberian ulasan menjadi sulit dipantau secara konsisten. Akibatnya, baik learner maupun tutor tidak memiliki rekam jejak digital yang dapat membantu pengambilan keputusan dalam proses belajar.

Berdasarkan kondisi tersebut, dikembangkan aplikasi **RuangAjar Unila**, yaitu platform marketplace jasa edukasi berbasis web yang dirancang untuk menghubungkan mahasiswa Universitas Lampung yang membutuhkan bimbingan belajar dengan mahasiswa yang berperan sebagai tutor sebaya. Sistem ini menghadirkan fitur pencarian tutor, pengelolaan profil tutor, booking sesi, riwayat pembelajaran, review, serta dashboard admin untuk pengawasan data. Dengan adanya sistem ini, proses pencarian dan pemesanan tutor diharapkan menjadi lebih rapi, transparan, serta mudah diakses oleh seluruh pihak yang terlibat.

Pengembangan sistem RuangAjar Unila dilakukan menggunakan pendekatan **SDLC Agile Scrum** agar proses pengerjaan dapat dibagi ke dalam sprint yang terukur. Metode ini dipilih karena kebutuhan sistem dapat berkembang secara bertahap dan setiap fitur dapat diuji melalui increment yang jelas. Dengan demikian, tim pengembang dapat melakukan evaluasi berkala terhadap fitur yang sudah dibuat, memperbaiki kekurangan, serta menyesuaikan prioritas pekerjaan sesuai kebutuhan proyek.

## 1.2. Rumusan Masalah

Berdasarkan latar belakang yang telah dijelaskan, rumusan masalah dalam pengembangan sistem RuangAjar Unila adalah sebagai berikut:

1. Bagaimana merancang sistem berbasis web yang dapat mempertemukan mahasiswa pencari tutor dengan mahasiswa tutor sebaya di lingkungan Universitas Lampung?
2. Bagaimana membangun fitur pencarian tutor, detail tutor, booking sesi, riwayat sesi, dan review agar proses pembelajaran dapat dilakukan secara lebih terstruktur?
3. Bagaimana menyediakan fitur pengelolaan profil, mata pelajaran, iklan tutor, ketersediaan, serta status booking bagi tutor?
4. Bagaimana menyediakan dashboard admin untuk mengelola data tutor, mahasiswa, verifikasi tutor, dan pengawasan sistem?
5. Bagaimana menerapkan metode Agile Scrum dalam proses perencanaan, implementasi, dan evaluasi fitur pada proyek RuangAjar Unila?

## 1.3. Tujuan Pengembangan

Tujuan dari pengembangan sistem RuangAjar Unila adalah sebagai berikut:

1. Membangun platform tutor sebaya berbasis web untuk membantu mahasiswa Universitas Lampung menemukan tutor yang sesuai dengan kebutuhan belajar.
2. Menyediakan fitur pencarian tutor, detail tutor, booking sesi, pembayaran, riwayat, dan review dalam satu sistem terpadu.
3. Memberikan fasilitas bagi tutor untuk mengelola profil, mata pelajaran, iklan, ketersediaan, dan booking dari learner.
4. Menyediakan fitur administrasi untuk mengelola data tutor, data mahasiswa, serta proses verifikasi tutor.
5. Mendokumentasikan proses pengembangan sistem menggunakan pendekatan Agile Scrum mulai dari perencanaan, sprint, implementasi, hingga pengujian.

## 1.4. Manfaat Pengembangan

Pengembangan sistem RuangAjar Unila diharapkan memberikan manfaat sebagai berikut:

1. **Bagi learner**, sistem memudahkan pencarian tutor berdasarkan informasi yang lebih jelas, seperti bidang keahlian, harga, rating, dan detail profil.
2. **Bagi tutor**, sistem menjadi wadah untuk menawarkan jasa bimbingan belajar, mengelola layanan, serta memperoleh riwayat booking secara lebih terstruktur.
3. **Bagi admin**, sistem membantu proses pengawasan data pengguna, validasi tutor, serta pengelolaan data mahasiswa dan tutor.
4. **Bagi tim pengembang**, sistem menjadi media penerapan prinsip Agile Scrum dalam pengembangan perangkat lunak berbasis web.
5. **Bagi lingkungan akademik**, sistem mendukung budaya pembelajaran kolaboratif antar mahasiswa melalui platform yang lebih transparan dan mudah digunakan.

## 1.5. Ruang Lingkup dan Batasan Proyek

Ruang lingkup pengembangan sistem RuangAjar Unila meliputi:

1. Sistem dibangun sebagai aplikasi web menggunakan PHP native/procedural, HTML5, CSS, JavaScript native, dan MySQL.
2. Role pengguna terdiri dari Public Visitor, Learner, Tutor, dan Admin.
3. Public Visitor dapat melihat landing page, mencari tutor, melihat detail tutor, melihat testimoni, serta menuju halaman login atau register.
4. Learner dapat login, mencari tutor, melakukan booking, melihat riwayat/sesi, mengelola profil, dan memberi review.
5. Tutor dapat login, mengelola profil, mata pelajaran, iklan tutor, ketersediaan, booking, notifikasi, dan pengaturan akun.
6. Admin dapat login, mengakses dashboard, mengelola data tutor, data mahasiswa, user, dan verifikasi tutor.
7. Integrasi pembayaran menggunakan Midtrans masih berada pada lingkup sandbox dan perlu penyesuaian credential untuk pengujian penuh.

Batasan proyek ini adalah sebagai berikut:

1. Sistem belum mencakup aplikasi mobile native.
2. Sistem belum menyediakan fitur chat real-time antara learner dan tutor.
3. Sistem belum menyediakan video conference internal.
4. Sistem belum membahas deployment production secara mendalam.
5. Sistem belum menggunakan framework backend modern seperti Laravel, karena proyek saat ini dikembangkan menggunakan PHP native/procedural.
6. Pengujian dilakukan melalui manual QA dan smoke test karena belum tersedia test runner otomatis.

# BAB II: LANDASAN TEORI

## 2.1. Metodologi SDLC Agile Scrum

Software Development Life Cycle (SDLC) merupakan tahapan terstruktur dalam pengembangan perangkat lunak yang mencakup proses analisis kebutuhan, perancangan, implementasi, pengujian, dan pemeliharaan. Dalam proyek pengembangan modern, salah satu pendekatan SDLC yang banyak digunakan adalah Agile. Agile menekankan proses pengembangan yang adaptif, iteratif, dan berorientasi pada kolaborasi tim.

Scrum merupakan salah satu kerangka kerja Agile yang membagi proses pengembangan ke dalam periode kerja singkat yang disebut sprint. Setiap sprint memiliki tujuan yang jelas dan menghasilkan increment atau peningkatan produk yang dapat diuji. Dalam Scrum terdapat beberapa elemen penting, seperti Product Backlog, Sprint Backlog, Sprint Planning, Daily Scrum, Sprint Review, dan Sprint Retrospective.

Pada pengembangan RuangAjar Unila, pendekatan Agile Scrum digunakan untuk membagi pekerjaan menjadi beberapa sprint. Sprint pertama difokuskan pada pembangunan fondasi sistem, autentikasi, halaman public, dan peran dasar pengguna. Sprint kedua difokuskan pada penyempurnaan fitur inti seperti booking, pengelolaan tutor, riwayat, review, serta pengujian integrasi antar role. Pembagian ini membantu tim dalam mengatur prioritas, memperjelas tanggung jawab, dan mengevaluasi hasil pengembangan secara bertahap.

## 2.2. Unified Modeling Language (UML)

Unified Modeling Language (UML) adalah bahasa pemodelan visual yang digunakan untuk menggambarkan rancangan, struktur, dan perilaku sistem perangkat lunak. UML membantu pengembang dan stakeholder memahami bagaimana sistem bekerja sebelum atau selama proses implementasi. Dengan UML, alur sistem dapat dijelaskan secara lebih jelas melalui diagram yang mudah dipahami.

Pada proyek RuangAjar Unila, UML digunakan untuk menggambarkan interaksi pengguna dengan sistem serta alur aktivitas dari setiap fitur utama. Diagram yang digunakan dalam laporan ini adalah Use Case Diagram dan Activity Diagram.

## 2.2.1. Use Case Diagram

Use Case Diagram digunakan untuk menggambarkan hubungan antara aktor dengan fungsi-fungsi yang tersedia di dalam sistem. Aktor dalam sistem RuangAjar Unila terdiri dari Public Visitor, Learner, Tutor, dan Admin. Setiap aktor memiliki kebutuhan dan hak akses yang berbeda. Public Visitor dapat melihat informasi dan mencari tutor, Learner dapat melakukan booking dan review, Tutor dapat mengelola layanan pembelajaran, sedangkan Admin mengelola data serta verifikasi tutor.

Use Case Diagram proyek ini dapat dilihat pada dokumen [usecase.md](usecase.md). Diagram tersebut memperlihatkan fitur utama sistem, antara lain register, login, pencarian tutor, detail tutor, booking, pembayaran, riwayat, review, pengelolaan mata pelajaran, pengelolaan iklan tutor, verifikasi tutor, dan pengelolaan data oleh admin.

## 2.2.2. Activity Diagram

Activity Diagram digunakan untuk menggambarkan urutan aktivitas dari suatu proses bisnis atau fitur sistem. Diagram ini memperlihatkan alur kerja mulai dari aktivitas awal, proses yang dilakukan user, respon sistem, percabangan keputusan, hingga aktivitas akhir. Pada sistem RuangAjar Unila, Activity Diagram dibuat berdasarkan stakeholder dan fitur.

Dokumen Activity Diagram tersedia dalam beberapa file berikut:

1. [activitydiagram-public.md](activitydiagram-public.md) untuk alur fitur Public Visitor.
2. [activitydiagram-learner.md](activitydiagram-learner.md) untuk alur fitur Learner.
3. [activitydiagram-tutor.md](activitydiagram-tutor.md) untuk alur fitur Tutor.
4. [activitydiagram-admin.md](activitydiagram-admin.md) untuk alur fitur Admin.

Pembagian activity diagram berdasarkan stakeholder membantu proses analisis karena setiap role memiliki alur interaksi yang berbeda. Dengan demikian, fitur dapat diuji dan dievaluasi berdasarkan kebutuhan masing-masing pengguna.

## 2.3. Tech Stack dan Teknologi Pendukung

Sistem RuangAjar Unila dikembangkan menggunakan teknologi yang sederhana namun cukup memadai untuk kebutuhan prototype web. Teknologi yang digunakan adalah sebagai berikut:

| Komponen | Teknologi | Keterangan |
| --- | --- | --- |
| Frontend | HTML5, CSS, JavaScript native | Digunakan untuk membangun antarmuka halaman public, admin, tutor, dan learner. |
| Backend | PHP native/procedural | Digunakan untuk memproses autentikasi, CRUD, booking, review, dan transaksi. |
| Database | MySQL | Digunakan sebagai penyimpanan data user, tutor, mahasiswa, subject, booking, dan review. |
| Payment Gateway | Midtrans Sandbox | Digunakan untuk kebutuhan transaksi pembayaran dalam mode pengujian. |
| Web Server Lokal | Laragon/XAMPP | Digunakan untuk menjalankan PHP dan MySQL secara lokal. |
| Pemodelan | PlantUML | Digunakan untuk membuat Use Case Diagram dan Activity Diagram. |

Pemilihan PHP native/procedural disesuaikan dengan kondisi proyek yang berfokus pada prototype dan kemudahan eksekusi di lingkungan lokal. Sementara itu, MySQL dipilih karena sesuai dengan kebutuhan data relasional yang digunakan oleh sistem, seperti relasi antara tutor, learner, subject, booking, dan review.

# BAB III: PERENCANAAN SISTEM (PRE-SPRINT)

## 3.1. Pembagian Peran Tim Scrum (Scrum Roles)

Pengembangan sistem RuangAjar Unila dilakukan oleh tim yang terdiri dari tiga anggota. Dalam kerangka Scrum, pembagian peran dilakukan agar koordinasi, prioritas pekerjaan, dan evaluasi sprint menjadi lebih jelas. Namun, pada praktik implementasinya, seluruh anggota tim tetap berkontribusi sebagai pengembang full-stack. Pembagian teknis tidak dilakukan secara kaku berdasarkan lapisan frontend atau backend, melainkan berdasarkan area role pengguna agar setiap anggota dapat mengerjakan alur fitur secara utuh mulai dari tampilan, proses backend, koneksi database, sampai pengujian fitur.

| Nama | NPM | Peran Scrum | Tanggung Jawab Scrum dan Kontribusi Full-Stack |
| --- | --- | --- | --- |
| Dhito Aryo Trengginas | 2315061015 | Product Owner & Full-Stack Developer | Menentukan kebutuhan fitur, menyusun prioritas backlog, dan memastikan fitur sesuai tujuan produk. Pada implementasi teknis, berfokus mengembangkan alur **Public Visitor** dan **Learner**, meliputi halaman public, pencarian tutor, detail tutor, dashboard learner, booking, riwayat/sesi, dan review dari sisi frontend, backend, database, serta pengujian. |
| Muhammad Rayham Gumay | 2355061007 | Scrum Master & Full-Stack Developer | Membantu pengaturan sprint, menjaga ritme kerja tim, dan memastikan hambatan pengembangan dapat ditangani. Pada implementasi teknis, berfokus mengembangkan alur **Admin**, meliputi dashboard admin, pengelolaan data tutor, pengelolaan data mahasiswa, penghapusan user, verifikasi tutor, validasi input, integrasi database, serta pengujian fitur admin. |
| Firman Farel Richardo | 2315061099 | Development Team & Full-Stack Developer | Mengembangkan fitur, menyusun dokumentasi teknis, membuat UML, dan melakukan pengujian fitur. Pada implementasi teknis, berfokus mengembangkan alur **Tutor**, meliputi dashboard tutor, profil tutor, mata pelajaran, iklan tutor, ketersediaan, status booking, pengaturan akun, serta menyusun dokumentasi teknis seperti use case, activity diagram, setup guide, dan laporan pengembangan. |

Pembagian peran ini membantu tim dalam menjaga keteraturan proses pengembangan tanpa membatasi kontribusi teknis setiap anggota. Product Owner berfokus pada arah dan nilai produk, Scrum Master menjaga kelancaran proses kerja, sedangkan Development Team memastikan implementasi teknis dan dokumentasi berjalan sesuai kebutuhan. Dengan pembagian berdasarkan role pengguna, setiap anggota dapat memahami alur fitur secara menyeluruh sehingga proses pengembangan menjadi lebih kolaboratif, terarah, dan mudah dievaluasi pada akhir sprint.

## 3.2. Visi Produk (Product Vision)

Visi produk RuangAjar Unila adalah menjadi platform tutor sebaya berbasis web yang memudahkan mahasiswa Universitas Lampung dalam menemukan tutor yang sesuai, melakukan booking sesi belajar, serta memberikan ruang bagi tutor mahasiswa untuk menawarkan layanan bimbingan secara lebih terstruktur.

Secara lebih rinci, visi produk ini mencakup beberapa arah pengembangan berikut:

1. Menjadi wadah digital yang mempertemukan learner dan tutor sebaya di lingkungan Universitas Lampung.
2. Menyediakan informasi tutor yang jelas, mencakup profil, keahlian, harga, mata pelajaran, rating, dan review.
3. Menyediakan alur booking yang mudah dipahami oleh learner.
4. Memberikan ruang bagi tutor untuk mengelola layanan pembelajaran secara mandiri.
5. Menyediakan pengawasan data melalui dashboard admin.

## 3.3. Analisis Kebutuhan Sistem

Analisis kebutuhan sistem dilakukan untuk memastikan bahwa fitur yang dikembangkan sesuai dengan permasalahan dan tujuan produk. Kebutuhan sistem dibagi menjadi dua bagian, yaitu kebutuhan fungsional dan kebutuhan nonfungsional. Kebutuhan fungsional menjelaskan layanan atau proses yang harus dapat dilakukan oleh sistem, sedangkan kebutuhan nonfungsional menjelaskan kualitas sistem dari sisi keamanan, kemudahan penggunaan, performa, dan pemeliharaan.

## 3.3.1. Kebutuhan Fungsional

Kebutuhan fungsional RuangAjar Unila disusun berdasarkan aktor yang terlibat dalam sistem, yaitu Public Visitor, Learner, Tutor, dan Admin. Setiap aktor memiliki hak akses dan kebutuhan fitur yang berbeda sesuai perannya.

| Kode | Aktor | Kebutuhan Fungsional |
| --- | --- | --- |
| KF-01 | Public Visitor | Sistem dapat menampilkan landing page yang berisi informasi umum mengenai platform RuangAjar Unila. |
| KF-02 | Public Visitor | Sistem dapat menampilkan kategori, testimoni, dan informasi tutor yang tersedia untuk dilihat sebelum login. |
| KF-03 | Public Visitor | Sistem dapat menyediakan fitur pencarian tutor berdasarkan keyword atau filter yang tersedia. |
| KF-04 | Public Visitor | Sistem dapat menampilkan detail tutor, termasuk profil, mata pelajaran, harga, rating, dan review. |
| KF-05 | Public Visitor | Sistem dapat mengarahkan pengguna ke halaman login atau register ketika ingin menggunakan fitur privat. |
| KF-06 | Semua Role | Sistem dapat menyediakan fitur register, login, dan logout berbasis role. |
| KF-07 | Semua Role | Sistem dapat mengarahkan user ke dashboard yang sesuai setelah login berhasil. |
| KF-08 | Learner | Sistem dapat menampilkan dashboard learner setelah proses login berhasil. |
| KF-09 | Learner | Sistem dapat memungkinkan learner mencari tutor dan melihat detail tutor. |
| KF-10 | Learner | Sistem dapat memungkinkan learner membuat booking dengan memilih tutor, subject, tanggal, jam, durasi, dan catatan. |
| KF-11 | Learner | Sistem dapat menyimpan data booking dengan status awal sesuai aturan sistem. |
| KF-12 | Learner | Sistem dapat menampilkan sesi aktif dan riwayat booking learner. |
| KF-13 | Learner | Sistem dapat memungkinkan learner memberikan review dan rating pada tutor setelah sesi selesai. |
| KF-14 | Learner | Sistem dapat memproses transaksi pembayaran melalui Midtrans sandbox jika credential pembayaran tersedia. |
| KF-15 | Tutor | Sistem dapat menampilkan dashboard tutor setelah proses login berhasil. |
| KF-16 | Tutor | Sistem dapat memungkinkan tutor mengelola profil tutor, termasuk data akademik, keahlian, deskripsi, dan harga sesi. |
| KF-17 | Tutor | Sistem dapat memungkinkan tutor mengelola mata pelajaran atau subject yang diajarkan. |
| KF-18 | Tutor | Sistem dapat memungkinkan tutor membuat dan mengelola iklan tutor. |
| KF-19 | Tutor | Sistem dapat memungkinkan tutor mengatur status ketersediaan. |
| KF-20 | Tutor | Sistem dapat menampilkan daftar booking atau jadwal yang berkaitan dengan tutor. |
| KF-21 | Tutor | Sistem dapat memungkinkan tutor memperbarui status booking sesuai progres sesi. |
| KF-22 | Admin | Sistem dapat menampilkan dashboard admin setelah proses login berhasil. |
| KF-23 | Admin | Sistem dapat menampilkan ringkasan data pengguna, tutor, mahasiswa, dan aktivitas sistem. |
| KF-24 | Admin | Sistem dapat memungkinkan admin mengelola data tutor. |
| KF-25 | Admin | Sistem dapat memungkinkan admin mengelola data mahasiswa. |
| KF-26 | Admin | Sistem dapat memungkinkan admin menghapus user jika diperlukan. |
| KF-27 | Admin | Sistem dapat memungkinkan admin melakukan verifikasi tutor. |
| KF-28 | Sistem | Sistem dapat menyimpan data pada database MySQL sesuai schema `ruangajar`. |
| KF-29 | Sistem | Sistem dapat menerima notifikasi pembayaran dan memperbarui status pembayaran booking jika integrasi Midtrans aktif. |

## 3.3.2. Kebutuhan Nonfungsional

Kebutuhan nonfungsional menjelaskan standar kualitas yang perlu dipenuhi ketika sistem sudah dijalankan pada lingkungan server atau hosting. Pada proyek ini, kebutuhan nonfungsional disusun secara ringkas dan disesuaikan dengan karakter RuangAjar Unila sebagai aplikasi web berbasis PHP native/procedural, MySQL, dan integrasi payment gateway Midtrans.

| ID | Kebutuhan Non-Fungsional | Deskripsi Kebutuhan |
| --- | --- | --- |
| KNF-01 | Usability (Kemudahan Pengguna) | Sistem harus memiliki antarmuka web yang sederhana, konsisten, dan mudah dipahami oleh Public Visitor, Learner, Tutor, dan Admin tanpa memerlukan pelatihan khusus. |
| KNF-02 | Accessibility (Aksesibilitas) | Sistem harus dapat diakses melalui peramban web standar dari perangkat yang terhubung ke jaringan internet atau jaringan lokal server tempat aplikasi dideploy. |
| KNF-03 | Performance (Kinerja) | Sistem harus mampu merespons akses halaman, pencarian tutor, proses login, dan penyimpanan booking secara wajar tanpa penundaan yang mengganggu penggunaan. |
| KNF-04 | Reliability (Keandalan) | Sistem harus menjaga konsistensi data user, tutor, mahasiswa, subject, booking, pembayaran, dan review sesuai relasi database MySQL yang digunakan. |
| KNF-05 | Security (Keamanan) | Akses fitur privat harus dilindungi dengan autentikasi, pengecekan session, validasi role, validasi input backend, serta penyimpanan password dalam bentuk hash. |
| KNF-06 | Compatibility & Maintainability (Kompatibilitas dan Pemeliharaan) | Sistem harus dapat dijalankan pada server PHP dan MySQL yang kompatibel serta memiliki struktur folder, konfigurasi, dan dokumentasi yang mudah dipahami untuk proses deployment maupun pengembangan lanjutan. |

## 3.4. Product Backlog Item (PBI) & User Story

Product Backlog Item disusun berdasarkan kebutuhan utama sistem. Setiap PBI diterjemahkan ke dalam user story agar kebutuhan pengguna lebih mudah dipahami.

| Kode | Product Backlog Item | User Story | Prioritas |
| --- | --- | --- | --- |
| PBI-01 | Landing page dan halaman public | Sebagai public visitor, saya ingin melihat informasi platform agar memahami layanan RuangAjar Unila. | Tinggi |
| PBI-02 | Autentikasi role | Sebagai user, saya ingin login sesuai role agar dapat mengakses dashboard yang tepat. | Tinggi |
| PBI-03 | Register learner dan tutor | Sebagai calon user, saya ingin membuat akun agar dapat menggunakan fitur privat. | Tinggi |
| PBI-04 | Pencarian dan detail tutor | Sebagai learner, saya ingin mencari dan melihat detail tutor agar dapat memilih tutor yang sesuai. | Tinggi |
| PBI-05 | Dashboard admin | Sebagai admin, saya ingin melihat ringkasan data agar dapat memantau kondisi sistem. | Sedang |
| PBI-06 | Manajemen data tutor dan mahasiswa | Sebagai admin, saya ingin mengelola data tutor dan mahasiswa agar data sistem tetap valid. | Sedang |
| PBI-07 | Pengelolaan profil dan mata pelajaran tutor | Sebagai tutor, saya ingin mengelola profil dan mata pelajaran agar layanan saya dapat ditampilkan dengan benar. | Tinggi |
| PBI-08 | Pengelolaan iklan tutor | Sebagai tutor, saya ingin membuat iklan tutor agar learner dapat mengetahui layanan yang saya tawarkan. | Sedang |
| PBI-09 | Booking sesi tutor | Sebagai learner, saya ingin melakukan booking tutor agar dapat mengikuti sesi belajar. | Tinggi |
| PBI-10 | Pembayaran Midtrans sandbox | Sebagai learner, saya ingin melakukan pembayaran agar proses booking dapat tercatat. | Sedang |
| PBI-11 | Riwayat, sesi, dan status booking | Sebagai learner dan tutor, saya ingin melihat status booking agar dapat memantau proses sesi. | Tinggi |
| PBI-12 | Review dan rating tutor | Sebagai learner, saya ingin memberi review setelah sesi agar tutor memiliki penilaian dari pengguna. | Sedang |
| PBI-13 | Verifikasi tutor | Sebagai admin, saya ingin memverifikasi tutor agar kualitas data tutor tetap terjaga. | Sedang |

# BAB IV: IMPLEMENTASI SPRINT DAN PERANCANGAN UML

## 4.1. Pelaksanaan Sprint 1

Sprint 1 difokuskan pada pembangunan fondasi awal sistem. Fokus utama sprint ini adalah menyediakan struktur aplikasi, koneksi database, halaman public, autentikasi, dan role dasar pengguna. Sprint ini menjadi dasar bagi pengembangan fitur booking, tutor, learner, dan admin pada sprint berikutnya.

## 4.1.1. Sprint Planning 1 (Komitmen Sprint Backlog)

Pada Sprint Planning 1, tim menetapkan sprint backlog yang berisi fitur-fitur dasar agar sistem dapat dijalankan dan digunakan untuk skenario awal. Komitmen Sprint 1 adalah menghasilkan sistem yang sudah dapat diakses melalui browser lokal, memiliki koneksi database, dan menyediakan autentikasi berbasis role.

| Kode | Sprint Backlog | Output yang Diharapkan |
| --- | --- | --- |
| SB1-01 | Setup struktur folder dan entry point aplikasi | Project dapat diakses melalui `index.php` dan diarahkan ke landing page. |
| SB1-02 | Setup database MySQL | Database `ruangajar` dan tabel awal tersedia. |
| SB1-03 | Implementasi landing page dan halaman public | Public visitor dapat melihat informasi platform dan daftar tutor. |
| SB1-04 | Implementasi login, register, dan logout | User dapat masuk dan keluar dari sistem sesuai role. |
| SB1-05 | Implementasi dashboard awal admin, tutor, dan learner | Setiap role memiliki halaman awal setelah login. |

## 4.1.2. Perancangan UML Sprint 1

Perancangan UML pada Sprint 1 difokuskan pada fitur dasar yang menjadi fondasi sistem. Use case yang digunakan meliputi melihat informasi platform, register, login, pencarian tutor, detail tutor, dan akses dashboard awal berdasarkan role.

## 4.1.2.1. Use Case Diagram Fitur Sprint 1

Use Case Diagram Sprint 1 mengacu pada aktor Public Visitor, Learner, Tutor, dan Admin. Pada tahap ini, fitur utama yang diprioritaskan adalah akses umum dan autentikasi. Public Visitor dapat melihat informasi platform, mencari tutor, melihat detail tutor, melakukan register, dan login. Setelah login, user diarahkan ke dashboard sesuai role.

Use Case Diagram lengkap tersedia pada dokumen [usecase.md](usecase.md). Diagram tersebut menunjukkan relasi utama antara aktor dan fitur, termasuk relasi `include` antara Login dan Validasi Akun.

## 4.1.2.2. Activity Diagram Fitur Sprint 1

Activity Diagram Sprint 1 difokuskan pada alur public visitor dan autentikasi. Alur public visitor menjelaskan proses pengguna membuka halaman utama, melihat informasi platform, mencari tutor, dan membuka detail tutor. Alur login menjelaskan proses user mengisi email dan password, sistem melakukan validasi, lalu mengarahkan user ke dashboard sesuai role.

Activity Diagram terkait tersedia pada dokumen berikut:

1. [activitydiagram-public.md](activitydiagram-public.md)
2. [activitydiagram-admin.md](activitydiagram-admin.md)
3. [activitydiagram-tutor.md](activitydiagram-tutor.md)
4. [activitydiagram-learner.md](activitydiagram-learner.md)

## 4.1.3. Implementasi Kode (Anatomi & Pemrograman) Sprint 1

Implementasi Sprint 1 dilakukan dengan struktur PHP native/procedural. File root `index.php` digunakan untuk mengarahkan user ke halaman landing page public. Koneksi database diletakkan pada `src/config/database.php`, sedangkan konfigurasi Midtrans disiapkan pada `src/config/midtrans_config.php`.

Struktur utama project adalah sebagai berikut:

| Folder/File | Fungsi |
| --- | --- |
| `index.php` | Redirect awal menuju landing page public. |
| `database/ruangajar.sql` | Schema dan data awal database MySQL. |
| `src/config/database.php` | Konfigurasi koneksi MySQL. |
| `src/backend/auth` | Proses login, register, dan logout. |
| `src/frontend/pages/public` | Halaman landing page, kategori, detail tutor, pencarian, dan testimoni. |
| `src/frontend/pages/auth` | Halaman login dan register. |
| `src/frontend/layouts` | Header, footer, sidebar, dan layout role. |

Pada Sprint 1, fitur autentikasi menjadi komponen penting. Tabel `users` digunakan untuk menyimpan data akun, role, email, dan password. Role yang digunakan adalah `admin`, `tutor`, dan `learner`. Setelah proses login berhasil, sistem mengarahkan pengguna ke halaman sesuai role.

## 4.1.4. Pengujian Fitur Sprint 1 (Acceptance Criteria Testing)

Pengujian Sprint 1 dilakukan secara manual melalui browser lokal. Pengujian difokuskan pada akses halaman, koneksi database, dan autentikasi role.

| No | Fitur | Acceptance Criteria | Hasil yang Diharapkan | Status |
| --- | --- | --- | --- | --- |
| 1 | Landing page | User dapat membuka halaman utama | Landing page tampil dengan asset CSS dan gambar | Lulus |
| 2 | Koneksi database | Sistem dapat membaca data dari MySQL | Data tutor dan user dapat ditampilkan | Lulus |
| 3 | Login admin | Admin dapat login dengan akun demo | Dashboard admin tampil | Lulus |
| 4 | Login tutor | Tutor dapat login dengan akun demo | Dashboard tutor tampil | Lulus |
| 5 | Login learner | Learner dapat login dengan akun demo | Dashboard learner tampil | Lulus |
| 6 | Pencarian public | Public visitor dapat mencari tutor | Hasil pencarian tampil sesuai data | Lulus |

Berdasarkan hasil pengujian Sprint 1, fitur dasar sistem telah dapat berjalan pada lingkungan lokal. Halaman public dapat diakses, user dapat melakukan login sesuai role, dan koneksi database dapat digunakan untuk mengambil data awal.

## 4.1.5. Evaluasi (Sprint Review & Retrospective 1)

Pada Sprint Review 1, tim mengevaluasi hasil implementasi awal. Sistem sudah memiliki fondasi yang cukup untuk dilanjutkan ke fitur inti seperti booking, pengelolaan tutor, dan review. Namun, terdapat beberapa catatan yang perlu diperhatikan, yaitu validasi input backend harus diperkuat, session guard perlu diterapkan secara konsisten, dan dokumentasi setup perlu dibuat agar proses onboarding developer lebih mudah.

Pada Retrospective 1, tim menyimpulkan bahwa penggunaan struktur folder berdasarkan domain role membantu pengembangan menjadi lebih mudah dipahami. Namun, karena sistem menggunakan PHP native/procedural, tim perlu menjaga konsistensi kode agar tidak terjadi duplikasi logika berlebihan.

## 4.2. Pelaksanaan Sprint 2

Sprint 2 difokuskan pada pengembangan fitur inti sistem, yaitu fitur tutor, learner, booking, pembayaran sandbox, review, serta pengelolaan data oleh admin. Sprint ini bertujuan menghasilkan product increment yang lebih lengkap dan dapat digunakan untuk mensimulasikan alur utama RuangAjar Unila.

## 4.2.1. Sprint Planning 2

Pada Sprint Planning 2, tim menetapkan backlog yang berfokus pada interaksi antar role. Learner harus dapat mencari tutor dan membuat booking, tutor harus dapat mengelola layanan serta status booking, sedangkan admin harus dapat mengelola data dan melakukan verifikasi tutor.

| Kode | Sprint Backlog | Output yang Diharapkan |
| --- | --- | --- |
| SB2-01 | Pengelolaan profil tutor | Tutor dapat memperbarui data profil. |
| SB2-02 | Pengelolaan mata pelajaran | Tutor dapat menambah dan menghapus subject. |
| SB2-03 | Pengelolaan iklan tutor | Tutor dapat membuat iklan layanan tutor. |
| SB2-04 | Booking tutor oleh learner | Learner dapat membuat booking berdasarkan tutor dan subject. |
| SB2-05 | Riwayat dan sesi | Learner dan tutor dapat memantau status booking. |
| SB2-06 | Review dan rating | Learner dapat memberi review setelah sesi selesai. |
| SB2-07 | Verifikasi dan manajemen admin | Admin dapat mengelola tutor dan mahasiswa. |
| SB2-08 | Integrasi Midtrans sandbox | Sistem menyiapkan flow transaksi dan notifikasi pembayaran. |

## 4.2.2. Perancangan UML Sprint 2

Perancangan UML Sprint 2 difokuskan pada fitur inti yang melibatkan interaksi antar role. Alur utama yang dirancang adalah booking tutor, pengelolaan layanan tutor, pengelolaan status booking, review, verifikasi tutor, dan pembayaran melalui Midtrans sandbox.

## 4.2.2.1. Use Case Diagram Fitur Sprint 2

Berdasarkan Gambar Use Case Diagram RuangAjar Unila, sistem menggambarkan interaksi antara empat aktor utama, yaitu **Public Visitor**, **Learner**, **Tutor**, dan **Admin**. Diagram ini menunjukkan pembagian fitur berdasarkan peran pengguna, sehingga setiap aktor hanya terhubung dengan fungsionalitas yang sesuai dengan kebutuhannya. Public Visitor dapat melakukan register, melihat informasi platform, mencari tutor, melihat detail tutor, dan login sebagai pintu masuk menuju fitur yang lebih lengkap.

Learner berperan sebagai mahasiswa yang mencari layanan bimbingan belajar. Pada diagram, Learner dapat login, mencari tutor, melihat detail tutor, mengelola profil, membuat booking, melakukan pembayaran, melihat riwayat atau sesi, serta memberi review. Relasi `<<extend>>` antara **Melihat Detail Tutor** dan **Mencari Tutor** menunjukkan bahwa detail tutor dibuka sebagai lanjutan dari proses pencarian. Relasi `<<include>>` pada **Melakukan Pembayaran** dan **Menerima Notifikasi Pembayaran** menunjukkan bahwa proses pembayaran berkaitan dengan penerimaan status pembayaran dari sistem.

Tutor berperan sebagai penyedia layanan bimbingan belajar. Tutor dapat login, mengelola profil, mengelola mata pelajaran, mengelola iklan tutor, mengatur ketersediaan, dan mengelola status booking. Sementara itu, Admin berperan dalam pengawasan data sistem melalui fitur login, melihat dashboard, mengelola data tutor, mengelola data mahasiswa, dan memverifikasi tutor. Relasi `<<extend>>` antara **Memberi Review** dan **Melihat Riwayat atau Sesi** menunjukkan bahwa review diberikan setelah learner memiliki riwayat atau sesi yang relevan. Secara keseluruhan, use case diagram ini memperlihatkan bahwa RuangAjar Unila membagi fungsi sistem secara jelas berdasarkan peran pengguna.

## 4.2.2.2. Activity Diagram Fitur Sprint 2

Berdasarkan Activity Diagram yang telah disusun, alur kerja sistem RuangAjar Unila digambarkan dalam bentuk swimlane antara aktor dan sistem. Pembagian ini bertujuan untuk memperlihatkan batas tanggung jawab antara tindakan yang dilakukan pengguna dengan proses yang dijalankan oleh sistem. Activity Diagram dibuat terpisah berdasarkan role agar setiap alur fitur dapat dipahami secara lebih sederhana dan tidak bercampur dengan proses milik aktor lain.

Berdasarkan Activity Diagram Public Visitor, alur aktivitas dimulai ketika pengguna membuka halaman utama RuangAjar Unila. Sistem kemudian menampilkan landing page, kategori tutor, dan informasi layanan yang tersedia. Public Visitor dapat melanjutkan aktivitas dengan mencari tutor melalui keyword atau filter tertentu. Setelah sistem menampilkan hasil pencarian, pengguna dapat membuka detail tutor untuk melihat informasi lebih lengkap, seperti profil, mata pelajaran, harga, rating, dan review. Apabila pengguna ingin melakukan booking, sistem akan mengarahkan pengguna menuju proses login atau register karena booking merupakan fitur privat yang hanya dapat dilakukan oleh learner.

Berdasarkan Activity Diagram Learner, alur aktivitas dimulai dari proses login learner. Setelah akun berhasil divalidasi, sistem menampilkan dashboard learner. Learner kemudian dapat mencari tutor, membuka detail tutor, dan membuat booking dengan memilih subject, tanggal, jam, durasi, serta catatan. Sistem melakukan validasi data booking sebelum menyimpan data ke database. Apabila pembayaran digunakan, sistem membuat transaksi melalui payment gateway dan memperbarui status pembayaran berdasarkan notifikasi yang diterima. Setelah sesi selesai, learner dapat membuka riwayat booking dan memberikan review terhadap tutor. Alur ini menunjukkan bahwa learner memiliki proses utama mulai dari pencarian tutor hingga evaluasi layanan melalui review.

Berdasarkan Activity Diagram Tutor, alur aktivitas dimulai ketika tutor melakukan login dan sistem menampilkan dashboard tutor. Tutor kemudian dapat mengelola profil, menambah atau menghapus mata pelajaran, membuat iklan tutor, mengatur status ketersediaan, serta melihat booking yang masuk. Pada proses pengelolaan booking, tutor memilih status booking yang sesuai dengan progres sesi. Sistem kemudian memvalidasi bahwa booking tersebut memang berkaitan dengan tutor yang sedang login sebelum memperbarui status booking. Activity Diagram ini memperlihatkan bahwa tutor memiliki kendali terhadap informasi layanan dan proses sesi yang diberikan kepada learner.

Berdasarkan Activity Diagram Admin, alur aktivitas dimulai dari proses login admin. Setelah akun berhasil divalidasi, sistem menampilkan dashboard admin. Admin dapat mengelola data tutor, mengelola data mahasiswa, serta melakukan verifikasi tutor. Pada proses verifikasi, admin meninjau data tutor terlebih dahulu sebelum memutuskan apakah data tersebut valid untuk diaktifkan. Jika data valid, sistem memperbarui status tutor menjadi aktif. Jika data belum sesuai, sistem menyimpan status yang menunjukkan bahwa data tutor belum dapat diverifikasi. Dengan demikian, activity diagram admin menggambarkan peran admin sebagai pengawas data dan penjaga validitas pengguna di dalam sistem.

Secara keseluruhan, Activity Diagram RuangAjar Unila menunjukkan bahwa sistem bekerja dengan alur yang terpisah namun saling terhubung antar role. Public Visitor berperan pada tahap pengenalan dan pencarian awal, Learner berperan pada proses booking dan review, Tutor berperan pada pengelolaan layanan serta status booking, sedangkan Admin berperan pada pengawasan dan validasi data. Pemisahan alur tersebut membantu sistem menjadi lebih terstruktur karena setiap role memiliki tanggung jawab dan batas akses yang jelas.

## 4.2.3. Implementasi Kode Sprint 2

Implementasi Sprint 2 dilakukan pada beberapa domain utama, yaitu learner, tutor, admin, dan payment. Pada sisi learner, proses booking ditangani melalui file backend pada `src/backend/learner`, seperti `booking_process.php`, `create_transaction.php`, `get_sessions.php`, `payment_notification.php`, dan `submit_review.php`.

Pada sisi tutor, pengelolaan layanan dilakukan melalui file backend pada `src/backend/tutor`, antara lain `update_profile.php`, `add_subject.php`, `delete_subject.php`, `create_iklan.php`, `update_availability.php`, dan `update_booking_status.php`. File tersebut bertanggung jawab untuk memproses input tutor dan menyimpan perubahan pada tabel `tutor`, `subjects`, `tutor_mapel`, `iklan_tutor`, dan `bookings`.

Pada sisi admin, proses pengelolaan data dilakukan melalui file backend pada `src/backend/admin`, seperti `crud_mahasiswa.php`, `crud_tutor.php`, `delete_user.php`, dan `verify_tutor.php`. Fitur admin berfungsi menjaga kualitas data sistem agar tutor dan mahasiswa dapat dikelola secara lebih terstruktur.

Database yang digunakan terdiri dari beberapa tabel utama. Tabel `users` menyimpan akun dan role. Tabel `tutor` menyimpan profil tutor. Tabel `mahasiswa` menyimpan data learner. Tabel `subjects` dan `tutor_mapel` menyimpan mata pelajaran yang diajarkan tutor. Tabel `bookings` menyimpan data pemesanan sesi, sedangkan tabel `reviews` menyimpan rating dan ulasan learner terhadap tutor.

## 4.2.4. Pengujian Fitur Sprint 2

Pengujian Sprint 2 dilakukan menggunakan metode manual acceptance testing. Pengujian difokuskan pada alur utama user, yaitu learner melakukan pencarian dan booking, tutor mengelola layanan serta booking, dan admin mengelola data.

| No | Role | Fitur | Skenario Pengujian | Hasil yang Diharapkan | Status |
| --- | --- | --- | --- | --- | --- |
| 1 | Learner | Cari tutor | Learner mengisi filter pencarian | Sistem menampilkan tutor sesuai data | Lulus |
| 2 | Learner | Booking tutor | Learner memilih tutor, subject, tanggal, dan jam | Booking tersimpan dengan status `pending` | Lulus |
| 3 | Learner | Riwayat booking | Learner membuka riwayat | Sistem menampilkan daftar booking learner | Lulus |
| 4 | Learner | Review tutor | Learner mengisi rating dan review | Review tersimpan pada tabel `reviews` | Lulus |
| 5 | Tutor | Profil tutor | Tutor mengubah profil | Data profil tutor diperbarui | Lulus |
| 6 | Tutor | Mata pelajaran | Tutor menambah/menghapus subject | Data subject berubah sesuai input | Lulus |
| 7 | Tutor | Iklan tutor | Tutor membuat iklan | Iklan tersimpan pada `iklan_tutor` | Lulus |
| 8 | Tutor | Status booking | Tutor memperbarui status booking | Status booking berubah sesuai aksi | Lulus |
| 9 | Admin | Data tutor | Admin mengelola data tutor | Data tutor berubah sesuai operasi | Lulus |
| 10 | Admin | Data mahasiswa | Admin mengelola data mahasiswa | Data mahasiswa berubah sesuai operasi | Lulus |
| 11 | Admin | Verifikasi tutor | Admin memverifikasi tutor | Status tutor diperbarui | Lulus |
| 12 | Payment | Midtrans sandbox | Sistem membuat transaksi sandbox | Token/order ID tersimpan jika credential tersedia | Perlu konfigurasi credential |

Berdasarkan hasil pengujian, fitur utama Sprint 2 telah berjalan sesuai alur yang direncanakan. Catatan khusus terdapat pada payment gateway karena pengujian penuh memerlukan credential sandbox Midtrans yang valid.

## 4.2.5. Evaluasi (Sprint Review & Retrospective 2)

Pada Sprint Review 2, sistem telah memiliki fitur yang lebih lengkap dan dapat digunakan untuk mensimulasikan alur utama RuangAjar Unila. Learner dapat mencari tutor, membuat booking, melihat riwayat, dan memberi review. Tutor dapat mengelola profil, mata pelajaran, iklan, ketersediaan, serta booking. Admin dapat mengelola data tutor dan mahasiswa serta melakukan verifikasi tutor.

Pada Retrospective 2, tim mencatat bahwa dokumentasi sistem menjadi hal penting karena fitur sudah semakin banyak dan melibatkan beberapa role. Oleh karena itu, dibuat dokumentasi tambahan berupa setup guide, use case diagram, activity diagram, stakeholder flow, database schema, dan current progress. Dokumentasi ini membantu menjaga keberlanjutan proyek agar dapat dilanjutkan oleh developer lain dengan lebih mudah.

# BAB V: HASIL AKHIR DAN PENGUJIAN INTEGRASI

## 5.1. Demo Produk Akhir (Final Product Increment)

Final Product Increment dari sistem RuangAjar Unila adalah aplikasi web yang dapat dijalankan secara lokal menggunakan Laragon atau XAMPP. Aplikasi dapat diakses melalui URL:

```text
http://localhost/RuangAjar-Unila/
```

atau langsung melalui landing page:

```text
http://localhost/RuangAjar-Unila/src/frontend/pages/public/landing_page.php
```

Produk akhir memiliki fitur utama sebagai berikut:

1. **Public Visitor**
   - Melihat landing page.
   - Melihat kategori dan testimoni.
   - Mencari tutor.
   - Melihat detail tutor.
   - Menuju halaman login/register.

2. **Learner**
   - Login ke dashboard learner.
   - Mencari tutor.
   - Melakukan booking.
   - Melihat sesi dan riwayat booking.
   - Memberikan review dan rating.
   - Mengelola profil.

3. **Tutor**
   - Login ke dashboard tutor.
   - Mengelola profil.
   - Mengelola mata pelajaran.
   - Membuat iklan tutor.
   - Mengatur ketersediaan.
   - Mengelola status booking.

4. **Admin**
   - Login ke dashboard admin.
   - Melihat ringkasan sistem.
   - Mengelola data tutor.
   - Mengelola data mahasiswa.
   - Melakukan verifikasi tutor.

Secara umum, sistem telah memenuhi kebutuhan utama platform tutor sebaya berbasis web. Fitur yang tersedia sudah mencakup alur discovery, autentikasi, manajemen layanan tutor, booking, review, dan pengawasan admin.

## 5.2. Hasil Pengujian Akhir (User Acceptance Testing - UAT)

Pengujian akhir dilakukan dengan pendekatan User Acceptance Testing (UAT), yaitu memastikan fitur sesuai dengan kebutuhan user berdasarkan role. Pengujian dilakukan pada lingkungan lokal setelah database `ruangajar` diimport dan konfigurasi database disesuaikan.

| No | Aktor | Skenario UAT | Hasil yang Diharapkan | Status |
| --- | --- | --- | --- | --- |
| 1 | Public Visitor | Membuka landing page | Halaman tampil lengkap dengan asset | Lulus |
| 2 | Public Visitor | Mencari tutor | Daftar tutor tampil sesuai data | Lulus |
| 3 | Public Visitor | Membuka detail tutor | Detail tutor tampil lengkap | Lulus |
| 4 | Admin | Login admin | Dashboard admin tampil | Lulus |
| 5 | Admin | Mengelola tutor | Data tutor dapat ditambah/diubah/dihapus | Lulus |
| 6 | Admin | Mengelola mahasiswa | Data mahasiswa dapat ditambah/diubah/dihapus | Lulus |
| 7 | Admin | Verifikasi tutor | Status tutor dapat diperbarui | Lulus |
| 8 | Tutor | Login tutor | Dashboard tutor tampil | Lulus |
| 9 | Tutor | Mengelola profil | Data profil tutor tersimpan | Lulus |
| 10 | Tutor | Mengelola mata pelajaran | Subject tutor dapat ditambah atau dihapus | Lulus |
| 11 | Tutor | Mengelola booking | Status booking dapat diperbarui | Lulus |
| 12 | Learner | Login learner | Dashboard learner tampil | Lulus |
| 13 | Learner | Booking tutor | Data booking tersimpan | Lulus |
| 14 | Learner | Melihat riwayat | Riwayat booking tampil | Lulus |
| 15 | Learner | Memberi review | Review tersimpan dan dapat digunakan untuk rating | Lulus |
| 16 | Payment | Transaksi Midtrans sandbox | Transaksi berjalan jika credential sandbox valid | Perlu konfigurasi credential |

Berdasarkan hasil UAT, sistem telah memenuhi kebutuhan dasar dari setiap aktor. Fitur yang paling penting dalam alur sistem, seperti login, pencarian tutor, booking, pengelolaan tutor, pengelolaan mahasiswa, dan review telah berjalan sesuai harapan. Integrasi pembayaran perlu diuji lebih lanjut menggunakan credential Midtrans sandbox yang valid agar proses transaksi dapat diverifikasi sepenuhnya.

# BAB VI: KESIMPULAN DAN SARAN

## 6.1. Kesimpulan

Berdasarkan proses pengembangan, implementasi, dan pengujian sistem RuangAjar Unila, dapat diperoleh beberapa kesimpulan sebagai berikut:

1. Sistem RuangAjar Unila berhasil dikembangkan sebagai platform tutor sebaya berbasis web yang menghubungkan learner dan tutor di lingkungan Universitas Lampung.
2. Sistem telah menyediakan fitur utama seperti landing page, pencarian tutor, detail tutor, autentikasi role, dashboard admin, dashboard tutor, dashboard learner, booking, riwayat, review, dan pengelolaan data.
3. Pengembangan menggunakan pendekatan Agile Scrum membantu tim membagi pekerjaan menjadi sprint yang lebih terukur dan memudahkan evaluasi setiap increment.
4. Perancangan UML melalui Use Case Diagram dan Activity Diagram membantu memperjelas interaksi aktor dengan sistem serta alur kerja fitur utama.
5. Database MySQL yang digunakan telah mendukung relasi utama antara user, tutor, mahasiswa, subject, booking, dan review.
6. Pengujian manual dan UAT menunjukkan bahwa fitur utama sistem telah berjalan sesuai kebutuhan dasar, meskipun fitur pembayaran masih memerlukan konfigurasi credential Midtrans sandbox untuk pengujian penuh.

## 6.2. Saran Pengembangan Selanjutnya

Untuk pengembangan sistem RuangAjar Unila di masa mendatang, terdapat beberapa saran yang dapat dipertimbangkan:

1. Sistem dapat dikembangkan menggunakan framework seperti Laravel agar struktur kode menjadi lebih modular, aman, dan mudah dipelihara.
2. Konfigurasi database dan Midtrans sebaiknya dipindahkan ke environment variable agar lebih aman dan fleksibel saat deployment.
3. Fitur chat real-time dapat ditambahkan untuk memudahkan komunikasi antara learner dan tutor sebelum sesi belajar.
4. Sistem dapat dilengkapi dengan notifikasi email atau WhatsApp untuk memberi informasi perubahan status booking.
5. Fitur pembayaran Midtrans perlu diuji secara penuh menggunakan credential sandbox yang valid dan mekanisme verifikasi notifikasi yang lebih kuat.
6. Pengujian otomatis dapat ditambahkan agar validasi fitur lebih konsisten, terutama untuk autentikasi, booking, review, dan pembayaran.
7. Sistem dapat dikembangkan menjadi aplikasi mobile atau progressive web app agar lebih mudah diakses melalui perangkat seluler.
8. Dashboard analitik dapat ditambahkan untuk menampilkan jumlah booking, tutor aktif, learner aktif, rating tutor, dan tren mata pelajaran yang paling banyak diminati.

Dengan pengembangan lanjutan tersebut, RuangAjar Unila dapat menjadi platform pembelajaran sebaya yang lebih matang, terukur, dan mampu mendukung ekosistem akademik Universitas Lampung secara lebih luas.
