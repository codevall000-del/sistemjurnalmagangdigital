# AGENTS.md — Antigravity & AI Assistant Project Instructions

Selamat datang di repositori **EduAccess (Sistem Jurnal & Presensi Magang PKL Digital SMKN 71 Jakarta)**.
File ini adalah instruksi operasional untuk Antigravity AI dan AI assistant lainnya saat membuka atau menganalisis project ini di komputer/device mana pun.

---

## 📌 Ringkasan Eksekutif Proyek
- **Domain:** Sistem Informasi Jurnal & Presensi PKL Digital SMKN 71 Jakarta (Jurusan PPLG, DKV, Animasi).
- **Tech Stack:**
  - **Backend:** Laravel 11/12 REST API, Laravel Sanctum, SQLite (default & pre-seeded) / MySQL.
  - **Frontend:** Nuxt 3 (Vue 3, TypeScript, Tailwind CSS, Desktop SPA Layout, Pinia/State via `frontend/composables/useAppStore.ts`).
- **Data Kunci:**
  - Database bawaan siap pakai langsung ada di `backend/database/database.sqlite` (pre-seeded).
  - Dump SQL MySQL ada di `backend/database/database.sql`.
  - Seeder komprehensif ada di `backend/database/seeders/DatabaseSeeder.php`.

---

## 👥 4 Aktor Utama & Kredensial Uji Coba

Semua akun menggunakan password: **`12345678`**

| Aktor | Email | Nama | Instansi / Jurusan | Fitur Utama |
|---|---|---|---|---|
| **Siswa** | `siswa@gmail.com` | Budi Santoso | PT Telkom Digital Solusi (PPLG) | Tap In/Out GPS Geofence (Haversine), Jurnal STAR + Kompresi Foto, Pengajuan Mode Kerja (WFH/WFA), Digital ID Card |
| **Pembimbing Lapangan (Mentor)** | `mentor@gmail.com` | Hendra Wijaya, S.Kom | PT Telkom Digital Solusi | Split-screen validasi jurnal (ACC/Revisi), Rekap presensi, Jam kantor & approval WFH, Evaluasi 4 aspek & QR Sertifikat |
| **Guru Pembimbing** | `guru@gmail.com` | Dra. Nurul Hidayah, M.Pd | Pembimbing RPL/PPLG | Tab filter per PT Mitra, Red Alert (>3 hari alfa/tanpa jurnal), Action WhatsApp, Kompilasi nilai akhir |
| **Admin / Kaprog** | `admin@gmail.com` | Ir. Bambang Hermanto, M.T | Kaprog PPLG | Macro statistics, All-in-One Quick Enrollment, Plotting dual-panel, Diagram Relasi Interaktif (Alur Penempatan & ERD Skema), Cetak buku jurnal format Dinas |

> *Tips UI: Terdapat juga **Role Switcher** di bagian paling atas Sidebar Kiri untuk berganti peran secara instan tanpa perlu logout/login manual.*

---

## 🔍 Protokol Analisis (Saat User Meminta "Analisis Project")

Jika pengguna meminta:
- *"analisis project"*
- *"apa yang harus dilakukan"*
- *"cek status project ini"*
- *"lanjutkan project"*

Maka lakukan hal berikut secara berurutan:
1. **Verifikasi Lingkungan:**
   - Cek apakah `backend/.env` dan `frontend/.env` sudah ada. Jika belum, pandu untuk menyalin dari `.env.example`.
   - Cek koneksi ke database SQLite `backend/database/database.sqlite`.
2. **Audit Fitur:**
   - Periksa 4 modul aktor (Siswa, Mentor, Guru, Admin).
   - Validasi bahwa seluruh endpoint REST API (54+ endpoint di `backend/routes/api.php`) dan antarmuka Nuxt 3 berfungsi sinkron.
3. **Sajikan Laporan Lengkap:**
   - **Kondisi Sistem:** Status backend (Laravel), frontend (Nuxt 3), dan database SQLite.
   - **Fitur Siap Pakai:** Rincian modul per aktor, termasuk fitur terbaru: Diagram Relasi Penempatan & ERD Skema (`AdminDiagramRelasi.vue`) serta Presensi Selfie Kamera & Live Geofencing (`SiswaPresensi.vue`).
   - **Rekomendasi Roadmap / Langkah Selanjutnya:**
     - 1. **Export PDF Rekap Presensi:** Export rekap kehadiran bulanan per siswa ke format PDF siap cetak.
     - 2. **PWA & Offline Service Worker:** Fitur PWA agar bisa diinstall di HP siswa seperti native app dengan kemampuan offline logging.
     - 3. **Notifikasi WhatsApp Otomatis:** Integrasi WhatsApp Gateway / Webhook untuk trigger Red Alert (>3 hari alfa/tanpa jurnal) langsung ke WA Guru & Wali.
     - 4. **Testing Suite:** Menambahkan test otomatis `php artisan test` untuk controller kunci dan validasi role Sanctum.
   - **Perintah Menjalankan:** Panduan satu baris untuk start backend dan frontend.

---

## 🛠️ Perintah Standar Menjalankan Aplikasi

### Menjalankan Backend:
```powershell
cd backend
if (!(Test-Path .env)) { copy .env.example .env }
php artisan key:generate
php artisan serve --port=8000
```

### Menjalankan Frontend:
```powershell
cd frontend
if (!(Test-Path .env)) { copy .env.example .env }
npm install
npm run dev
```

---

## 🎨 Panduan Desain & UX
- Mengadopsi prinsip fluid interaktif dari skill `.agent/skills/apple-design/SKILL.md`:
  - Respon instan pada pointer-down.
  - Feedback visual transparan dan micro-animations halus.
  - Transisi modal interruptible dan tata letak desktop yang kokoh.
