-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: ruangajar
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `learner_id` int NOT NULL,
  `tutor_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `duration` int DEFAULT '60',
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `payment_status` enum('unpaid','pending','paid','failed') DEFAULT 'unpaid',
  `snap_token` varchar(255) DEFAULT NULL,
  `midtrans_order_id` varchar(100) DEFAULT NULL,
  `notes` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `learner_id` (`learner_id`),
  KEY `tutor_id` (`tutor_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `fk_bookings_learner` FOREIGN KEY (`learner_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bookings_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bookings_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iklan_tutor`
--

DROP TABLE IF EXISTS `iklan_tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `iklan_tutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `jenjang` enum('SD','SMP','SMA','Umum') NOT NULL,
  `harga` int NOT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `pengalaman` varchar(255) DEFAULT NULL,
  `status` enum('aktif','non-aktif') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  CONSTRAINT `fk_iklan_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iklan_tutor`
--

LOCK TABLES `iklan_tutor` WRITE;
/*!40000 ALTER TABLE `iklan_tutor` DISABLE KEYS */;
/*!40000 ALTER TABLE `iklan_tutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nim` varchar(20) DEFAULT NULL,
  `angkatan` int DEFAULT '2024',
  `fakultas` varchar(100) DEFAULT 'FMIPA',
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenjang` enum('SD','SMP','SMA') DEFAULT NULL,
  `sekolah` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `minat` text,
  `status` enum('Aktif','Cuti','Non-Aktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'2415061001',2024,'FMIPA','Budi Santoso','budi@students.unila.ac.id',NULL,'Universitas Lampung','Ilmu Komputer',NULL,'Aktif','2026-06-17 15:20:48'),(2,'2415061002',2024,'Teknik','Citra Dewi','citra@students.unila.ac.id',NULL,'Universitas Lampung','Teknik Elektro',NULL,'Aktif','2026-06-17 15:20:48'),(3,'2315061003',2023,'FEB','Deni Firmansyah','deni@students.unila.ac.id',NULL,'Universitas Lampung','Manajemen',NULL,'Aktif','2026-06-17 15:20:48'),(4,'2415061011',2024,'FMIPA','Eka Putri','eka@students.unila.ac.id',NULL,'Universitas Lampung','Biologi',NULL,'Aktif','2026-06-17 15:29:33'),(5,'2415061012',2024,'Teknik','Fajar Nugroho','fajar@students.unila.ac.id',NULL,'Universitas Lampung','Teknik Mesin',NULL,'Aktif','2026-06-17 15:29:33'),(6,'2315061013',2023,'FEB','Gina Rahmawati','gina@students.unila.ac.id',NULL,'Universitas Lampung','Ekonomi Pembangunan',NULL,'Aktif','2026-06-17 15:29:33'),(7,'2215061014',2022,'Hukum','Hadi Wijaya','hadi@students.unila.ac.id',NULL,'Universitas Lampung','Ilmu Hukum',NULL,'Aktif','2026-06-17 15:29:33'),(8,'2415061015',2024,'FKIP','Indah Permata','indah@students.unila.ac.id',NULL,'Universitas Lampung','Pendidikan Fisika',NULL,'Aktif','2026-06-17 15:29:33'),(9,'2315061016',2023,'Pertanian','Jihan Aulia','jihan@students.unila.ac.id',NULL,'Universitas Lampung','Ilmu Tanah',NULL,'Aktif','2026-06-17 15:29:33'),(10,'2215061017',2022,'FISIP','Krisna Mukti','krisna@students.unila.ac.id',NULL,'Universitas Lampung','Sosiologi',NULL,'Aktif','2026-06-17 15:29:33'),(11,'2415061018',2024,'Kedokteran','Laila Sari','laila@students.unila.ac.id',NULL,'Universitas Lampung','Pendidikan Dokter',NULL,'Aktif','2026-06-17 15:29:33'),(12,'2315061019',2023,'FMIPA','Mario Putra','mario@students.unila.ac.id',NULL,'Universitas Lampung','Kimia',NULL,'Aktif','2026-06-17 15:29:33'),(13,'2215061020',2022,'Teknik','Nina Kurnia','nina@students.unila.ac.id',NULL,'Universitas Lampung','Teknik Elektro',NULL,'Aktif','2026-06-17 15:29:33');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_id` int NOT NULL,
  `learner_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `rating` int NOT NULL,
  `review_text` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  KEY `learner_id` (`learner_id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `fk_reviews_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_learner` FOREIGN KEY (`learner_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_chk_1` CHECK (((`rating` >= 1) and (`rating` <= 5)))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_id` int NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `description` text,
  `price` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  CONSTRAINT `fk_subjects_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,1,'Pemrograman Dasar','Belajar dasar C++ dan Python',100000,'2026-06-17 15:20:48'),(2,2,'Public Speaking','Praktek presentasi',85000,'2026-06-17 15:20:48'),(3,3,'Struktur Data','Array, Linked List, Tree',120000,'2026-06-17 15:20:48'),(4,4,'Anatomi Dasar','Sistem tubuh manusia',150000,'2026-06-17 15:20:48'),(5,5,'Hukum Pidana','Pengantar Hukum Pidana',90000,'2026-06-17 15:20:48'),(6,6,'Kalkulus I','Persiapan UTS Kalkulus',75000,'2026-06-17 15:29:33'),(7,7,'Makroekonomi','Konsep GDP dan Inflasi',85000,'2026-06-17 15:29:33'),(8,8,'Agribisnis','Sistem pertanian terpadu',70000,'2026-06-17 15:29:33'),(9,9,'HTN','Dasar Konstitusi',100000,'2026-06-17 15:29:33'),(10,10,'Biologi Dasar','Persiapan Praktikum',80000,'2026-06-17 15:29:33'),(11,11,'Statika','Analisis gaya pada struktur',110000,'2026-06-17 15:29:33'),(12,12,'Botani Farmasi','Identifikasi simplisia',95000,'2026-06-17 15:29:33'),(13,13,'Pengantar Ilmu Politik','Sistem politik Indonesia',85000,'2026-06-17 15:29:33'),(14,14,'TOEFL Prep','Latihan soal TOEFL',80000,'2026-06-17 15:29:33'),(15,15,'Akuntansi Keuangan','Laporan Keuangan',90000,'2026-06-17 15:29:33'),(16,16,'Bioteknologi','Aplikasi mikrob',75000,'2026-06-17 15:29:33'),(17,17,'Fisika Kuantum','Pendahuluan kuantum',100000,'2026-06-17 15:29:33'),(18,18,'Termodinamika','Hukum Termodinamika',95000,'2026-06-17 15:29:33'),(19,19,'Hukum Bisnis','Kontrak dagang',85000,'2026-06-17 15:29:33'),(20,20,'Biokimia','Metabolisme dasar',120000,'2026-06-17 15:29:33');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor`
--

DROP TABLE IF EXISTS `tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `npm` varchar(20) DEFAULT NULL,
  `angkatan` int DEFAULT '2022',
  `fakultas` varchar(100) DEFAULT 'FMIPA',
  `telepon` varchar(15) DEFAULT NULL,
  `keahlian` varchar(50) DEFAULT NULL,
  `pendidikan` varchar(100) DEFAULT NULL,
  `pengalaman_mengajar` int DEFAULT '0',
  `harga_per_sesi` int DEFAULT '0',
  `deskripsi` text,
  `status` enum('Aktif','Non-Aktif','Cuti') DEFAULT 'Non-Aktif',
  `rating` decimal(3,2) DEFAULT '0.00',
  `foto_profil` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_notification` tinyint(1) DEFAULT '1',
  `booking_notification` tinyint(1) DEFAULT '1',
  `reminder_notification` tinyint(1) DEFAULT '1',
  `availability_status` enum('Tersedia','Sibuk','Tidak Tersedia') DEFAULT 'Tersedia',
  `availability_note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutor`
--

LOCK TABLES `tutor` WRITE;
/*!40000 ALTER TABLE `tutor` DISABLE KEYS */;
INSERT INTO `tutor` VALUES (1,'Rizky Ramadhan','rizky@students.unila.ac.id','2115061012',2021,'FMIPA','081234567890','Ilmu Komputer','S1 Ilmu Komputer',3,100000,'Asisten Praktikum Pemrograman Dasar. Siap membantu mahasiswa memahami logika coding.','Aktif',4.90,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:20:48'),(2,'Aulia Putri','aulia@students.unila.ac.id','2214071034',2022,'FISIP','081234567891','Ilmu Komunikasi','S1 Ilmu Komunikasi',2,85000,'Berpengalaman membantu presentasi publik dan teori komunikasi massa.','Aktif',4.80,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:20:48'),(3,'Dimas Wahyu','dimas@students.unila.ac.id','2015061099',2020,'Teknik','081234567892','Teknik Informatika','S1 Teknik Informatika',4,120000,'Kating Teknik Informatika, spesialis Struktur Data dan Algoritma.','Aktif',5.00,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:20:48'),(4,'Nadia Fitri','nadia@students.unila.ac.id','2313021011',2023,'Kedokteran','081234567893','Pendidikan Dokter','S1 Pendidikan Dokter',1,150000,'Tutor Anatomi dan Fisiologi Dasar.','Aktif',4.70,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:20:48'),(5,'Farhan Akbar','farhan@students.unila.ac.id','2112011044',2021,'Hukum','081234567894','Ilmu Hukum','S1 Ilmu Hukum',2,90000,'Siap membimbing materi Hukum Perdata dan Hukum Pidana dasar.','Aktif',4.60,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:20:48'),(6,'Sinta Dewi','sinta@students.unila.ac.id','2215061011',2022,'FKIP','081234567810','Pendidikan Matematika','S1 Pendidikan Matematika',2,75000,'Tutor Pendidikan Matematika untuk membantu mahasiswa TPB.','Aktif',4.50,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(7,'Adi Pratama','adi@students.unila.ac.id','2115061012',2021,'FEB','081234567811','Manajemen','S1 Manajemen',3,85000,'Membimbing Ekonomi Mikro dan Makro.','Aktif',4.70,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(8,'Maya Sari','maya@students.unila.ac.id','2315061013',2023,'Pertanian','081234567812','Agribisnis','S1 Agribisnis',1,70000,'Siap membimbing Pengantar Ilmu Pertanian.','Aktif',4.40,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(9,'Rahman Hakim','rahman@students.unila.ac.id','2015061014',2020,'Hukum','081234567813','Ilmu Hukum','S1 Ilmu Hukum',4,100000,'Berpengalaman dalam Hukum Tata Negara.','Aktif',4.90,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(10,'Putri Ayu','putri@students.unila.ac.id','2215061015',2022,'FMIPA','081234567814','Biologi','S1 Biologi',2,80000,'Tutor Anatomi Tumbuhan dan Hewan.','Aktif',4.80,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(11,'Arif Budiman','arif@students.unila.ac.id','2115061016',2021,'Teknik','081234567815','Teknik Sipil','S1 Teknik Sipil',3,110000,'Siap membimbing Mekanika Teknik.','Aktif',4.60,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(12,'Sari Indah','sari@students.unila.ac.id','2315061017',2023,'Kedokteran','081234567816','Farmasi','S1 Farmasi',1,95000,'Tutor Farmakognosi Dasar.','Aktif',4.50,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(13,'Bima Sakti','bima@students.unila.ac.id','2015061018',2020,'FISIP','081234567817','Ilmu Administrasi Negara','S1 Ilmu Administrasi Negara',4,85000,'Membimbing Kebijakan Publik.','Aktif',4.90,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(14,'Dewi Kartika','dewi@students.unila.ac.id','2215061019',2022,'FKIP','081234567818','Pendidikan Bahasa Inggris','S1 Pendidikan Bahasa Inggris',2,80000,'Tutor Grammar dan Conversation.','Aktif',4.80,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(15,'Eko Prasetyo','eko@students.unila.ac.id','2115061020',2021,'FEB','081234567819','Akuntansi','S1 Akuntansi',3,90000,'Siap membimbing Pengantar Akuntansi.','Aktif',4.70,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(16,'Fitria Nur','fitria@students.unila.ac.id','2315061021',2023,'Pertanian','081234567820','Teknologi Hasil Pertanian','S1 Teknologi Hasil Pertanian',1,75000,'Tutor Kimia Pangan Dasar.','Aktif',4.60,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(17,'Gilang Ramadan','gilang@students.unila.ac.id','2015061022',2020,'FMIPA','081234567821','Fisika','S1 Fisika',4,100000,'Berpengalaman dalam Fisika Dasar.','Aktif',5.00,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(18,'Hana Safira','hana@students.unila.ac.id','2215061023',2022,'Teknik','081234567822','Teknik Kimia','S1 Teknik Kimia',2,95000,'Membimbing Azas Teknik Kimia.','Aktif',4.70,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(19,'Irfan Maulana','irfan@students.unila.ac.id','2115061024',2021,'Hukum','081234567823','Ilmu Hukum','S1 Ilmu Hukum',3,85000,'Tutor Hukum Perdata Internasional.','Aktif',4.80,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33'),(20,'Julia Rahmawati','julia@students.unila.ac.id','2315061025',2023,'Kedokteran','081234567824','Pendidikan Dokter','S1 Pendidikan Dokter',1,120000,'Siap membimbing Biologi Sel dan Molekuler.','Aktif',4.90,NULL,'$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu',1,1,1,'Tersedia',NULL,'2026-06-17 15:29:33');
/*!40000 ALTER TABLE `tutor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor_mapel`
--

DROP TABLE IF EXISTS `tutor_mapel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutor_mapel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tutor_id` int NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `jenjang` enum('SD','SMP','SMA','Umum') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tutor_id` (`tutor_id`),
  CONSTRAINT `fk_tutor_mapel` FOREIGN KEY (`tutor_id`) REFERENCES `tutor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutor_mapel`
--

LOCK TABLES `tutor_mapel` WRITE;
/*!40000 ALTER TABLE `tutor_mapel` DISABLE KEYS */;
INSERT INTO `tutor_mapel` VALUES (1,1,'Pemrograman Dasar','Umum'),(2,1,'Basis Data','Umum'),(3,2,'Public Speaking','Umum'),(4,3,'Struktur Data','Umum'),(5,4,'Anatomi Dasar','Umum'),(6,5,'Hukum Pidana Dasar','Umum'),(7,6,'Pendidikan Matematika Dasar','Umum'),(8,7,'Ekonomi Mikro','Umum'),(9,8,'Pengantar Ilmu Pertanian','Umum'),(10,9,'Hukum Tata Negara','Umum'),(11,10,'Anatomi Tumbuhan','Umum'),(12,11,'Mekanika Teknik','Umum'),(13,12,'Farmakognosi Dasar','Umum'),(14,13,'Kebijakan Publik','Umum'),(15,14,'English Conversation','Umum'),(16,15,'Pengantar Akuntansi','Umum'),(17,16,'Kimia Pangan Dasar','Umum'),(18,17,'Fisika Dasar','Umum'),(19,18,'Azas Teknik Kimia','Umum'),(20,19,'Hukum Perdata Internasional','Umum'),(21,20,'Biologi Sel dan Molekuler','Umum');
/*!40000 ALTER TABLE `tutor_mapel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','tutor','learner') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@ruangajar.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','admin','2026-06-17 15:20:48'),(2,'Rizky Ramadhan','rizky@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:20:48'),(3,'Aulia Putri','aulia@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:20:48'),(4,'Dimas Wahyu','dimas@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:20:48'),(5,'Nadia Fitri','nadia@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:20:48'),(6,'Farhan Akbar','farhan@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:20:48'),(7,'Budi Santoso','budi@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:20:48'),(8,'Citra Dewi','citra@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:20:48'),(9,'Deni Firmansyah','deni@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:20:48'),(10,'Sinta Dewi','sinta@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(11,'Adi Pratama','adi@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(12,'Maya Sari','maya@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(13,'Rahman Hakim','rahman@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(14,'Putri Ayu','putri@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(15,'Arif Budiman','arif@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(16,'Sari Indah','sari@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(17,'Bima Sakti','bima@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(18,'Dewi Kartika','dewi@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(19,'Eko Prasetyo','eko@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(20,'Fitria Nur','fitria@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(21,'Gilang Ramadan','gilang@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(22,'Hana Safira','hana@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(23,'Irfan Maulana','irfan@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(24,'Julia Rahmawati','julia@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','tutor','2026-06-17 15:29:33'),(25,'Eka Putri','eka@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(26,'Fajar Nugroho','fajar@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(27,'Gina Rahmawati','gina@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(28,'Hadi Wijaya','hadi@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(29,'Indah Permata','indah@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(30,'Jihan Aulia','jihan@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(31,'Krisna Mukti','krisna@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(32,'Laila Sari','laila@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(33,'Mario Putra','mario@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33'),(34,'Nina Kurnia','nina@students.unila.ac.id','$2y$10$ne9boh8RofWmEdJznC6GSO7dt10HGn2sAflXgbkJrsBWHePG2hkRu','learner','2026-06-17 15:29:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-17 22:47:05
