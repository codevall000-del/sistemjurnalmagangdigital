# Dokumentasi Komprehensif: Sistem Jurnal Magang Digital (EduAccess)

Dokumen ini adalah referensi teknis lengkap bagi developer dan AI Assistant (Antigravity AI) untuk memahami seluruh arsitektur, basis data, endpoint API, dan roadmap proyek.

---

## 🏗️ Arsitektur Sistem

```
┌────────────────────────────────────────────────────────────────────────┐
│                   Nuxt 3 Frontend (Desktop SPA UI)                    │
│   - Vue 3 + TypeScript + Tailwind CSS                                  │
│   - Reactive State & Offline Sync via useAppStore.ts                   │
│   - Responsive Desktop Shell (DesktopSidebar + Dynamic Workspaces)     │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ REST API (JSON / Multipart)
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                 Laravel 11 REST API Backend (Port 8000)                │
│   - Controllers: Siswa, Mentor (Dudi), Guru, Admin, Auth               │
│   - Auth: Laravel Sanctum Bearer Token & Session Stateful              │
│   - Business Rules: Haversine GPS Geofence (150m), Rubrik Penilaian    │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ PDO SQLite / MySQL
                                    ▼
┌────────────────────────────────────────────────────────────────────────┐
│                   Database Layer (Pre-seeded Ready)                    │
│   - backend/database/database.sqlite (Utama, Langsung jalan)           │
│   - backend/database/database.sql (Dump SQL untuk MySQL/MariaDB)       │
└────────────────────────────────────────────────────────────────────────┘
```

---

## 🗄️ Skema Database & Relasi Model

1. **`users`**:
   - `id`, `name`, `email`, `password`, `role` (`siswa`, `dudi`, `guru`, `admin`), `nis`, `nip`, `phone`, `avatar`, `department` (`PPLG`, `Animasi`, `DKV`).
2. **`companies`**:
   - `id`, `name`, `address`, `latitude`, `longitude`, `radius_meters` (default 150), `work_start_time` (contoh: 08:00), `work_end_time` (contoh: 17:00), `work_days` (contoh: "Senin - Jumat").
3. **`placements`**:
   - Menghubungkan `student_id` (User) dengan `company_id` (Company), `mentor_id` (User Dudi), dan `teacher_id` (User Guru).
   - Relasi:
     - `student()` -> `User`
     - `mentor()` -> `User`
     - `teacher()` -> `User`
     - `company()` -> `Company`
4. **`attendances`**:
   - `student_id`, `date`, `check_in`, `check_out`, `status` (`hadir`, `terlambat`, `izin`, `sakit`, `alfa`), `work_mode` (`wfo`, `wfh`, `wfa`), `latitude`, `longitude`, `distance_meters`, `is_within_radius`, `notes`.
5. **`logbooks`**:
   - `student_id`, `date`, `title`, `situation`, `task`, `action`, `result` (Metode STAR), `photo_url`, `status` (`pending`, `approved`, `revision`), `mentor_note`.
6. **`grades`**:
   - `student_id`, `placement_id`, 4 aspek nilai mentor (`mentor_score_discipline`, `mentor_score_technical`, `mentor_score_teamwork`, `mentor_score_initiative`), `mentor_score_total`, `mentor_predicate`, `school_report_score`, `final_score`, `qr_code_hash`.
7. **`work_mode_requests`**:
   - `student_id`, `company_id`, `requested_mode` (`wfh`, `wfa`), `date`, `reason`, `status` (`pending`, `approved`, `rejected`), `mentor_notes`.

---

## 🔌 Rangkuman REST API Endpoint (`backend/routes/api.php`)

### Autentikasi (`/api/auth/*`):
- `POST /api/auth/login` — Login pengguna dan perolehan token Sanctum
- `POST /api/auth/logout` — Logout dan revocasi token
- `GET /api/auth/me` — Profil pengguna aktif
- `PUT /api/auth/change-password` — Mengubah kata sandi

### Modul Siswa (`/api/siswa/*`):
- `GET /api/siswa/dashboard` — Ringkasan hero widget, status presensi hari ini, persentase kehadiran, sisa hari
- `POST /api/siswa/presensi/check-in` — Check-in dengan validasi koordinat GPS Haversine
- `POST /api/siswa/presensi/check-out` — Check-out harian
- `GET /api/siswa/presensi/history` — Riwayat presensi (mendukung filter bulan & tahun)
- `GET /api/siswa/logbook` — Daftar jurnal siswa mingguan/bulanan
- `POST /api/siswa/logbook` — Simpan jurnal baru metode STAR + upload foto
- `GET /api/siswa/penempatan` — Detail tempat magang, pembimbing lapangan, dan guru
- `POST /api/siswa/work-mode-request` — Pengajuan izin mode kerja WFH/WFA

### Modul Pembimbing Lapangan / DUDI (`/api/mentor/*` & `/api/dudi/*`):
- `GET /api/mentor/dashboard` — Daftar siswa magang aktif & counter jurnal menunggu validasi
- `GET /api/mentor/logbooks` — Logbook siswa binaan untuk antarmuka validasi split-screen
- `PUT /api/mentor/logbooks/{id}/status` — Setujui (ACC) atau tolak/minta revisi logbook + catatan umpan balik
- `GET /api/mentor/presensi` — Rekap kehadiran seluruh siswa di instansi terkait
- `PUT /api/mentor/schedule` — Pengaturan jam kerja kantor dan radius toleransi
- `GET /api/mentor/work-mode-requests` — Daftar pengajuan mode kerja WFH/WFA siswa
- `PUT /api/mentor/work-mode-requests/{id}` — Setujui/tolak pengajuan mode kerja
- `POST /api/mentor/grades` — Simpan penilaian 4 aspek & generate hash sertifikat QR

### Modul Guru Pembimbing (`/api/guru/*`):
- `GET /api/guru/dashboard` — Statistik siswa binaan, tab filter per PT industri, dan deteksi **Red Alert** (>3 hari tidak aktif)
- `GET /api/guru/monitoring` — Monitoring berjenjang per PT -> Siswa -> Logbook timeline
- `GET /api/guru/grades` — Rekap nilai pembimbing lapangan
- `PUT /api/guru/grades/{id}` — Input nilai laporan sekolah & kalkulasi nilai akhir PKL

### Modul Admin / Kaprog (`/api/admin/*`):
- `GET /api/admin/dashboard` — Statistik makro & status sinkronisasi
- `GET|POST|PUT|DELETE /api/admin/students` — CRUD Siswa (mendukung inline tambah instansi baru)
- `GET|POST|PUT|DELETE /api/admin/companies` — CRUD Tempat Magang / Instansi
- `GET|POST|PUT|DELETE /api/admin/mentors` — CRUD Pembimbing Lapangan
- `GET|POST|PUT|DELETE /api/admin/teachers` — CRUD Guru Pembimbing
- `POST /api/admin/import/excel` — Import data massal dari file Excel/CSV
- `GET|POST /api/admin/placements` — Plotting penempatan siswa dual-panel
- `GET /api/admin/reports` — Laporan rekap cetak buku jurnal standar Dinas Pendidikan

---

## 💻 Panduan Onboarding di Device Baru

Saat Anda memindahkan proyek ini ke laptop atau PC baru:

1. **Clone repositori dari GitHub:**
   ```powershell
   git clone https://github.com/codevall000-del/sistemjurnalmagangdigital.git
   cd sistemjurnalmagangdigital
   ```

2. **Jalankan Antigravity AI:**
   - Cukup ketik perintah ke Antigravity AI:
     > *"Tolong analisis project ini dan beri tahu apa saja yang harus dilakukan"*
   - Antigravity AI akan otomatis membaca `AGENTS.md` dan skill `.agent/skills/jurnal-magang-project/SKILL.md` untuk memverifikasi seluruh komponen dan memandu Anda langkah demi langkah.

3. **Inisialisasi Cepat (Manual):**
   ```powershell
   # Terminal 1 - Backend:
   cd backend
   composer install
   copy .env.example .env
   php artisan key:generate
   php artisan serve --port=8000

   # Terminal 2 - Frontend:
   cd frontend
   npm install
   copy .env.example .env
   npm run dev
   ```

Aplikasi langsung siap dibuka di browser di: `http://localhost:3000`
