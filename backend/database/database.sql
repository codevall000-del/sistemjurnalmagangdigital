-- Database dump for Sistem Jurnal Magang Digital
-- Generated: 2026-09-27 08:43:53

PRAGMA foreign_keys = OFF;

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_09_27_062901_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_09_27_070000_create_magang_tables', '1');

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "role" varchar not null default 'siswa', "nisn_nip" varchar, "phone" varchar, "avatar" varchar, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime);

INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Ir. Bambang Hermanto, M.T', 'admin@magang.id', 'admin', '197508101999031002', '081234567890', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'Dra. Nurul Hidayah, M.Pd', 'guru@magang.id', 'guru', '198005122005012003', '081398765432', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Ahmad Fauzi, S.Pd', 'fauzi@magang.id', 'guru', '198502142008011005', '081311223344', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Hendra Wijaya, S.Kom', 'dudi@magang.id', 'dudi', 'ID-TELKOM-8821', '081122334455', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'Linda Kusuma, M.Ds', 'linda@magang.id', 'dudi', 'ID-IMK-4412', '081199887766', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Budi Santoso', 'siswa@magang.id', 'siswa', '0061234567', '085712345678', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'Siti Rahma', 'siti@magang.id', 'siswa', '0061234568', '085723456789', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('8', 'Rizky Pratama', 'rizky@magang.id', 'siswa', '0061234569', '085734567890', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `users` (`id`, `name`, `email`, `role`, `nisn_nip`, `phone`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('9', 'Dewi Anggraeni', 'dewi@magang.id', 'siswa', '0061234570', '085745678901', 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150', NULL, '$2y$12$oKQ62DJR24XsFJAFUYpcIe.hhZomQya5KCfnYgNc3XN.CLuji.Kym', NULL, '2026-09-27 06:31:02', '2026-09-27 06:31:02');

-- Table: password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));

-- Table: sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));

-- Table: cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));

-- Table: cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));

-- Table: jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);

-- Table: job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));

-- Table: failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" varchar not null, "queue" varchar not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);

-- Table: personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE "personal_access_tokens" ("id" integer primary key autoincrement not null, "tokenable_type" varchar not null, "tokenable_id" integer not null, "name" text not null, "token" varchar not null, "abilities" text, "last_used_at" datetime, "expires_at" datetime, "created_at" datetime, "updated_at" datetime);

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES ('1', 'App\Models\User', '6', 'demo-token', '1d50dcef695b874e001c8e7ee0f3e3282e787f8e1b3fea85c913adf7eb8ed857', '["*"]', NULL, NULL, '2026-09-27 06:40:51', '2026-09-27 06:40:51');
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES ('2', 'App\Models\User', '6', 'demo-token', '1b1e614086fe77f9af7beb55bc7416026c0ffbe836bbaad880757d7d28dd3b4b', '["*"]', '2026-09-27 06:41:37', NULL, '2026-09-27 06:41:36', '2026-09-27 06:41:37');

-- Table: companies
DROP TABLE IF EXISTS `companies`;
CREATE TABLE "companies" ("id" integer primary key autoincrement not null, "name" varchar not null, "sector" varchar, "address" varchar, "phone" varchar, "email" varchar, "website" varchar, "quota" integer not null default '5', "created_at" datetime, "updated_at" datetime);

INSERT INTO `companies` (`id`, `name`, `sector`, `address`, `phone`, `email`, `website`, `quota`, `created_at`, `updated_at`) VALUES ('1', 'PT Telkom Digital Solusi', 'Software House & Cloud Infrastructure', 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan', '021-52991000', 'internship@telkomdigital.co.id', 'https://telkomdigital.co.id', '6', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `companies` (`id`, `name`, `sector`, `address`, `phone`, `email`, `website`, `quota`, `created_at`, `updated_at`) VALUES ('2', 'PT Inovasi Media Kreatif', 'UI/UX Design, Web Application & Digital Marketing', 'Jl. Ir. H. Juanda No. 88, Dago, Bandung', '022-2508899', 'hr@inovasimedia.id', 'https://inovasimedia.id', '4', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `companies` (`id`, `name`, `sector`, `address`, `phone`, `email`, `website`, `quota`, `created_at`, `updated_at`) VALUES ('3', 'Bank Mandiri IT Hub Innovation', 'Fintech, Cyber Security & Microservices', 'Plaza Mandiri Lt. 9, Jl. Jend. Sudirman Kav. 54-55, Jakarta', '021-5265045', 'talent.ithub@bankmandiri.co.id', 'https://mandiriithub.co.id', '8', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `companies` (`id`, `name`, `sector`, `address`, `phone`, `email`, `website`, `quota`, `created_at`, `updated_at`) VALUES ('4', 'CV Nusantara Studio Digital', 'Game Development & Mobile Apps', 'Jl. Kaliurang KM 7, Sinduharjo, Sleman, D.I. Yogyakarta', '0274-889911', 'career@nusantarastudio.com', 'https://nusantarastudio.com', '4', '2026-09-27 06:31:02', '2026-09-27 06:31:02');

-- Table: placements
DROP TABLE IF EXISTS `placements`;
CREATE TABLE "placements" ("id" integer primary key autoincrement not null, "student_id" integer not null, "company_id" integer not null, "dudi_mentor_id" integer, "teacher_mentor_id" integer, "start_date" date not null, "end_date" date not null, "academic_year" varchar not null default '2025/2026', "batch" varchar not null default 'Angkatan 32', "status" varchar not null default 'active', "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "users"("id") on delete cascade, foreign key("company_id") references "companies"("id") on delete cascade, foreign key("dudi_mentor_id") references "users"("id") on delete set null, foreign key("teacher_mentor_id") references "users"("id") on delete set null);

INSERT INTO `placements` (`id`, `student_id`, `company_id`, `dudi_mentor_id`, `teacher_mentor_id`, `start_date`, `end_date`, `academic_year`, `batch`, `status`, `created_at`, `updated_at`) VALUES ('1', '6', '1', '4', '2', '2026-07-27 00:00:00', '2027-01-27 00:00:00', '2025/2026', 'Angkatan 32', 'active', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `placements` (`id`, `student_id`, `company_id`, `dudi_mentor_id`, `teacher_mentor_id`, `start_date`, `end_date`, `academic_year`, `batch`, `status`, `created_at`, `updated_at`) VALUES ('2', '7', '1', '4', '2', '2026-07-27 00:00:00', '2027-01-27 00:00:00', '2025/2026', 'Angkatan 32', 'active', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `placements` (`id`, `student_id`, `company_id`, `dudi_mentor_id`, `teacher_mentor_id`, `start_date`, `end_date`, `academic_year`, `batch`, `status`, `created_at`, `updated_at`) VALUES ('3', '8', '2', '5', '2', '2026-07-27 00:00:00', '2027-01-27 00:00:00', '2025/2026', 'Angkatan 32', 'active', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `placements` (`id`, `student_id`, `company_id`, `dudi_mentor_id`, `teacher_mentor_id`, `start_date`, `end_date`, `academic_year`, `batch`, `status`, `created_at`, `updated_at`) VALUES ('4', '9', '3', NULL, '3', '2026-07-27 00:00:00', '2027-01-27 00:00:00', '2025/2026', 'Angkatan 32', 'active', '2026-09-27 06:31:02', '2026-09-27 06:31:02');

-- Table: attendances
DROP TABLE IF EXISTS `attendances`;
CREATE TABLE "attendances" ("id" integer primary key autoincrement not null, "student_id" integer not null, "date" date not null, "check_in" varchar, "check_out" varchar, "status" varchar not null default 'hadir', "notes" varchar, "location_in" varchar, "location_out" varchar, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "users"("id") on delete cascade);

INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('1', '6', '2026-09-14 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('2', '6', '2026-09-15 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('3', '6', '2026-09-16 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('4', '6', '2026-09-17 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('5', '6', '2026-09-18 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('6', '6', '2026-09-21 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('7', '6', '2026-09-22 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('8', '6', '2026-09-23 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('9', '6', '2026-09-24 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('10', '6', '2026-09-25 00:00:00', '07:42:00', '17:05:00', 'hadir', 'Tepat waktu di kantor Telkom Landmark', '-6.2301, 106.8228', '-6.2301, 106.8228', '2026-09-27 06:31:02', '2026-09-27 06:31:02');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('11', '6', '2026-09-27 00:00:00', '07:35:12', NULL, 'hadir', 'Presensi pagi berhasil melalui sistem web desktop', '-6.2301, 106.8228', NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('12', '7', '2026-09-22 00:00:00', '07:58:00', '17:00:00', 'hadir', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('13', '7', '2026-09-23 00:00:00', '07:58:00', '17:00:00', 'hadir', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('14', '7', '2026-09-24 00:00:00', '07:58:00', '17:00:00', 'hadir', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `attendances` (`id`, `student_id`, `date`, `check_in`, `check_out`, `status`, `notes`, `location_in`, `location_out`, `created_at`, `updated_at`) VALUES ('15', '7', '2026-09-25 00:00:00', '07:58:00', '17:00:00', 'hadir', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');

-- Table: logbooks
DROP TABLE IF EXISTS `logbooks`;
CREATE TABLE "logbooks" ("id" integer primary key autoincrement not null, "student_id" integer not null, "date" date not null, "title" varchar, "activity_description" text not null, "photo_url" text, "status" varchar not null default 'menunggu', "feedback_note" text, "validated_by" integer, "validated_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "users"("id") on delete cascade, foreign key("validated_by") references "users"("id") on delete set null);

INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('1', '6', '2026-09-23 00:00:00', 'Implementasi Endpoint REST API Autentikasi Sanctum', 'Melakukan setup Laravel Sanctum untuk authentication token bearer, membuat middleware verifikasi peran aktor (siswa, dudi, guru, admin), dan menguji validasi request login menggunakan Postman.', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600', 'diacc', 'Kerja bagus, struktur controller dan error handling sudah memenuhi standar code review tim backend.', '4', '2026-09-24 00:00:00', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('2', '6', '2026-09-24 00:00:00', 'Integrasi State Management Pinia pada Nuxt 3', 'Mengonfigurasi state global untuk token autentikasi, status koneksi offline/online dengan reactive indicator, dan persistence data profil menggunakan pinia-plugin-persistedstate.', 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600', 'diacc', 'Arsitektur store sangat rapi dan reusable.', '4', '2026-09-25 00:00:00', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('3', '6', '2026-09-25 00:00:00', 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas', 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend untuk menghemat bandwidth pengguna dan storage server.', 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600', 'revisi', 'Hasil kompresi terlalu kecil sehingga tulisan kode di layar agak blur. Tolong naikkan kualitas kompresi ke target minimal 70% dan upload ulang screenshot.', '4', '2026-09-26 00:00:00', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('4', '6', '2026-09-26 00:00:00', 'Pembuatan Tampilan Antarmuka Split-Screen Validasi DUDI', 'Merancang layout split view sesuai panduan UX desktop: daftar siswa di panel samping kiri dan detail jurnal interaktif beserta aksi validasi di panel kanan.', 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600', 'menunggu', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('5', '7', '2026-09-25 00:00:00', 'Slicing Desain Dashboard Siswa ke Nuxt 3 & Tailwind CSS', 'Membuat komponen widget tombol raksasa Check-In/Check-Out, widget persentase kehadiran dengan circular gauge, serta widget sisa hari magang.', 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600', 'menunggu', NULL, NULL, NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `logbooks` (`id`, `student_id`, `date`, `title`, `activity_description`, `photo_url`, `status`, `feedback_note`, `validated_by`, `validated_at`, `created_at`, `updated_at`) VALUES ('6', '8', '2026-09-22 00:00:00', 'Riset Komponen Desain UI Figma', 'Mengumpulkan wireframe dan moodboard design system aplikasi e-commerce.', 'https://images.unsplash.com/photo-1581291518655-9523c93269c4?w=600', 'diacc', NULL, '5', NULL, '2026-09-27 06:31:03', '2026-09-27 06:31:03');

-- Table: grades
DROP TABLE IF EXISTS `grades`;
CREATE TABLE "grades" ("id" integer primary key autoincrement not null, "student_id" integer not null, "dudi_score_discipline" integer not null default '0', "dudi_score_technical" integer not null default '0', "dudi_score_teamwork" integer not null default '0', "dudi_score_initiative" integer not null default '0', "dudi_score_average" numeric not null default '0', "dudi_notes" text, "school_report_score" numeric, "final_score" numeric, "qr_code_hash" varchar, "is_finalized" tinyint(1) not null default '0', "finalized_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("student_id") references "users"("id") on delete cascade);

INSERT INTO `grades` (`id`, `student_id`, `dudi_score_discipline`, `dudi_score_technical`, `dudi_score_teamwork`, `dudi_score_initiative`, `dudi_score_average`, `dudi_notes`, `school_report_score`, `final_score`, `qr_code_hash`, `is_finalized`, `finalized_at`, `created_at`, `updated_at`) VALUES ('1', '6', '92', '95', '90', '93', '92.5', 'Budi menunjukkan etos kerja luar biasa, pemahaman arsitektur software sangat cepat, dan selalu proaktif menyelesaikan sprint tugas tepat waktu.', '90', '91.5', 'PKL-2026-TELKOM-BUDI-9150-VERIFIED', '1', '2026-09-26 00:00:00', '2026-09-27 06:31:03', '2026-09-27 06:31:03');

-- Table: notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE "notifications" ("id" integer primary key autoincrement not null, "user_id" integer not null, "title" varchar not null, "message" text not null, "type" varchar not null default 'info', "is_read" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES ('1', '6', 'Catatan Revisi Logbook', 'Jurnal Anda "Optimasi Upload Foto Jurnal" perlu revisi: Naikkan kualitas kompresi ke minimal 70%.', 'warning', '0', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES ('2', '6', 'Jurnal Diterima', 'Jurnal "Integrasi State Management Pinia" telah di-ACC oleh Hendra Wijaya, S.Kom.', 'success', '1', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES ('3', '4', 'Jurnal Menunggu Validasi', 'Terdapat 2 jurnal magang baru dari Budi Santoso dan Siti Rahma yang menunggu untuk divalidasi.', 'info', '0', '2026-09-27 06:31:03', '2026-09-27 06:31:03');
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES ('4', '2', 'Peringatan Ketidakhadiran Siswa!', 'Siswa Rizky Pratama (PT Inovasi Media Kreatif) terdeteksi tidak mengisi presensi dan jurnal selama lebih dari 3 hari berturut-turut.', 'danger', '0', '2026-09-27 06:31:03', '2026-09-27 06:31:03');

PRAGMA foreign_keys = ON;
