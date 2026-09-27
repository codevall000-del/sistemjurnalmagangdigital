# Jurnal Magang Digital (Sistem Informasi PKL Desktop-Style)

Aplikasi web modern berskala desktop enterprise untuk **Jurnal Magang / Praktik Kerja Lapangan (PKL) Digital** yang dibangun dengan arsitektur **Fullstack Laravel 11/12 (Backend REST API) & Nuxt 3 (Frontend Vue 3 + Tailwind CSS)**.

Aplikasi ini mengadopsi standar tata letak desktop optimal:
- **Navbar (Sidebar Kiri):** Pusat navigasi menu & area komponen global statis di bagian bawah.
- **View (Area Konten Kanan):** Tempat menampilkan data, analitik grafik, antarmuka split-screen, dan form interaktif sesuai aktor yang sedang aktif.

---

## 🚀 Fitur & Modul Sesuai Spesifikasi

### 1. Modul Siswa
- **Dashboard Siswa:**
  - Tombol raksasa **Check-In** dan **Check-Out** dengan geotagging dan status waktu real-time.
  - Widget circular gauge **Persentase Kehadiran** (misal: 96.4% kehadiran).
  - Widget countdown **Sisa Waktu Magang** (misal: 64 hari lagi hingga 27 November 2026).
  - Daftar **Notifikasi Terbaru** (misal peringatan revisi dari pembimbing industri).
- **Logbook Harian (Split Top/Bottom Layout):**
  - **Bagian Atas:** Form input jurnal baru (tanggal, judul, deskripsi kegiatan, upload foto dengan kompresi client-side HTML5 Canvas otomatis, tombol Simpan).
  - **Bagian Bawah:** Tabel riwayat jurnal minggu ini lengkap dengan badge status (*Menunggu, Di-ACC, Revisi*) dan catatan umpan balik DUDI.
- **Riwayat Presensi:**
  - Switcher dua mode: **Tampilan Kalender (Calendar View)** dan **Daftar Rinci (List View)** memuat rekam jejak jam Check-In dan Check-Out harian.
- **Informasi Penempatan:**
  - Profil detail perusahaan tempat magang (nama, bidang/sektor, alamat kantor, telepon, website resmi).
  - Kontak Pembimbing Industri (DUDI) dilengkapi tombol langsung WhatsApp/Email.
  - Kontak Guru Pembimbing Sekolah dilengkapi tombol konsultasi.

### 2. Modul Pembimbing Industri (DUDI)
- **Dashboard DUDI:**
  - Daftar kartu (*card*) siswa aktif magang di perusahaan.
  - Indikator badge mencolok jumlah jurnal yang menunggu untuk divalidasi.
  - Indikator tingkat kedisiplinan dan aktivitas terakhir setiap siswa.
- **Validasi Jurnal (Antarmuka Belah / Split-Screen):**
  - **Panel Kiri:** Daftar nama siswa dengan pencarian cepat dan counter jurnal baru.
  - **Panel Kanan:** Isi detail jurnal harian siswa terpilih, foto dokumentasi hasil pekerjaan, tombol aksi `ACC (Setujui Jurnal)` atau `Tolak / Minta Revisi` lengkap dengan kolom input catatan umpan balik (*feedback note*).
- **Presensi Siswa:**
  - Tabel rekapitulasi kehadiran seluruh siswa di perusahaan tersebut untuk kontrol kedisiplinan (Check-In, Check-Out, durasi kerja, status tepat waktu/terlambat, dan geotagging).
- **Evaluasi & Penilaian:**
  - Form rubrik penilaian 4 aspek: Kedisiplinan & Etos Kerja, Keahlian Teknis, Kerjasama Tim, dan Inisiatif.
  - Kalkulasi otomatis nilai rata-rata DUDI dan predikat mutu industri (A/B/C).
  - Tombol **`Finalisasi Nilai & Generate QR Code`** yang menerbitkan sertifikat digital terverifikasi dengan barcode QR Code asli (Canvas/SVG).

### 3. Modul Guru Pembimbing
- **Dashboard Guru:**
  - Grafik keaktifan komparasi seluruh siswa binaannya (kehadiran vs pengisian jurnal).
  - **Peringatan Sistem Kritis (Red Alert):** Otomatis mendeteksi dan memperingatkan guru jika ada siswa yang tidak mengisi presensi maupun jurnal selama lebih dari 3 hari berturut-turut, disertai tombol hubungi siswa/perusahaan segera.
- **Monitoring Jurnal & Kehadiran (Read-Only):**
  - Filter pencarian instan berdasarkan nama siswa atau NISN.
  - *Timeline* kronologis seluruh jurnal siswa secara *read-only* lengkap dengan status apakah sudah di-ACC oleh DUDI atau belum.
- **Manajemen Nilai:**
  - Tabel kompilasi: Nilai dari DUDI (otomatis terisi dari input DUDI dan terverifikasi QR), kolom input manual untuk Nilai Laporan Sekolah, dan kalkulasi otomatis Nilai Akhir PKL dengan rumus:
    $$\text{Nilai Akhir} = (60\% \times \text{Nilai DUDI}) + (40\% \times \text{Nilai Sekolah})$$

### 4. Modul Admin / Kaprog
- **Dashboard Admin:**
  - Statistik level makro: Total siswa terdaftar, total mitra DUDI, total guru pembimbing, dan total jurnal terverifikasi.
  - Grafik penyebaran dan utilisasi kuota siswa di berbagai mitra industri.
  - Panel **Status Sinkronisasi Server Pusat** (status koneksi, latensi, SQLite WAL mode, kapasitas storage).
- **Data Master:**
  - Submenu Tabs/Dropdown untuk **Siswa**, **DUDI / Industri**, dan **Guru Pembimbing**.
  - Tabel CRUD (Create, Read, Update, Delete) lengkap dengan modal tambah/edit dan live search real-time.
  - Tombol **`Import dari Excel (Template disediakan)`** dengan simulasi impor data massal dan unduh template resmi.
- **Plotting / Penempatan (Panel Ganda / Dual-Panel):**
  - **Panel Kiri:** Pilih nama siswa yang akan diplot.
  - **Panel Kanan:** Pilih mitra industri, pilih pembimbing DUDI, pilih guru pembimbing, tetapkan tanggal mulai & selesai magang, lalu klik tombol **`Tetapkan Penempatan`**.
- **Laporan & Arsip:**
  - Panel filter lengkap: Filter Tahun Ajaran, Filter Angkatan, Filter Mitra DUDI, dan Filter Status Nilai.
  - **Pratinjau Buku Jurnal Cetak:** Pratinjau berkas cetak resmi dengan Kop Surat Dinas Pendidikan, tabel rekapitulasi nilai komprehensif, dan lembar pengesahan tanda tangan Kepala Sekolah & Kaprog.
  - Tombol **`Export to PDF`** dan **`Export to Excel (CSV)`**.

---

### 🌐 Komponen Global (Wajib Ada di Semua Aktor - Bagian Bawah Navbar)
- **Indikator Jaringan (Khusus Desktop):**
  - Ikon sinyal berwarna **Hijau (Online & Sinkron)** atau **Kuning/Merah (Offline, menyimpan data di lokal)**.
  - Tombol kecil **`Sinkronisasi Sekarang`** dengan animasi proses sinkronisasi real-time.
  - Mendukung klik langsung pada indikator jaringan di header atas untuk mensimulasikan perpindahan mode Offline & Online.
- **Mini Profil:**
  - Foto avatar, nama lengkap pengguna, dan label peran dinamis (misal: "Budi - Siswa", "Hendra - Pembimbing DUDI", "Nurul - Guru Pembimbing", "Bambang - Admin / Kaprog").
- **Pengaturan Akun (Settings):**
  - Dialog modal interaktif untuk mengganti kata sandi (password).
- **Tombol Keluar (Logout):**
  - Pengakhiran sesi dengan konfirmasi toast feedback.

---

## 📁 Struktur Direktori

```
Industri/
├── backend/                  # Laravel 11/12 REST API
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── SiswaController.php
│   │   │   ├── DudiController.php
│   │   │   ├── GuruController.php
│   │   │   └── AdminController.php
│   │   └── Models/          # User, Company, Placement, Attendance, Logbook, Grade, Notification
│   ├── database/
│   │   ├── migrations/      # Skema database SQLite / MySQL lengkap
│   │   └── seeders/         # Data realistis untuk 4 aktor, DUDI, presensi & jurnal
│   └── routes/api.php       # 33 endpoint REST API terlindungi Sanctum
│
├── frontend/                 # Nuxt 3 Desktop Application
│   ├── app.vue               # Main desktop shell (Left Navbar + Right View)
│   ├── components/
│   │   ├── DesktopSidebar.vue       # Navbar Sidebar Kiri & Global Bottom Section
│   │   ├── SettingsModal.vue        # Modal Ubah Password
│   │   ├── SiswaDashboard.vue       # Tombol raksasa Check-In/Out & widgets
│   │   ├── SiswaLogbook.vue         # Split view input form + weekly table
│   │   ├── SiswaPresensi.vue        # Kalender & list jam check-in/out
│   │   ├── SiswaPenempatan.vue      # Profil DUDI, kontak mentor & guru
│   │   ├── DudiDashboard.vue        # Card siswa aktif & pending counter
│   │   ├── DudiValidasi.vue         # Split-screen review jurnal & ACC/Tolak
│   │   ├── DudiPresensi.vue         # Matriks kedisiplinan siswa
│   │   ├── DudiEvaluasi.vue         # Rubrik nilai & generator QR Code
│   │   ├── GuruDashboard.vue        # Grafik keaktifan & Red Alert (>3 hari)
│   │   ├── GuruMonitoring.vue       # Search filter + read-only timeline
│   │   ├── GuruNilai.vue            # Tabel kompilasi nilai DUDI + Sekolah
│   │   ├── AdminDashboard.vue       # Statistik makro & status sinkronisasi
│   │   ├── AdminDataMaster.vue      # CRUD Siswa, DUDI, Guru + Excel Import
│   │   ├── AdminPlotting.vue        # Dual-panel penjodohan penempatan
│   │   └── AdminLaporan.vue         # Filter panel, cetak buku jurnal, PDF & Excel
│   ├── composables/
│   │   └── useAppStore.ts           # State reactive untuk peran aktor, menu, dan offline sync
│   └── tailwind.config.js
```

---

## 🛠️ Panduan Menjalankan Aplikasi

### 1. Menjalankan Backend (Laravel API)
Database bawaan sudah disediakan dalam 2 format:
- **`backend/database/database.sqlite`**: Sudah terisi data lengkap (*pre-seeded*), langsung bisa digunakan tanpa konfigurasi tambahan!
- **`backend/database/database.sql`**: Dump SQL lengkap jika ingin di-import ke MySQL / phpMyAdmin / Laragon.
- Jika ingin me-reset ulang database dari awal:
  ```powershell
  cd backend
  php artisan migrate:fresh --seed
  ```

Jalankan server backend:
```powershell
cd backend
php artisan serve --host=127.0.0.1 --port=8000
```
Backend akan aktif di `http://127.0.0.1:8000` dengan endpoint REST API di `/api/*`.

### 2. Menjalankan Frontend (Nuxt 3)
```powershell
cd frontend
npm run dev
```
Atau untuk menjalankan build produksi:
```powershell
node .output/server/index.mjs
```
Aplikasi web desktop dapat dibuka di peramban pada alamat `http://localhost:3000`.

---

## 🔑 Akun Demo untuk Pengujian Cepat

Pada bagian paling atas Sidebar Kiri, terdapat **Simulasi Aktor Switcher** yang memungkinkan penguji berganti peran secara instan (Siswa, DUDI, Guru, Admin) dengan 1 kali klik. Anda juga dapat login manual menggunakan akun berikut:

| Aktor | Email | Password | Keterangan |
|---|---|---|---|
| **Siswa** | `siswa@magang.id` | `password` | Budi Santoso (PT Telkom Digital Solusi) |
| **DUDI** | `dudi@magang.id` | `password` | Hendra Wijaya, S.Kom (Tech Lead Telkom) |
| **Guru** | `guru@magang.id` | `password` | Dra. Nurul Hidayah, M.Pd (Pembimbing RPL) |
| **Admin** | `admin@magang.id` | `password` | Ir. Bambang Hermanto, M.T (Kaprog RPL) |
