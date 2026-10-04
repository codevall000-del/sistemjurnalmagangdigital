---
name: jurnal-magang-project
description: Expert system guide and analysis runbook for Sistem Jurnal Magang Digital (EduAccess) SMKN 71 Jakarta. Use whenever analyzing the project, checking progress, onboarding on a new device, reviewing architecture, debugging backend/frontend, or planning next steps.
---

# Sistem Jurnal Magang Digital (EduAccess SMKN 71 Jakarta)

Skill ini dirancang agar Antigravity AI di komputer/device mana pun dapat langsung memahami arsitektur, data, alur bisnis 4 aktor, skema database, status fitur, dan langkah-langkah yang harus dilakukan untuk proyek ini hanya dengan satu perintah analisis.

---

## 🎯 Identitas & Visi Proyek

- **Nama Aplikasi:** EduAccess — Sistem Informasi Jurnal & Presensi PKL Digital SMKN 71 Jakarta.
- **Jurusan Sasaran:** 
  - **PPLG** (Pengembangan Perangkat Lunak & Gim)
  - **DKV** (Desain Komunikasi Visual)
  - **Animasi**
- **Arsitektur:** Fullstack Desktop-first Web Application
  - **Backend:** Laravel 11/12 REST API (`/api/*`), Laravel Sanctum, SQLite (default, pre-seeded) & MySQL compatibility (`database.sql`).
  - **Frontend:** Nuxt 3 (Vue 3, TypeScript, Tailwind CSS, Pinia/reactive state store via `useAppStore.ts`).
  - **Layout:** Standard Desktop Enterprise Layout:
    - **Navbar (Sidebar Kiri):** Role switcher, menu navigasi, status offline/online, sync indicator, profile, settings, logout.
    - **View (Area Konten Kanan):** Dashboard analitik, split-screen review, formulir STAR, matriks kehadiran, penempatan, kartu ID digital.

---

## 👥 4 Aktor & Fitur Inti

### 1. Siswa (Student)
- **Komponen Utama:** `SiswaDashboard.vue`, `SiswaLogbook.vue`, `SiswaPresensi.vue`, `SiswaPenempatan.vue`, `DigitalIdCardModal.vue`.
- **Fitur Utama:**
  - **Presensi GPS Geofencing (Tap In / Tap Out):**
    - Mode: **WFO** (validasi radius 150m ke kantor via rumus Haversine), **WFH** (pengajuan jadwal WFH), **WFA** (tugas luar/liputan).
    - Jam kerja dinamis diambil dari jadwal instansi/perusahaan (`work_start_time`, `work_end_time`, `work_days`).
  - **Pengajuan Mode Kerja (Work Mode Requests):**
    - Siswa dapat mengajukan izin WFH/WFA dengan alasan dan tanggal spesifik untuk disetujui Mentor.
  - **Logbook STAR Harian:**
    - Format STAR: *Situation, Task, Action, Result*.
    - Upload foto dokumentasi dengan kompresi otomatis client-side HTML5 Canvas.
    - Riwayat logbook mingguan dengan badge status (*Menunggu, Di-ACC, Revisi*) dan catatan mentor.
  - **Digital ID Card (Kartu Magang Digital):**
    - Modal interaktif menampilkan kartu magang resmi SMKN 71 dengan foto, NIS, jurusan, nama PT, tanggal periode, QR Code verifikasi, dan tombol Print/Unduh.
  - **Riwayat Presensi:** Tampilan Kalender & List view.

### 2. Pembimbing Lapangan / DUDI (Mentor)
- **Komponen Utama:** `DudiDashboard.vue`, `DudiValidasi.vue`, `DudiPresensi.vue`, `DudiEvaluasi.vue`.
- **Fitur Utama:**
  - **Validasi Jurnal (Split-Screen):**
    - Panel Kiri: Daftar siswa aktif & counter jurnal menunggu verifikasi.
    - Panel Kanan: Isi logbook, foto kegiatan, tombol **ACC (Setujui)** atau **Tolak/Minta Revisi** dengan catatan umpan balik.
  - **Presensi & Jam Kantor:**
    - Rekapitulasi jam masuk/pulang siswa, jarak geofence, status tepat waktu / terlambat.
    - Pengaturan jam kerja kantor (`work_start_time`, `work_end_time`) dan persetujuan pengajuan mode kerja (WFH/WFA).
  - **Evaluasi Nilai & Sertifikat QR:**
    - Rubrik penilaian 4 aspek: Kedisiplinan & Etos Kerja, Keahlian Teknis, Kerjasama Tim, dan Inisiatif.
    - Generate sertifikat digital resmi dengan QR Code Canvas/SVG terverifikasi.

### 3. Guru Pembimbing (Teacher)
- **Komponen Utama:** `GuruDashboard.vue`, `GuruMonitoring.vue`, `GuruNilai.vue`.
- **Fitur Utama:**
  - **Pengelompokan Berdasarkan Mitra Industri (PT):**
    - Filter tab instan per instansi (misal: PT Telkom Digital Solusi, Studio Animasi Kinetik, Pixel Kreatif).
  - **Peringatan Sistem Kritis (Red Alert):**
    - Otomatis mendeteksi siswa binaan yang tidak presensi atau tidak mengisi logbook selama >3 hari berturut-turut.
    - Tombol cepat langsung hubungi siswa atau mentor via WhatsApp.
  - **Monitoring Jurnal & Kehadiran:** Read-only timeline kronologis jurnal siswa.
  - **Kompilasi Nilai Akhir:**
    - Rekap otomatis nilai dari Mentor Lapangan + form input nilai Laporan Sekolah = Nilai Akhir PKL.

### 4. Admin / Kaprog (Administrator)
- **Komponen Utama:** `AdminDashboard.vue`, `AdminDataMaster.vue`, `AdminPlotting.vue`, `AdminDiagramRelasi.vue`, `AdminLaporan.vue`.
- **Fitur Utama:**
  - **Dashboard Makro:** Statistik agregat siswa, tempat magang, guru, utilisasi kuota, status konektivitas online.
  - **Diagram Relasi PKL Interaktif (Topologi & ERD):**
    - Mode Alur Penempatan: Visualisasi pipeline real-time (Siswa -> DUDI -> Mentor -> Guru) dengan filter jurusan, pencarian, dan node detail.
    - Mode Skema ERD: Visualisasi relasi 6 entitas basis data dengan foreign key, cardinalities (1:N, M:N), dan export SVG diagram.
  - **Data Master All-in-One Quick Enrollment:**
    - CRUD Siswa, Tempat Magang, Pembimbing Lapangan, Guru Pembimbing.
    - Pendaftaran siswa baru langsung memilih atau **menambahkan tempat magang baru secara inline** di satu modal tanpa keluar halaman.
    - Import data via Excel / CSV.
  - **Plotting Penempatan Dual-Panel:**
    - Panel Kiri: Pilih siswa.
    - Panel Kanan: Pilih instansi, mentor, guru, tentukan tanggal mulai & selesai, simpan penempatan.
  - **Laporan & Cetak Buku Jurnal Cetak:**
    - Pratinjau format resmi Kop Dinas Pendidikan DKI Jakarta.
    - Export ke PDF dan Excel.

---

## 💾 Struktur Database & File Data

1. **`backend/database/database.sqlite`**:
   - File database SQLite siap pakai (*pre-seeded*) yang berisi seluruh tabel, relasi, dan data dummy realistis (akun siswa, guru, mentor, admin, presensi 10+ hari, logbook, nilai).
2. **`backend/database/database.sql`**:
   - Dump SQL lengkap untuk migrasi ke MySQL / MariaDB (Laragon, XAMPP, phpMyAdmin).
3. **Seeders:**
   - `backend/database/seeders/DatabaseSeeder.php`: Membangun ulang seluruh skema, data user, company, placement, attendance, logbook, grade, schedule, dan mock request.
4. **Tabel-Tabel Kunci:**
   - `users`: id, name, email, password, role (`siswa`, `dudi`, `guru`, `admin`), nis, nip, phone, avatar, department (`PPLG`, `Animasi`, `DKV`).
   - `companies`: id, name, address, latitude, longitude, radius_meters, work_start_time, work_end_time, work_days.
   - `placements`: id, student_id, company_id, mentor_id, teacher_id, start_date, end_date, status.
   - `attendances`: id, student_id, date, check_in, check_out, status, work_mode, latitude, longitude, distance_meters, is_within_radius, notes.
   - `logbooks`: id, student_id, date, title, situation, task, action, result, photo_url, status (`pending`, `approved`, `revision`), mentor_note.
   - `grades`: id, student_id, placement_id, mentor_score_discipline, mentor_score_technical, mentor_score_teamwork, mentor_score_initiative, mentor_score_total, mentor_predicate, school_report_score, final_score, qr_code_hash.
   - `work_mode_requests`: id, student_id, company_id, requested_mode, date, reason, status (`pending`, `approved`, `rejected`), mentor_notes.

---

## 🔑 Kredensial Akun Pengujian (Semua Password: `12345678`)

| Peran | Email | Nama | Perusahaan / Departemen |
|---|---|---|---|
| **Siswa** | `siswa@gmail.com` | Budi Santoso | PT Telkom Digital Solusi (PPLG) |
| **Pembimbing Lapangan** | `mentor@gmail.com` | Hendra Wijaya, S.Kom | PT Telkom Digital Solusi |
| **Guru Pembimbing** | `guru@gmail.com` | Dra. Nurul Hidayah, M.Pd | Pembimbing Jurusan RPL/PPLG |
| **Admin / Kaprog** | `admin@gmail.com` | Ir. Bambang Hermanto, M.T | Kaprog PPLG SMKN 71 Jakarta |

*Catatan: Pada UI aplikasi, terdapat juga **Role Switcher** di bagian paling atas Sidebar Kiri untuk berpindah peran secara instan.*

---

## 📋 Protokol Analisis Antigravity AI (Saat User Meminta "Analisis Project")

Ketika user berpindah device dan memberikan perintah seperti **"analisis project ini"**, **"cek kondisi project"**, atau **"apa saja yang harus dilakukan"**, Antigravity AI harus melakukan tahapan berikut:

### Langkah 1: Pengecekan Lingkungan & Servis
Jalankan verifikasi status:
- Cek file konfigurasi `.env` di `backend/.env` dan `frontend/.env`. Jika belum ada, buat dari `.env.example`.
- Cek kesiapan database `backend/database/database.sqlite`.
- Cek ketersediaan dependencies (`vendor` di backend, `node_modules` di frontend).

### Langkah 2: Laporan Ringkasan Eksekutif
Sajikan laporan dengan format terstruktur:
1. **Status Kesehatan Proyek:** Kesiapan backend (PHP/Laravel) & frontend (Nuxt 3/Node).
2. **Fitur yang Sudah Selesai & Berfungsi 100%:**
   - Siswa: Presensi GPS Haversine, Logbook STAR, Digital ID Card, WFH Request.
   - Mentor: Validasi Split-Screen, Jam Kantor & Approval WFH, Evaluasi & QR Sertifikat.
   - Guru: Tab filter per PT, Red Alert >3 hari, Kompilasi Nilai.
   - Admin: All-in-One Quick Enrollment, Dual-panel Plotting, Cetak Laporan Kop Dinas.
3. **Rekomendasi Langkah Selanjutnya (Roadmap):**
   - Penambahan fitur ekspor rekap PDF presensi per bulan.
   - Penambahan web push notification / service worker PWA offline.
   - Integrasi WhatsApp Webhook / Telegram Bot untuk notifikasi Red Alert otomatis ke nomor HP guru & orang tua.
   - Peningkatan unit test backend (`php artisan test`) dan end-to-end frontend.
4. **Panduan Perintah Cepat:**
   - Jalankan backend: `cd backend; php artisan serve`
   - Jalankan frontend: `cd frontend; npm run dev`

---

## 🚀 Perintah Operasional Penting

```powershell
# Inisialisasi Backend pertama kali di device baru:
cd backend
if (!(Test-Path .env)) { copy .env.example .env }
php artisan key:generate
php artisan serve --port=8000

# Inisialisasi Frontend di device baru:
cd frontend
if (!(Test-Path .env)) { copy .env.example .env }
npm install
npm run dev

# Reset Database ke data awal lengkap jika diperlukan:
cd backend
php artisan migrate:fresh --seed
```
