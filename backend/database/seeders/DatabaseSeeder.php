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
use App\Models\WorkModeRequest;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        // 1. Admin & Guru
        $admin = User::create([
            'name' => 'Ir. Bambang Hermanto, M.T',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'role' => 'admin',
            'nisn_nip' => '198001012005011001',
            'phone' => '081200000001',
            'major' => 'RPL',
            'class_name' => 'Kaprog Vokasi',
            'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
        ]);

        $guru = User::create([
            'name' => 'Dra. Nurul Hidayah, M.Pd',
            'email' => 'guru@gmail.com',
            'password' => $password,
            'role' => 'guru',
            'nisn_nip' => '198502142010011002',
            'phone' => '081200000002',
            'major' => 'RPL',
            'class_name' => 'Guru Pembimbing Utama',
            'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150',
        ]);

        // 2. Tiga Tempat Magang (Instansi/Perusahaan) & Pembimbing Lapangan untuk 3 Konsentrasi Keahlian SMKN 71
        // Tempat 1: RPL
        $compTelkom = Company::create([
            'name' => 'PT Telkom Digital Solusi',
            'sector' => 'Software House & Cloud Infrastructure (RPL)',
            'address' => 'Jl. Gatot Subroto Kav. 52, Gedung Telkom Landmark Lt. 14, Jakarta Selatan',
            'phone' => '021-52991000',
            'email' => 'internship@telkomdigital.co.id',
            'website' => 'https://telkomdigital.co.id',
            'quota' => 6,
            'latitude' => -6.2301000,
            'longitude' => 106.8228000,
            'radius_meters' => 150,
            'allowed_work_modes' => 'wfo,wfh',
        ]);

        $mentorTelkom = User::create([
            'name' => 'Hendra Wijaya, S.Kom',
            'email' => 'mentor@gmail.com',
            'password' => $password,
            'role' => 'mentor',
            'nisn_nip' => 'ID-TELKOM-8821',
            'phone' => '081200000003',
            'major' => 'RPL',
            'class_name' => 'Lead Software Engineer',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
        ]);

        // Tempat 2: Animasi
        $compAnimasi = Company::create([
            'name' => 'Studio Animasi Kinetik Digital',
            'sector' => '3D Animation & CGI Motion Picture (Animasi)',
            'address' => 'Jl. Raden Saleh No. 18, Cikini, Jakarta Pusat',
            'phone' => '021-31902211',
            'email' => 'hr@kinetikanimasi.id',
            'website' => 'https://kinetikanimasi.id',
            'quota' => 4,
            'latitude' => -6.1852000,
            'longitude' => 106.8315000,
            'radius_meters' => 200,
            'allowed_work_modes' => 'wfo,wfh,wfa',
        ]);

        $mentorAnimasi = User::create([
            'name' => 'Raditya Pratama, S.Sn',
            'email' => 'mentor2@gmail.com',
            'password' => $password,
            'role' => 'mentor',
            'nisn_nip' => 'ID-KINETIK-104',
            'phone' => '081200000021',
            'major' => 'Animasi',
            'class_name' => 'Senior 3D Animator',
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',
        ]);

        // Tempat 3: DKV (Desain Komunikasi Visual)
        $compDkv = Company::create([
            'name' => 'Pixel Kreatif Visual Agency',
            'sector' => 'Branding, Creative Media & UI/UX (DKV)',
            'address' => 'Jl. Pemuda No. 65, Rawamangun, Jakarta Timur',
            'phone' => '021-47863210',
            'email' => 'career@pixelkreatif.com',
            'website' => 'https://pixelkreatif.com',
            'quota' => 5,
            'latitude' => -6.2155000,
            'longitude' => 106.8650000,
            'radius_meters' => 150,
            'allowed_work_modes' => 'wfo,wfa',
        ]);

        $mentorDkv = User::create([
            'name' => 'Maya Safitri, M.Ds',
            'email' => 'mentor3@gmail.com',
            'password' => $password,
            'role' => 'mentor',
            'nisn_nip' => 'ID-PIXEL-332',
            'phone' => '081200000031',
            'major' => 'DKV',
            'class_name' => 'Creative Director',
            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150',
        ]);

        // 3. Siswa Binaan (> 5 siswa dengan PT berbeda-beda di bawah bimbingan Guru Nurul Hidayah)
        $studentsConfig = [
            // RPL di PT Telkom
            [
                'name' => 'Budi Santoso',
                'email' => 'siswa@gmail.com',
                'nisn' => '0061234567',
                'phone' => '081200000004',
                'major' => 'RPL',
                'class' => 'XII RPL 1',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
                'company' => $compTelkom,
                'dudi' => $mentorTelkom,
                'mode' => 'wfo',
                'inactive_days' => 0,
            ],
            [
                'name' => 'Siti Fauziah',
                'email' => 'siti@gmail.com',
                'nisn' => '0061234568',
                'phone' => '081200000005',
                'major' => 'RPL',
                'class' => 'XII RPL 2',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
                'company' => $compTelkom,
                'dudi' => $mentorTelkom,
                'mode' => 'wfh',
                'inactive_days' => 0,
            ],
            // Animasi di Studio Kinetik
            [
                'name' => 'Ahmad Danu',
                'email' => 'danu@gmail.com',
                'nisn' => '0061234569',
                'phone' => '081200000006',
                'major' => 'Animasi',
                'class' => 'XII Animasi 1',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
                'company' => $compAnimasi,
                'dudi' => $mentorAnimasi,
                'mode' => 'wfa',
                'inactive_days' => 0,
            ],
            [
                'name' => 'Putri Maharani',
                'email' => 'putri@gmail.com',
                'nisn' => '0061234570',
                'phone' => '081200000007',
                'major' => 'Animasi',
                'class' => 'XII Animasi 2',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',
                'company' => $compAnimasi,
                'dudi' => $mentorAnimasi,
                'mode' => 'wfo',
                'inactive_days' => 0,
            ],
            // DKV di Pixel Kreatif
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@gmail.com',
                'nisn' => '0061234571',
                'phone' => '081200000008',
                'major' => 'DKV',
                'class' => 'XII DKV 1',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150',
                'company' => $compDkv,
                'dudi' => $mentorDkv,
                'mode' => 'wfo',
                'inactive_days' => 4, // RED ALERT CRITICAL > 3 HARI
            ],
            [
                'name' => 'Jessica Tan',
                'email' => 'jessica@gmail.com',
                'nisn' => '0061234572',
                'phone' => '081200000009',
                'major' => 'DKV',
                'class' => 'XII DKV 2',
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150',
                'company' => $compDkv,
                'dudi' => $mentorDkv,
                'mode' => 'wfh',
                'inactive_days' => 0,
            ],
        ];

        $today = Carbon::today();
        $startDate = Carbon::now()->subMonths(2)->format('Y-m-d');
        $endDate = Carbon::now()->addMonths(4)->format('Y-m-d');

        foreach ($studentsConfig as $cfg) {
            $student = User::create([
                'name' => $cfg['name'],
                'email' => $cfg['email'],
                'password' => $password,
                'role' => 'siswa',
                'nisn_nip' => $cfg['nisn'],
                'phone' => $cfg['phone'],
                'major' => $cfg['major'],
                'class_name' => $cfg['class'],
                'avatar' => $cfg['avatar'],
            ]);

            // Schedule Mingguan berdasarkan Konsentrasi Keahlian & Perusahaan
            $scheduleConfig = match ($cfg['major']) {
                'RPL', 'PPLG' => [
                    'monday' => 'wfo',
                    'tuesday' => 'wfo',
                    'wednesday' => 'wfo',
                    'thursday' => 'wfo',
                    'friday' => 'wfh',
                    'saturday' => 'wfo',
                    'sunday' => 'wfo',
                ],
                'Animasi' => [
                    'monday' => 'wfo',
                    'tuesday' => 'wfo',
                    'wednesday' => 'wfo',
                    'thursday' => 'wfh',
                    'friday' => 'wfa',
                    'saturday' => 'wfo',
                    'sunday' => 'wfo',
                ],
                'DKV' => [
                    'monday' => 'wfo',
                    'tuesday' => 'wfo',
                    'wednesday' => 'wfa',
                    'thursday' => 'wfa',
                    'friday' => 'wfh',
                    'saturday' => 'wfo',
                    'sunday' => 'wfo',
                ],
                default => [
                    'monday' => 'wfo',
                    'tuesday' => 'wfo',
                    'wednesday' => 'wfo',
                    'thursday' => 'wfo',
                    'friday' => 'wfh',
                    'saturday' => 'wfo',
                    'sunday' => 'wfo',
                ],
            };

            // Buat Placement
            $placement = Placement::create([
                'student_id' => $student->id,
                'company_id' => $cfg['company']->id,
                'dudi_mentor_id' => $cfg['dudi']->id,
                'teacher_mentor_id' => $guru->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'academic_year' => '2025/2026',
                'batch' => 'Angkatan 32',
                'default_work_mode' => $cfg['mode'],
                'work_schedule' => $scheduleConfig,
                'status' => 'active',
            ]);

            // Riwayat Presensi
            if ($cfg['inactive_days'] === 0) {
                for ($i = 10; $i >= 1; $i--) {
                    $attDate = $today->copy()->subDays($i);
                    if ($attDate->isWeekend()) continue;

                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $attDate->format('Y-m-d'),
                        'check_in' => '07:45:00',
                        'check_out' => '17:05:00',
                        'status' => 'hadir',
                        'work_mode' => $cfg['mode'],
                        'latitude' => $cfg['company']->latitude,
                        'longitude' => $cfg['company']->longitude,
                        'distance_meters' => 25,
                        'is_within_radius' => true,
                        'notes' => 'Presensi harian tercatat online di ' . $cfg['company']->name,
                        'location_in' => "{$cfg['company']->latitude}, {$cfg['company']->longitude}",
                        'location_out' => "{$cfg['company']->latitude}, {$cfg['company']->longitude}",
                    ]);
                }

                // Hari ini: check-in (khusus Budi sudah check-in)
                if ($cfg['email'] === 'siswa@gmail.com') {
                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $today->format('Y-m-d'),
                        'check_in' => '07:35:12',
                        'check_out' => null,
                        'status' => 'hadir',
                        'work_mode' => 'wfo',
                        'latitude' => $cfg['company']->latitude,
                        'longitude' => $cfg['company']->longitude,
                        'distance_meters' => 18,
                        'is_within_radius' => true,
                        'notes' => 'Presensi pagi WFO terverifikasi geofence Telkom Landmark',
                        'location_in' => "{$cfg['company']->latitude}, {$cfg['company']->longitude}",
                    ]);
                }
            } else {
                // Untuk siswa Rizky (tidak aktif 4 hari)
                for ($i = 14; $i >= $cfg['inactive_days'] + 1; $i--) {
                    $attDate = $today->copy()->subDays($i);
                    if ($attDate->isWeekend()) continue;

                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $attDate->format('Y-m-d'),
                        'check_in' => '07:50:00',
                        'check_out' => '17:00:00',
                        'status' => 'hadir',
                        'work_mode' => 'wfo',
                        'latitude' => $cfg['company']->latitude,
                        'longitude' => $cfg['company']->longitude,
                        'distance_meters' => 30,
                        'is_within_radius' => true,
                        'notes' => 'Presensi kehadiran',
                    ]);
                }
            }

            // Logbooks
            if ($cfg['inactive_days'] === 0) {
                Logbook::create([
                    'student_id' => $student->id,
                    'date' => $today->copy()->subDays(2)->format('Y-m-d'),
                    'title' => 'Pengerjaan Modul Teknis Magang ' . $cfg['major'],
                    'activity_description' => 'Melaksanakan instruksi kerja harian bersama tim, melakukan peninjauan hasil kerja, dan melaporkan kemajuan proyek kepada Pembimbing Lapangan.',
                    'photo_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600',
                    'status' => 'diacc',
                    'feedback_note' => 'Pekerjaan sangat baik dan rapi.',
                    'validated_by' => $cfg['dudi']->id,
                    'validated_at' => $today->copy()->subDays(1),
                ]);

                Logbook::create([
                    'student_id' => $student->id,
                    'date' => $today->copy()->subDays(1)->format('Y-m-d'),
                    'title' => 'Pengujian dan Quality Review ' . $cfg['major'],
                    'activity_description' => 'Menguji kesesuaian output terhadap standar mutu industri dan memperbaiki feedback catatan dari pembimbing.',
                    'photo_url' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600',
                    'status' => 'menunggu',
                    'feedback_note' => null,
                ]);
            }

            // Grade
            Grade::create([
                'student_id' => $student->id,
                'dudi_score_discipline' => 90,
                'dudi_score_technical' => 92,
                'dudi_score_teamwork' => 88,
                'dudi_score_initiative' => 91,
                'dudi_score_average' => 90.25,
                'dudi_notes' => 'Kemampuan kerja praktis sangat memuaskan sesuai kompetensi ' . $cfg['major'] . ' SMKN 71.',
                'school_report_score' => 89.00,
                'final_score' => 89.75,
                'qr_code_hash' => 'SMKN71-PKL-' . $cfg['major'] . '-' . $student->id . '-VERIFIED',
                'is_finalized' => true,
                'finalized_at' => $today->copy()->subDays(2),
            ]);
        }

        // Seed Sample Work Mode Requests (Dispensasi WFH / WFA)
        $siti = User::where('email', 'siti@gmail.com')->first();
        $danu = User::where('email', 'danu@gmail.com')->first();
        $pSiti = $siti ? Placement::where('student_id', $siti->id)->first() : null;
        $pDanu = $danu ? Placement::where('student_id', $danu->id)->first() : null;

        if ($siti && $pSiti) {
            WorkModeRequest::create([
                'student_id' => $siti->id,
                'placement_id' => $pSiti->id,
                'date' => $today->format('Y-m-d'),
                'requested_mode' => 'wfh',
                'reason' => 'Demam ringan dan flu, namun siap stand by dan mengerjakan slicing UI Nuxt dari rumah.',
                'status' => 'pending',
            ]);
        }

        if ($danu && $pDanu) {
            WorkModeRequest::create([
                'student_id' => $danu->id,
                'placement_id' => $pDanu->id,
                'date' => $today->format('Y-m-d'),
                'requested_mode' => 'wfa',
                'reason' => 'Riset pencahayaan dan pengambilan referensi visual tekstur di kawasan Kota Tua Jakarta.',
                'status' => 'pending',
            ]);
        }

        // Notification
        Notification::create([
            'user_id' => $guru->id,
            'title' => 'Peringatan Absensi Siswa',
            'message' => 'Siswa Rizky Pratama (DKV) terdeteksi tidak aktif selama 4 hari berturut-turut di Pixel Kreatif Visual Agency.',
            'type' => 'danger',
            'is_read' => false,
        ]);
    }
}
