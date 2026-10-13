-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: jurnal_magang
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.4

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
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hadir',
  `work_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wfo',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `distance_meters` int DEFAULT NULL,
  `is_within_radius` tinyint(1) NOT NULL DEFAULT '1',
  `is_dispute` tinyint(1) NOT NULL DEFAULT '0',
  `dispute_reason` text COLLATE utf8mb4_unicode_ci,
  `dispute_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dispute_resolved_by` bigint unsigned DEFAULT NULL,
  `dispute_resolved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`),
  KEY `attendances_dispute_resolved_by_foreign` (`dispute_resolved_by`),
  CONSTRAINT `attendances_dispute_resolved_by_foreign` FOREIGN KEY (`dispute_resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,6,'2026-10-01','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(2,6,'2026-10-02','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(3,6,'2026-10-05','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(4,6,'2026-10-06','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(5,6,'2026-10-07','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(6,6,'2026-10-08','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(7,6,'2026-10-09','07:45:00','17:05:00','hadir','wfo',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(8,6,'2026-10-11','07:35:12',NULL,'hadir','wfo',-6.2301000,106.8228000,18,1,0,NULL,'none','Presensi pagi WFO terverifikasi geofence Telkom Landmark','-6.2301, 106.8228',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(9,7,'2026-10-01','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(10,7,'2026-10-02','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(11,7,'2026-10-05','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(12,7,'2026-10-06','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(13,7,'2026-10-07','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(14,7,'2026-10-08','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(15,7,'2026-10-09','07:45:00','17:05:00','hadir','wfh',-6.2301000,106.8228000,25,1,0,NULL,'none','Presensi harian tercatat online di PT Telkom Digital Solusi','-6.2301, 106.8228','-6.2301, 106.8228','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(16,8,'2026-10-01','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(17,8,'2026-10-02','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(18,8,'2026-10-05','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(19,8,'2026-10-06','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(20,8,'2026-10-07','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(21,8,'2026-10-08','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(22,8,'2026-10-09','07:45:00','17:05:00','hadir','wfa',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(23,9,'2026-10-01','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(24,9,'2026-10-02','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(25,9,'2026-10-05','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(26,9,'2026-10-06','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(27,9,'2026-10-07','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(28,9,'2026-10-08','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(29,9,'2026-10-09','07:45:00','17:05:00','hadir','wfo',-6.1852000,106.8315000,25,1,0,NULL,'none','Presensi harian tercatat online di Studio Animasi Kinetik Digital','-6.1852, 106.8315','-6.1852, 106.8315','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(30,10,'2026-09-28','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(31,10,'2026-09-29','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(32,10,'2026-09-30','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(33,10,'2026-10-01','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(34,10,'2026-10-02','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(35,10,'2026-10-05','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(36,10,'2026-10-06','07:50:00','17:00:00','hadir','wfo',-6.2155000,106.8650000,30,1,0,NULL,'none','Presensi kehadiran',NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(37,11,'2026-10-01','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(38,11,'2026-10-02','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(39,11,'2026-10-05','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(40,11,'2026-10-06','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(41,11,'2026-10-07','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(42,11,'2026-10-08','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL),(43,11,'2026-10-09','07:45:00','17:05:00','hadir','wfh',-6.2155000,106.8650000,25,1,0,NULL,'none','Presensi harian tercatat online di Pixel Kreatif Visual Agency','-6.2155, 106.865','-6.2155, 106.865','2026-10-10 21:30:22','2026-10-10 21:30:22',NULL,NULL);
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quota` int NOT NULL DEFAULT '5',
  `latitude` decimal(10,7) NOT NULL DEFAULT '-6.2301000',
  `longitude` decimal(10,7) NOT NULL DEFAULT '106.8228000',
  `radius_meters` int NOT NULL DEFAULT '150',
  `allowed_work_modes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wfo,wfh,wfa',
  `office_schedule` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'PT Telkom Digital Solusi','Software House & Cloud Infrastructure (RPL)','Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan','021-52991000','internship@telkomdigital.co.id','https://telkomdigital.co.id',6,-6.2301000,106.8228000,150,'wfo,wfh',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(2,'Studio Animasi Kinetik Digital','3D Animation & CGI Motion Picture (Animasi)','Jl. Raden Saleh No. 18, Cikini, Jakarta Pusat','021-31902211','hr@kinetikanimasi.id','https://kinetikanimasi.id',4,-6.1852000,106.8315000,200,'wfo,wfh,wfa',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(3,'Pixel Kreatif Visual Agency','Branding, Creative Media & UI/UX (DKV)','Jl. Pemuda No. 65, Rawamangun, Jakarta Timur','021-47863210','career@pixelkreatif.com','https://pixelkreatif.com',5,-6.2155000,106.8650000,150,'wfo,wfa',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `dudi_score_discipline` int NOT NULL DEFAULT '0',
  `dudi_score_technical` int NOT NULL DEFAULT '0',
  `dudi_score_teamwork` int NOT NULL DEFAULT '0',
  `dudi_score_initiative` int NOT NULL DEFAULT '0',
  `dudi_score_average` decimal(5,2) NOT NULL DEFAULT '0.00',
  `dudi_notes` text COLLATE utf8mb4_unicode_ci,
  `school_score_report` decimal(5,2) DEFAULT NULL,
  `school_score_presentation` decimal(5,2) DEFAULT NULL,
  `school_score_competence` decimal(5,2) DEFAULT NULL,
  `school_notes` text COLLATE utf8mb4_unicode_ci,
  `school_report_score` decimal(5,2) DEFAULT NULL,
  `final_score` decimal(5,2) DEFAULT NULL,
  `qr_code_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `finalized_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grades_student_id_unique` (`student_id`),
  CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,6,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi RPL SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-RPL-6-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(2,7,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi RPL SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-RPL-7-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(3,8,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi Animasi SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-Animasi-8-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(4,9,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi Animasi SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-Animasi-9-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(5,10,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi DKV SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-DKV-10-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(6,11,90,92,88,91,90.25,'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi DKV SMKN 71.',NULL,NULL,NULL,NULL,89.00,89.75,'SMKN71-PKL-DKV-11-VERIFIED',1,'2026-10-08 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logbooks`
--

DROP TABLE IF EXISTS `logbooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logbooks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `is_auto_approved` tinyint(1) NOT NULL DEFAULT '0',
  `feedback_note` text COLLATE utf8mb4_unicode_ci,
  `teacher_note` text COLLATE utf8mb4_unicode_ci,
  `teacher_noted_at` timestamp NULL DEFAULT NULL,
  `validated_by` bigint unsigned DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `logbooks_student_id_foreign` (`student_id`),
  KEY `logbooks_validated_by_foreign` (`validated_by`),
  CONSTRAINT `logbooks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `logbooks_validated_by_foreign` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logbooks`
--

LOCK TABLES `logbooks` WRITE;
/*!40000 ALTER TABLE `logbooks` DISABLE KEYS */;
INSERT INTO `logbooks` VALUES (1,6,'2026-10-09','Pengerjaan Modul Teknis Magang RPL','Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.','https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600','diacc',0,'Pekerjaan sangat baik dan rapi.',NULL,NULL,3,'2026-10-09 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(2,6,'2026-10-10','Pengujian dan Quality Review RPL','Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.','https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600','menunggu',0,NULL,NULL,NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(3,7,'2026-10-09','Pengerjaan Modul Teknis Magang RPL','Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.','https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600','diacc',0,'Pekerjaan sangat baik dan rapi.',NULL,NULL,3,'2026-10-09 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(4,7,'2026-10-10','Pengujian dan Quality Review RPL','Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.','https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600','menunggu',0,NULL,NULL,NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(5,8,'2026-10-09','Pengerjaan Modul Teknis Magang Animasi','Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.','https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600','diacc',0,'Pekerjaan sangat baik dan rapi.',NULL,NULL,4,'2026-10-09 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(6,8,'2026-10-10','Pengujian dan Quality Review Animasi','Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.','https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600','menunggu',0,NULL,NULL,NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(7,9,'2026-10-09','Pengerjaan Modul Teknis Magang Animasi','Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.','https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600','diacc',0,'Pekerjaan sangat baik dan rapi.',NULL,NULL,4,'2026-10-09 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(8,9,'2026-10-10','Pengujian dan Quality Review Animasi','Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.','https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600','menunggu',0,NULL,NULL,NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(9,11,'2026-10-09','Pengerjaan Modul Teknis Magang DKV','Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.','https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600','diacc',0,'Pekerjaan sangat baik dan rapi.',NULL,NULL,5,'2026-10-09 17:00:00','2026-10-10 21:30:22','2026-10-10 21:30:22'),(10,11,'2026-10-10','Pengujian dan Quality Review DKV','Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.','https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600','menunggu',0,NULL,NULL,NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `logbooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_09_27_062901_create_personal_access_tokens_table',1),(5,'2026_09_27_070000_create_magang_tables',1),(6,'2026_10_02_150000_create_work_schedules_and_requests_tables',1),(7,'2026_10_03_220000_add_office_schedule_to_companies_table',1),(8,'2026_10_10_230000_enhance_magang_workflow_systematics',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,'Peringatan Absensi Siswa','Siswa Rizky Pratama (DKV) terdeteksi tidak aktif selama 4 hari berturut-turut di Pixel Kreatif Visual Agency.','danger',0,'2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placements`
--

DROP TABLE IF EXISTS `placements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `placements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `dudi_mentor_id` bigint unsigned DEFAULT NULL,
  `teacher_mentor_id` bigint unsigned DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2025/2026',
  `batch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Angkatan 32',
  `default_work_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wfo',
  `work_schedule` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `relocation_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `previous_placement_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `placements_student_id_foreign` (`student_id`),
  KEY `placements_company_id_foreign` (`company_id`),
  KEY `placements_dudi_mentor_id_foreign` (`dudi_mentor_id`),
  KEY `placements_teacher_mentor_id_foreign` (`teacher_mentor_id`),
  KEY `placements_previous_placement_id_foreign` (`previous_placement_id`),
  CONSTRAINT `placements_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `placements_dudi_mentor_id_foreign` FOREIGN KEY (`dudi_mentor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `placements_previous_placement_id_foreign` FOREIGN KEY (`previous_placement_id`) REFERENCES `placements` (`id`) ON DELETE SET NULL,
  CONSTRAINT `placements_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `placements_teacher_mentor_id_foreign` FOREIGN KEY (`teacher_mentor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placements`
--

LOCK TABLES `placements` WRITE;
/*!40000 ALTER TABLE `placements` DISABLE KEYS */;
INSERT INTO `placements` VALUES (1,6,1,3,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfo','{\"friday\": \"wfh\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfo\", \"wednesday\": \"wfo\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL),(2,7,1,3,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfh','{\"friday\": \"wfh\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfo\", \"wednesday\": \"wfo\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL),(3,8,2,4,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfa','{\"friday\": \"wfa\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfh\", \"wednesday\": \"wfo\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL),(4,9,2,4,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfo','{\"friday\": \"wfa\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfh\", \"wednesday\": \"wfo\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL),(5,10,3,5,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfo','{\"friday\": \"wfh\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfa\", \"wednesday\": \"wfa\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL),(6,11,3,5,2,'2026-08-11','2027-02-11','2025/2026','Angkatan 32','wfh','{\"friday\": \"wfh\", \"monday\": \"wfo\", \"sunday\": \"wfo\", \"tuesday\": \"wfo\", \"saturday\": \"wfo\", \"thursday\": \"wfa\", \"wednesday\": \"wfa\"}','active',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22',NULL);
/*!40000 ALTER TABLE `placements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `nisn_nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ir. Bambang Hermanto, M.T','admin@gmail.com','admin','198001012005011001','081200000001','RPL','Kaprog Vokasi','https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(2,'Dra. Nurul Hidayah, M.Pd','guru@gmail.com','guru','198502142010011002','081200000002','RPL','Guru Pembimbing Utama','https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(3,'Hendra Wijaya, S.Kom','mentor@gmail.com','mentor','ID-TELKOM-8821','081200000003','RPL','Lead Software Engineer','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(4,'Raditya Pratama, S.Sn','mentor2@gmail.com','mentor','ID-KINETIK-104','081200000021','Animasi','Senior 3D Animator','https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(5,'Maya Safitri, M.Ds','mentor3@gmail.com','mentor','ID-PIXEL-332','081200000031','DKV','Creative Director','https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(6,'Budi Santoso','siswa@gmail.com','siswa','0061234567','081200000004','RPL','XII RPL 1','https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(7,'Siti Fauziah','siti@gmail.com','siswa','0061234568','081200000005','RPL','XII RPL 2','https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(8,'Ahmad Danu','danu@gmail.com','siswa','0061234569','081200000006','Animasi','XII Animasi 1','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(9,'Putri Maharani','putri@gmail.com','siswa','0061234570','081200000007','Animasi','XII Animasi 2','https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(10,'Rizky Pratama','rizky@gmail.com','siswa','0061234571','081200000008','DKV','XII DKV 1','https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(11,'Jessica Tan','jessica@gmail.com','siswa','0061234572','081200000009','DKV','XII DKV 2','https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',NULL,'$2y$12$8RecDpe7dPdkgpgitoEa.eTgHaDEWB849NZrMwqSk2zhL9yGUtkv.',NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_mode_requests`
--

DROP TABLE IF EXISTS `work_mode_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_mode_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `placement_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `requested_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `dudi_notes` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_mode_requests_placement_id_foreign` (`placement_id`),
  KEY `work_mode_requests_reviewed_by_foreign` (`reviewed_by`),
  KEY `work_mode_requests_student_id_date_index` (`student_id`,`date`),
  CONSTRAINT `work_mode_requests_placement_id_foreign` FOREIGN KEY (`placement_id`) REFERENCES `placements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `work_mode_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `work_mode_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_mode_requests`
--

LOCK TABLES `work_mode_requests` WRITE;
/*!40000 ALTER TABLE `work_mode_requests` DISABLE KEYS */;
INSERT INTO `work_mode_requests` VALUES (1,7,2,'2026-10-11','wfh','Demam ringan dan flu, namun siap stand by dan mengerjakan slicing UI Nuxt dari rumah.','pending',NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22'),(2,8,3,'2026-10-11','wfa','Riset pencahayaan dan pengambilan referensi visual tekstur di kawasan Kota Tua Jakarta.','pending',NULL,NULL,NULL,'2026-10-10 21:30:22','2026-10-10 21:30:22');
/*!40000 ALTER TABLE `work_mode_requests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-11 11:31:14
