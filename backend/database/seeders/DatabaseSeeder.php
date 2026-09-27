<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Placement;
use App\Models\Attendance;
use App\Models\Logbook;
use App\Models\Grade;
use App\Models\Notification;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Create Users
        $admin = User::create([
            'name' => 'Ir. Bambang Hermanto, M.T',
            'email' => 'admin@magang.id',
            'password' => $password,
            'role' => 'admin',
            'nisn_nip' => '197508101999031002',
            'phone' => '081234567890',
            'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
        ]);

        $guru1 = User::create([
            'name' => 'Dra. Nurul Hidayah, M.Pd',
            'email' => 'guru@magang.id',
            'password' => $password,
            'role' => 'guru',
            'nisn_nip' => '198005122005012003',
            'phone' => '081398765432',
            'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
        ]);

        $guru2 = User::create([
            'name' => 'Ahmad Fauzi, S.Pd',
            'email' => 'fauzi@magang.id',
            'password' => $password,
            'role' => 'guru',
            'nisn_nip' => '198502142008011005',
            'phone' => '081311223344',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
        ]);

        $dudi1 = User::create([
            'name' => 'Hendra Wijaya, S.Kom',
            'email' => 'dudi@magang.id',
            'password' => $password,
            'role' => 'dudi',
            'nisn_nip' => 'ID-TELKOM-8821',
            'phone' => '081122334455',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
        ]);

        $dudi2 = User::create([
            'name' => 'Linda Kusuma, M.Ds',
            'email' => 'linda@magang.id',
            'password' => $password,
            'role' => 'dudi',
            'nisn_nip' => 'ID-IMK-4412',
            'phone' => '081199887766',
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150',
        ]);

        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'siswa@magang.id',
            'password' => $password,
            'role' => 'siswa',
            'nisn_nip' => '0061234567',
            'phone' => '085712345678',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@magang.id',
            'password' => $password,
            'role' => 'siswa',
            'nisn_nip' => '0061234568',
            'phone' => '085723456789',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
        ]);

        $siswa3 = User::create([
            'name' => 'Rizky Pratama',
            'email' => 'rizky@magang.id',
            'password' => $password,
            'role' => 'siswa',
            'nisn_nip' => '0061234569',
            'phone' => '085734567890',
            'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=150',
        ]);

        $siswa4 = User::create([
            'name' => 'Dewi Anggraeni',
            'email' => 'dewi@magang.id',
            'password' => $password,
            'role' => 'siswa',
            'nisn_nip' => '0061234570',
            'phone' => '085745678901',
            'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
        ]);

        // 2. Create Companies
        $comp1 = Company::create([
            'name' => 'PT Telkom Digital Solusi',
            'sector' => 'Software House & Cloud Infrastructure',
            'address' => 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan',
            'phone' => '021-52991000',
            'email' => 'internship@telkomdigital.co.id',
            'website' => 'https://telkomdigital.co.id',
            'quota' => 6,
        ]);

        $comp2 = Company::create([
            'name' => 'PT Inovasi Media Kreatif',
            'sector' => 'UI/UX Design, Web Application & Digital Marketing',
            'address' => 'Jl. Ir. H. Juanda No. 88, Dago, Bandung',
            'phone' => '022-2508899',
            'email' => 'hr@inovasimedia.id',
            'website' => 'https://inovasimedia.id',
            'quota' => 4,
        ]);

        $comp3 = Company::create([
            'name' => 'Bank Mandiri IT Hub Innovation',
            'sector' => 'Fintech, Cyber Security & Microservices',
            'address' => 'Plaza Mandiri Lt. 9, Jl. Jend. Sudirman Kav. 54-55, Jakarta',
            'phone' => '021-5265045',
            'email' => 'talent.ithub@bankmandiri.co.id',
            'website' => 'https://mandiriithub.co.id',
            'quota' => 8,
        ]);

        $comp4 = Company::create([
            'name' => 'CV Nusantara Studio Digital',
            'sector' => 'Game Development & Mobile Apps',
            'address' => 'Jl. Kaliurang KM 7, Sinduharjo, Sleman, D.I. Yogyakarta',
            'phone' => '0274-889911',
            'email' => 'career@nusantarastudio.com',
            'website' => 'https://nusantarastudio.com',
            'quota' => 4,
        ]);

        // 3. Placements
        $startDate = Carbon::now()->subMonths(2)->format('Y-m-d');
        $endDate = Carbon::now()->addMonths(4)->format('Y-m-d');

        Placement::create([
            'student_id' => $siswa1->id,
            'company_id' => $comp1->id,
            'dudi_mentor_id' => $dudi1->id,
            'teacher_mentor_id' => $guru1->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year' => '2025/2026',
            'batch' => 'Angkatan 32',
            'status' => 'active',
        ]);

        Placement::create([
            'student_id' => $siswa2->id,
            'company_id' => $comp1->id,
            'dudi_mentor_id' => $dudi1->id,
            'teacher_mentor_id' => $guru1->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year' => '2025/2026',
            'batch' => 'Angkatan 32',
            'status' => 'active',
        ]);

        Placement::create([
            'student_id' => $siswa3->id,
            'company_id' => $comp2->id,
            'dudi_mentor_id' => $dudi2->id,
            'teacher_mentor_id' => $guru1->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year' => '2025/2026',
            'batch' => 'Angkatan 32',
            'status' => 'active',
        ]);

        Placement::create([
            'student_id' => $siswa4->id,
            'company_id' => $comp3->id,
            'dudi_mentor_id' => null,
            'teacher_mentor_id' => $guru2->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year' => '2025/2026',
            'batch' => 'Angkatan 32',
            'status' => 'active',
        ]);

        // 4. Attendances for Siswa 1 (Budi) - last 14 days
        $today = Carbon::today();
        for ($i = 14; $i >= 1; $i--) {
            $attDate = $today->copy()->subDays($i);
            if ($attDate->isWeekend()) continue;

            Attendance::create([
                'student_id' => $siswa1->id,
                'date' => $attDate->format('Y-m-d'),
                'check_in' => '07:42:00',
                'check_out' => '17:05:00',
                'status' => 'hadir',
                'notes' => 'Tepat waktu di kantor Telkom Landmark',
                'location_in' => '-6.2301, 106.8228',
                'location_out' => '-6.2301, 106.8228',
            ]);
        }

        // Today's attendance for Budi (Checked in, not yet checked out for demo)
        Attendance::create([
            'student_id' => $siswa1->id,
            'date' => $today->format('Y-m-d'),
            'check_in' => '07:35:12',
            'check_out' => null,
            'status' => 'hadir',
            'notes' => 'Presensi pagi berhasil melalui sistem web desktop',
            'location_in' => '-6.2301, 106.8228',
        ]);

        // Attendances for Siswa 2 (Siti)
        for ($i = 5; $i >= 1; $i--) {
            $attDate = $today->copy()->subDays($i);
            if ($attDate->isWeekend()) continue;
            Attendance::create([
                'student_id' => $siswa2->id,
                'date' => $attDate->format('Y-m-d'),
                'check_in' => '07:58:00',
                'check_out' => '17:00:00',
                'status' => 'hadir',
            ]);
        }

        // Note: Siswa 3 (Rizky) has NO attendances for past 4 days! (triggers Guru's alert)

        // 5. Logbooks
        Logbook::create([
            'student_id' => $siswa1->id,
            'date' => $today->copy()->subDays(4)->format('Y-m-d'),
            'title' => 'Implementasi Endpoint REST API Autentikasi Sanctum',
            'activity_description' => 'Melakukan setup Laravel Sanctum untuk authentication token bearer, membuat middleware verifikasi peran aktor (siswa, dudi, guru, admin), dan menguji validasi request login menggunakan Postman.',
            'photo_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600',
            'status' => 'diacc',
            'feedback_note' => 'Kerja bagus, struktur controller dan error handling sudah memenuhi standar code review tim backend.',
            'validated_by' => $dudi1->id,
            'validated_at' => $today->copy()->subDays(3),
        ]);

        Logbook::create([
            'student_id' => $siswa1->id,
            'date' => $today->copy()->subDays(3)->format('Y-m-d'),
            'title' => 'Integrasi State Management Pinia pada Nuxt 3',
            'activity_description' => 'Mengonfigurasi state global untuk token autentikasi, status koneksi offline/online dengan reactive indicator, dan persistence data profil menggunakan pinia-plugin-persistedstate.',
            'photo_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600',
            'status' => 'diacc',
            'feedback_note' => 'Arsitektur store sangat rapi dan reusable.',
            'validated_by' => $dudi1->id,
            'validated_at' => $today->copy()->subDays(2),
        ]);

        Logbook::create([
            'student_id' => $siswa1->id,
            'date' => $today->copy()->subDays(2)->format('Y-m-d'),
            'title' => 'Optimasi Upload Foto Jurnal dengan Kompresi Gambar Canvas',
            'activity_description' => 'Menerapkan kompresi gambar berbasis HTML5 Canvas client-side sebelum upload ke server backend untuk menghemat bandwidth pengguna dan storage server.',
            'photo_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600',
            'status' => 'revisi',
            'feedback_note' => 'Hasil kompresi terlalu kecil sehingga tulisan kode di layar agak blur. Tolong naikkan kualitas kompresi ke target minimal 70% dan upload ulang screenshot.',
            'validated_by' => $dudi1->id,
            'validated_at' => $today->copy()->subDays(1),
        ]);

        Logbook::create([
            'student_id' => $siswa1->id,
            'date' => $today->copy()->subDays(1)->format('Y-m-d'),
            'title' => 'Pembuatan Tampilan Antarmuka Split-Screen Validasi DUDI',
            'activity_description' => 'Merancang layout split view sesuai panduan UX desktop: daftar siswa di panel samping kiri dan detail jurnal interaktif beserta aksi validasi di panel kanan.',
            'photo_url' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
            'status' => 'menunggu',
            'feedback_note' => null,
        ]);

        // Logbooks for Siti
        Logbook::create([
            'student_id' => $siswa2->id,
            'date' => $today->copy()->subDays(2)->format('Y-m-d'),
            'title' => 'Slicing Desain Dashboard Siswa ke Nuxt 3 & Tailwind CSS',
            'activity_description' => 'Membuat komponen widget tombol raksasa Check-In/Check-Out, widget persentase kehadiran dengan circular gauge, serta widget sisa hari magang.',
            'photo_url' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600',
            'status' => 'menunggu',
        ]);

        // Logbooks for Rizky
        Logbook::create([
            'student_id' => $siswa3->id,
            'date' => $today->copy()->subDays(5)->format('Y-m-d'),
            'title' => 'Riset Komponen Desain UI Figma',
            'activity_description' => 'Mengumpulkan wireframe dan moodboard design system aplikasi e-commerce.',
            'photo_url' => 'https://images.unsplash.com/photo-1581291518655-9523c93269c4?w=600',
            'status' => 'diacc',
            'validated_by' => $dudi2->id,
        ]);

        // 6. Grades
        Grade::create([
            'student_id' => $siswa1->id,
            'dudi_score_discipline' => 92,
            'dudi_score_technical' => 95,
            'dudi_score_teamwork' => 90,
            'dudi_score_initiative' => 93,
            'dudi_score_average' => 92.50,
            'dudi_notes' => 'Budi menunjukkan etos kerja luar biasa, pemahaman arsitektur software sangat cepat, dan selalu proaktif menyelesaikan sprint tugas tepat waktu.',
            'school_report_score' => 90.00,
            'final_score' => 91.50, // (92.50 * 0.6) + (90.00 * 0.4) = 55.5 + 36 = 91.5
            'qr_code_hash' => 'PKL-2026-TELKOM-BUDI-9150-VERIFIED',
            'is_finalized' => true,
            'finalized_at' => $today->copy()->subDays(1),
        ]);

        // 7. Notifications
        Notification::create([
            'user_id' => $siswa1->id,
            'title' => 'Catatan Revisi Logbook',
            'message' => 'Jurnal Anda "Optimasi Upload Foto Jurnal" perlu revisi: Naikkan kualitas kompresi ke minimal 70%.',
            'type' => 'warning',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $siswa1->id,
            'title' => 'Jurnal Diterima',
            'message' => 'Jurnal "Integrasi State Management Pinia" telah di-ACC oleh Hendra Wijaya, S.Kom.',
            'type' => 'success',
            'is_read' => true,
        ]);

        Notification::create([
            'user_id' => $dudi1->id,
            'title' => 'Jurnal Menunggu Validasi',
            'message' => 'Terdapat 2 jurnal magang baru dari Budi Santoso dan Siti Rahma yang menunggu untuk divalidasi.',
            'type' => 'info',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $guru1->id,
            'title' => 'Peringatan Ketidakhadiran Siswa!',
            'message' => 'Siswa Rizky Pratama (PT Inovasi Media Kreatif) terdeteksi tidak mengisi presensi dan jurnal selama lebih dari 3 hari berturut-turut.',
            'type' => 'danger',
            'is_read' => false,
        ]);
    }
}
