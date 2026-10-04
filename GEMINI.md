# GEMINI.md — Antigravity & AI Assistant Project Instructions

Lihat juga panduan lengkap di [`AGENTS.md`](file:///c:/Users/Assyifa%20Odellia/OneDrive/Documents/10.Favian/1.Coding/JurnalMagangDigital/AGENTS.md) dan skill di [`.agent/skills/jurnal-magang-project/SKILL.md`](file:///c:/Users/Assyifa%20Odellia/OneDrive/Documents/10.Favian/1.Coding/JurnalMagangDigital/.agent/skills/jurnal-magang-project/SKILL.md).

## 📌 Ringkasan Eksekutif Proyek
- **Aplikasi:** EduAccess — Sistem Informasi Jurnal & Presensi PKL Digital SMKN 71 Jakarta.
- **Stack:** Fullstack Laravel 11 REST API (`/api/*`) + Nuxt 3 (Vue 3, Tailwind CSS, Desktop SPA Layout).
- **Aktor:** Siswa, Pembimbing Lapangan (Mentor), Guru Pembimbing, Admin/Kaprog.
- **Data Siap Pakai:** `backend/database/database.sqlite` (pre-seeded lengkap).
- **Akun Uji Coba (Semua password: `12345678`):**
  - Siswa: `siswa@gmail.com`
  - Mentor Lapangan: `mentor@gmail.com`
  - Guru Pembimbing: `guru@gmail.com`
  - Admin / Kaprog: `admin@gmail.com`

## 🔍 Perintah Utama: "Perform" (atau "Analisis Project" / "Lanjutkan Project")
Saat user mengetik **`Perform`**:
1. Jalankan verifikasi backend (port 8000), frontend (port 3000), dan database SQLite `backend/database/database.sqlite`.
2. Laporkan status fitur per 4 aktor (Siswa, Mentor, Guru, Admin).
3. Langsung sajikan langkah konkret roadmap berikutnya yang siap dieksekusi.

## 🌟 Fitur Unggulan Terkini (Sudah Selesai):
- **Admin Diagram Relasi PKL (`AdminDiagramRelasi.vue`):** Topologi visual interaktif alur penempatan (Siswa -> DUDI -> Mentor -> Guru) & visualisasi Skema ERD basis data lengkap dengan cardinalities dan export SVG.
- **Siswa Presensi Pintar (`SiswaPresensi.vue`):** Live Geofencing GPS (Haversine Formula), auto camera selfie capture, simulasi bypass mode demo, dan validasi radius kantor.
- **Mentor Split-Screen Review (`DudiValidasi.vue`):** Validasi ACC/Revisi jurnal STAR dengan photo viewer.
- **Guru Red Alert Monitoring (`GuruMonitoring.vue`):** Deteksi otomatis siswa >3 hari alfa/tanpa jurnal + direct WhatsApp.
- **All-in-One Quick Enrollment (`AdminDataMaster.vue`):** Tambah siswa langsung buat mitra PT inline dalam 1 klik.

## 🎯 Rencana Pengembangan Selanjutnya (Next Steps / Roadmap):
1. **Export PDF Rekap Presensi & Jurnal:** Menyediakan tombol unduh laporan presensi bulanan berformat PDF resmi per siswa / per DUDI.
2. **Offline Support & PWA Service Worker:** Dukungan mode offline saat siswa tidak ada koneksi internet di lokasi PKL.
3. **Notifikasi Otomatis (WhatsApp Gateway / Webhook):** Integrasi pesan WhatsApp langsung untuk Red Alert guru dan reminder tap out siswa.
4. **Unit & Feature Testing:** Pembuatan test suite otomatis menggunakan `php artisan test`.

## ⚡ Panduan Cepat Menjalankan di Komputer Baru:
```powershell
# Terminal 1 - Backend
cd backend
if (!(Test-Path .env)) { copy .env.example .env }
php artisan key:generate
php artisan serve --port=8000

# Terminal 2 - Frontend
cd frontend
if (!(Test-Path .env)) { copy .env.example .env }
npm install
npm run dev
```
