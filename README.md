# Jurnal Magang Digital (Sistem Informasi PKL Desktop-Style)

Aplikasi web modern berskala desktop enterprise untuk **Jurnal Magang / Praktik Kerja Lapangan (PKL) Digital** yang dibangun dengan arsitektur **Fullstack Laravel 11/12 (Backend REST API) & Nuxt 3 (Frontend Vue 3 + Tailwind CSS)**.

Aplikasi ini mengadopsi standar tata letak desktop optimal:
- **Navbar (Sidebar Kiri):** Pusat navigasi menu & area komponen global statis di bagian bawah.
- **View (Area Konten Kanan):** Tempat menampilkan data, analitik grafik, antarmuka split-screen, dan form interaktif sesuai aktor yang sedang aktif.

---

## 🚀 Fitur & Modul Sesuai Spesifikasi

### 1. Modul Siswa (SMKN 71 Jakarta: PPLG, DKV, Animasi)
- **Dashboard Siswa:**
  - Hero Widget Interaktif **Presensi Digital Mandiri: Tap In & Tap Out**:
    - Jam digital realtime yang berdetak setiap detik (`WIB`).
    - **Selector Mode Kerja:**
      - 🏢 **WFO (Work From Office):** Validasi Geofencing GPS (jarak Haversine formula terhadap koordinat kantor PT mitra dengan radius toleransi 150m).
      - 🏠 **WFH (Work From Home):** Mode bekerja dari rumah bagi siswa bidang programming/rendering aset animasi.
      - 🌐 **WFA (Work From Anywhere):** Mode penugasan lapangan/liputan visual kreatif tanpa batas radius kantor.
    - Tombol raksasa **Tap In (Masuk)** dan **Tap Out (Pulang)** dengan feedback visual instan dan integrasi REST API online.
  - Widget circular gauge **Persentase Kehadiran** (96.4% kehadiran).
  - Widget countdown **Sisa Waktu Magang** dan rincian penempatan.
  - Daftar **Notifikasi Terbaru** (peringatan revisi dari pembimbing lapangan).
- **Logbook Harian (Split Top/Bottom Layout):**
  - **Bagian Atas:** Form input jurnal baru (tanggal, judul, deskripsi kegiatan metode STAR, upload foto dengan kompresi client-side HTML5 Canvas otomatis, tombol Simpan).
  - **Bagian Bawah:** Tabel riwayat jurnal minggu ini lengkap dengan badge status (*Menunggu, Di-ACC, Revisi*) dan catatan umpan balik Pembimbing Lapangan.
- **Riwayat Presensi:**
  - Switcher dua mode: **Tampilan Kalender (Calendar View)** dan **Daftar Rinci (List View)** memuat rekam jejak jam Check-In dan Check-Out harian.
- **Informasi Penempatan:**
  - Profil detail tempat magang (nama instansi / perusahaan, bidang/sektor, alamat kantor, telepon, website resmi).
  - Kontak Pembimbing Lapangan (Mentor) dilengkapi tombol langsung WhatsApp/Email.
  - Kontak Guru Pembimbing Sekolah dilengkapi tombol konsultasi.

### 2. Modul Pembimbing Lapangan (Instansi / Perusahaan)
- **Dashboard Pembimbing:**
  - Daftar kartu (*card*) siswa aktif magang di tempat kerja.
  - Indikator badge mencolok jumlah jurnal yang menunggu untuk divalidasi.
  - Indikator tingkat kedisiplinan dan aktivitas terakhir setiap siswa.
- **Validasi Jurnal (Antarmuka Belah / Split-Screen):**
  - **Panel Kiri:** Daftar nama siswa dengan pencarian cepat dan counter jurnal baru.
  - **Panel Kanan:** Isi detail jurnal harian siswa terpilih, foto dokumentasi hasil pekerjaan, tombol aksi `ACC (Setujui Jurnal)` atau `Tolak / Minta Revisi` lengkap dengan kolom input catatan umpan balik (*feedback note*).
- **Presensi Siswa:**
  - Tabel rekapitulasi kehadiran seluruh siswa di tempat magang tersebut untuk kontrol kedisiplinan (Check-In, Check-Out, durasi kerja, status tepat waktu/terlambat, dan geotagging).
- **Evaluasi & Penilaian:**
  - Form rubrik penilaian 4 aspek: Kedisiplinan & Etos Kerja, Keahlian Teknis, Kerjasama Tim, dan Inisiatif.
  - Kalkulasi otomatis nilai rata-rata Pembimbing Lapangan dan predikat mutu kerja (A/B/C).
  - Tombol **`Finalisasi Nilai & Generate QR Code`** yang menerbitkan sertifikat digital terverifikasi dengan barcode QR Code asli (Canvas/SVG).

### 3. Modul Guru Pembimbing (Pengelompokan Berdasarkan Mitra PT)
- **Dashboard Guru:**
  - **Seksi / Pengelompokan Berdasarkan Mitra Industri (PT):**
    - 1 Guru dapat membimbing lebih dari 5 siswa yang magang di berbagai PT berbeda tanpa kebingungan.
    - Tab filter instan per PT: *Semua PT, PT Telkom Digital Solusi (PPLG), Studio Animasi Kinetik Digital (Animasi), Pixel Kreatif Visual Agency (DKV)*.
    - Setiap seksi PT menampilkan profil industri, kontak Mentor Lapangan (WhatsApp langsung), dan grid kartu siswa binaan di PT tersebut.
  - **Peringatan Sistem Kritis (Red Alert):** Otomatis mendeteksi dan memperingatkan guru jika ada siswa yang tidak mengisi presensi maupun jurnal selama lebih dari 3 hari berturut-turut (misal siswa Rizky Pratama di Pixel Kreatif), disertai tombol hubungi siswa dan mentor PT.
  - Grafik keaktifan komparasi seluruh siswa binaan (kehadiran vs pengisian jurnal).
- **Monitoring Jurnal & Kehadiran (Read-Only):**
  - Filter pencarian berjenjang: Pilih PT terlebih dahulu -> muncul siswa pada PT tersebut -> klik siswa untuk melihat timeline kronologis jurnal secara mendalam.
- **Manajemen Nilai:**
  - Tabel kompilasi: Nilai dari Pembimbing Lapangan (otomatis terisi dari input mentor dan terverifikasi QR), kolom input manual untuk Nilai Laporan Sekolah, dan kalkulasi otomatis Nilai Akhir PKL.

### 4. Modul Admin / Kaprog (Alur Pendaftaran Terpadu All-in-One)
- **Dashboard Admin:**
  - Statistik level makro: Total siswa terdaftar, total tempat magang, total guru pembimbing, dan total jurnal terverifikasi.
  - Grafik penyebaran dan utilisasi kuota siswa di berbagai tempat magang.
  - Panel **Status Infrastruktur Cloud & Database Online SMKN 71** (100% online realtime, auto-save live API, tanpa tombol sync push manual).
- **Data Master Terpadu:**
  - 4 Sub-Tabs: **👨‍🎓 Siswa-Siswi**, **🏢 Tempat Magang (Instansi / Perusahaan)**, **👔 Pembimbing Lapangan**, dan **👨‍🏫 Guru Pembimbing**.
  - **Pendaftaran Siswa Baru Terpadu (All-in-One Quick Enrollment):**
    - Admin dapat mendaftarkan siswa sekaligus memilih tempat magang, ATAU **menambahkan tempat magang baru secara langsung (inline) di form yang sama** tanpa harus bolak-balik halaman!
  - Filter cepat jurusan (PPLG, Animasi, DKV) dan live search real-time.
- **Plotting / Penempatan (Panel Ganda / Dual-Panel):**
  - **Panel Kiri:** Pilih nama siswa yang akan diplot.
  - **Panel Kanan:** Pilih tempat magang, pilih pembimbing lapangan, pilih guru pembimbing, tetapkan tanggal mulai & selesai magang, lalu klik tombol **`Tetapkan Penempatan`**.
- **Laporan & Arsip:**
  - Panel filter lengkap: Filter Tahun Ajaran, Filter Angkatan, Filter Tempat Magang, dan Filter Status Nilai.
  - **Pratinjau Buku Jurnal Cetak:** Pratinjau berkas cetak resmi dengan Kop Surat Dinas Pendidikan, tabel rekapitulasi nilai komprehensif, dan lembar pengesahan tanda tangan Kepala Sekolah & Kaprog.
  - Tombol **`Export to PDF`** dan **`Export to Excel (CSV)`**.

---

### 🌐 Komponen Global (Wajib Ada di Semua Aktor - Bagian Bawah Navbar)
- **Indikator Jaringan (Khusus Desktop):**
  - Ikon sinyal berwarna **Hijau (Online & Sinkron)** atau **Kuning/Merah (Offline, menyimpan data di lokal)**.
  - Tombol kecil **`Sinkronisasi Sekarang`** dengan animasi proses sinkronisasi real-time.
  - Mendukung klik langsung pada indikator jaringan di header atas untuk mensimulasikan perpindahan mode Offline & Online.
- **Mini Profil:**
  - Foto avatar, nama lengkap pengguna, dan label peran dinamis (misal: "Budi - Siswa", "Hendra - Pembimbing Lapangan", "Nurul - Guru Pembimbing", "Bambang - Admin / Kaprog").
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
│   │   │   ├── MentorController.php  # Controller Pembimbing Lapangan (Instansi/PT)
│   │   │   ├── DudiController.php    # Alias kompatibilitas
│   │   │   ├── GuruController.php
│   │   │   └── AdminController.php
│   │   └── Models/          # User, Company, Placement, Attendance, Logbook, Grade, Notification
│   ├── database/
│   │   ├── migrations/      # Skema database SQLite / MySQL lengkap
│   │   └── seeders/         # Data realistis untuk 4 aktor, tempat magang, presensi & jurnal
│   └── routes/api.php       # 54 endpoint REST API terlindungi Sanctum
│
├── frontend/                 # Nuxt 3 Desktop Application
│   ├── app.vue               # Main desktop shell (Left Navbar + Right View)
│   ├── components/
│   │   ├── DesktopSidebar.vue       # Navbar Sidebar Kiri & Global Bottom Section
│   │   ├── SettingsModal.vue        # Modal Ubah Password
│   │   ├── SiswaDashboard.vue       # Tombol raksasa Check-In/Out & widgets
│   │   ├── SiswaLogbook.vue         # Split view input form + weekly table
│   │   ├── SiswaPresensi.vue        # Kalender & list jam check-in/out
│   │   ├── SiswaPenempatan.vue      # Profil tempat magang, kontak mentor & guru
│   │   ├── DudiDashboard.vue        # Card siswa aktif & pending counter
│   │   ├── DudiValidasi.vue         # Split-screen review jurnal & ACC/Tolak
│   │   ├── DudiPresensi.vue         # Matriks kedisiplinan siswa
│   │   ├── DudiEvaluasi.vue         # Rubrik nilai & generator QR Code
│   │   ├── GuruDashboard.vue        # Grafik keaktifan & Red Alert (>3 hari)
│   │   ├── GuruMonitoring.vue       # Search filter + read-only timeline
│   │   ├── GuruNilai.vue            # Tabel kompilasi nilai Lapangan + Sekolah
│   │   ├── AdminDashboard.vue       # Statistik makro & status sinkronisasi
│   │   ├── AdminDataMaster.vue      # CRUD Siswa, Tempat Magang, Mentor, Guru + Excel Import
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

Pada bagian paling atas Sidebar Kiri, terdapat **Simulasi Aktor Switcher** yang memungkinkan penguji berganti peran secara instan (Siswa, Mentor, Guru, Admin) dengan 1 kali klik. Anda juga dapat login manual menggunakan akun berikut:

| Aktor | Email | Password | Keterangan |
|---|---|---|---|
| **Siswa** | `siswa@gmail.com` | `12345678` | Budi Santoso (PT Telkom Digital Solusi) |
| **Pembimbing Lapangan** | `mentor@gmail.com` | `12345678` | Hendra Wijaya, S.Kom (Tech Lead Telkom) |
| **Guru Pembimbing** | `guru@gmail.com` | `12345678` | Dra. Nurul Hidayah, M.Pd (Pembimbing RPL) |
| **Admin / Kaprog** | `admin@gmail.com` | `12345678` | Ir. Bambang Hermanto, M.T (Kaprog RPL) |

---

## 🤖 Dukungan Antigravity AI & Portabilitas Lintas Perangkat

Repositori ini sudah dilengkapi dengan **Project Skills** dan panduan instruksi otomatis untuk **Antigravity AI**:
- **`.agent/skills/jurnal-magang-project/SKILL.md`**: Skill sistem pakar yang memuat seluruh konteks teknis, arsitektur, dan protokol analisis proyek.
- **`.agent/skills/apple-design/SKILL.md`**: Standar antarmuka desain fluid & interaktif Apple-style.
- **`AGENTS.md` & `GEMINI.md`**: Aturan otomatisasi workspace yang langsung dibaca oleh Antigravity AI saat repo dibuka di device mana pun.
- **`backend/database/database.sqlite` & `backend/database/database.sql`**: Data bawaan lengkap (pre-seeded) siap uji coba tanpa perlu konfigurasi ulang.

**Saat berpindah perangkat (laptop/PC baru):**
1. Clone repositori ini (`git clone https://github.com/codevall000-del/sistemjurnalmagangdigital.git`).
2. Buka di Antigravity AI / IDE.
3. Berikan instruksi:
   > *"Tolong analisis project ini dan jelaskan apa saja yang harus dilakukan."*
4. Antigravity AI akan langsung memindai status kesehatan sistem, data, dan memberikan rekomendasi roadmap secara otomatis!

