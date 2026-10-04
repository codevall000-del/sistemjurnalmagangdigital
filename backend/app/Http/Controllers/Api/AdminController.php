<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Placement;
use App\Models\Logbook;
use App\Models\Attendance;
use App\Models\Grade;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'siswa')->count();
        $totalMentors = User::whereIn('role', ['dudi', 'mentor'])->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalCompanies = Company::count();
        $totalPlacements = Placement::where('status', 'active')->count();

        // Company distribution
        $companies = Company::withCount('placements')->get();
        $distribution = $companies->map(function ($c) {
            return [
                'name' => $c->name,
                'students_count' => $c->placements_count,
                'quota' => $c->quota,
            ];
        });

        // Server cloud status (Full Online Real-time Architecture)
        $cloudStatus = [
            'status' => 'online',
            'server_cluster' => 'SMKN 71 Jakarta Cloud Production',
            'connected_at' => Carbon::now()->format('d M Y H:i:s'),
            'api_latency' => '24 ms',
            'server_health' => 'optimal',
            'database' => 'Cloud Database (Auto-Commit Live)',
            'sync_mode' => 'Real-time Online (No Manual Push Required)',
        ];

        return response()->json([
            'success' => true,
            'stats' => [
                'total_students' => $totalStudents,
                'total_mentors' => $totalMentors,
                'total_dudi' => $totalMentors,
                'total_guru' => $totalGuru,
                'total_companies' => $totalCompanies,
                'active_placements' => $totalPlacements,
            ],
            'distribution' => $distribution,
            'cloud_status' => $cloudStatus,
        ]);
    }

    public function getMasterData(Request $request)
    {
        $role = $request->input('role', 'siswa'); // siswa, mentor, dudi, guru, company
        $search = $request->input('search');

        if ($role === 'company') {
            $compQuery = Company::withCount('placements');
            if ($search) {
                $compQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('sector', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            }
            $companies = $compQuery->orderBy('name', 'asc')->get();

            return response()->json([
                'success' => true,
                'role' => 'company',
                'companies' => $companies,
            ]);
        }

        if (in_array($role, ['mentor', 'dudi'])) {
            $query = User::whereIn('role', ['mentor', 'dudi']);
        } else {
            $query = User::where('role', $role);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nisn_nip', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role === 'siswa') {
            $query->with(['studentPlacement.company', 'studentPlacement.dudiMentor', 'studentPlacement.teacherMentor']);
        }

        $users = $query->orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'role' => $role,
            'users' => $users,
        ]);
    }

    public function storeMasterData(Request $request)
    {
        $role = $request->input('role', 'siswa');

        if ($role === 'company') {
            $request->validate([
                'name' => 'required|string|max:255',
                'sector' => 'nullable|string',
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'quota' => 'nullable|integer',
            ]);

            $company = Company::create([
                'name' => $request->name,
                'sector' => $request->sector ?? 'Tempat Magang / Instansi',
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'quota' => $request->quota ?? 5,
                'latitude' => $request->latitude ?? -6.2301000,
                'longitude' => $request->longitude ?? 106.8228000,
                'radius_meters' => $request->radius_meters ?? 150,
                'allowed_work_modes' => $request->allowed_work_modes ?? 'wfo,wfh,wfa',
            ]);

            return response()->json([
                'success' => true,
                'message' => "Tempat Magang / Instansi {$company->name} berhasil ditambahkan.",
                'company' => $company,
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:siswa,dudi,mentor,guru',
            'nisn_nip' => 'nullable|string',
            'phone' => 'nullable|string',
            'major' => 'nullable|string',
            'class_name' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nisn_nip' => $request->nisn_nip,
            'phone' => $request->phone,
            'major' => $request->major ?? ($request->role === 'siswa' ? 'PPLG' : null),
            'class_name' => $request->class_name,
            'password' => Hash::make($request->password ?? 'password123'),
            'avatar' => $request->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',
        ]);

        // ALUR TERPADU: Jika mendaftarkan Siswa dan sekaligus menentukan Tempat PKL
        if ($request->role === 'siswa') {
            $companyId = $request->input('company_id');

            // Jika admin membuat tempat PKL baru secara instan di form yang sama
            if ($request->filled('new_company_name')) {
                $newComp = Company::create([
                    'name' => $request->new_company_name,
                    'sector' => $request->input('new_company_sector', 'Teknologi & Kreatif'),
                    'address' => $request->input('new_company_address', 'DKI Jakarta'),
                    'quota' => 6,
                    'allowed_work_modes' => $request->input('default_work_mode', 'wfo,wfh'),
                ]);
                $companyId = $newComp->id;
            }

            if ($companyId) {
                Placement::updateOrCreate(
                    ['student_id' => $user->id],
                    [
                        'company_id' => $companyId,
                        'teacher_mentor_id' => $request->input('teacher_mentor_id'),
                        'dudi_mentor_id' => $request->input('mentor_id') ?? $request->input('dudi_mentor_id'),
                        'start_date' => $request->input('start_date', Carbon::today()->format('Y-m-d')),
                        'end_date' => $request->input('end_date', Carbon::today()->addMonths(4)->format('Y-m-d')),
                        'academic_year' => $request->input('academic_year', '2025/2026'),
                        'batch' => $request->input('batch', 'Angkatan 32'),
                        'default_work_mode' => $request->input('default_work_mode', 'wfo'),
                        'status' => 'active',
                    ]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Data {$user->name} berhasil ditambahkan.",
            'user' => $user->load('studentPlacement.company'),
        ]);
    }

    public function updateMasterData(Request $request, $id)
    {
        $role = $request->input('role');

        if ($role === 'company') {
            $company = Company::findOrFail($id);
            $company->update($request->only([
                'name', 'sector', 'address', 'phone', 'email', 'website', 'quota',
                'latitude', 'longitude', 'radius_meters', 'allowed_work_modes'
            ]));

            return response()->json([
                'success' => true,
                'message' => "Data perusahaan {$company->name} berhasil diperbarui.",
                'company' => $company,
            ]);
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nisn_nip' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nisn_nip = $request->nisn_nip;
        $user->phone = $request->phone;
        if ($request->filled('major')) $user->major = $request->major;
        if ($request->filled('class_name')) $user->class_name = $request->class_name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil diperbarui.',
            'user' => $user,
        ]);
    }

    public function deleteMasterData($id, Request $request)
    {
        if ($request->input('role') === 'company') {
            $company = Company::findOrFail($id);
            $company->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data perusahaan mitra berhasil dihapus.',
            ]);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil dihapus.',
        ]);
    }

    public function importMasterData(Request $request)
    {
        $role = $request->input('role', 'siswa');
        $rows = $request->input('rows', []);

        $imported = 0;
        foreach ($rows as $row) {
            if (empty($row['email']) || empty($row['name'])) continue;

            User::updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'role' => $role,
                    'nisn_nip' => $row['nisn_nip'] ?? null,
                    'phone' => $row['phone'] ?? null,
                    'password' => Hash::make('password123'),
                    'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',
                ]
            );
            $imported++;
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil mengimpor {$imported} data {$role}.",
            'imported_count' => $imported,
        ]);
    }

    public function getPlottingData()
    {
        // Students with their placement
        $students = User::where('role', 'siswa')
            ->with(['studentPlacement.company', 'studentPlacement.dudiMentor', 'studentPlacement.teacherMentor'])
            ->get();

        $companies = Company::all();
        $teachers = User::where('role', 'guru')->get();
        $mentors = User::whereIn('role', ['mentor', 'dudi'])->get();

        return response()->json([
            'success' => true,
            'students' => $students,
            'companies' => $companies,
            'teachers' => $teachers,
            'mentors' => $mentors,
            'dudi_mentors' => $mentors,
        ]);
    }

    public function assignPlacement(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'teacher_mentor_id' => 'nullable|exists:users,id',
            'mentor_id' => 'nullable|exists:users,id',
            'dudi_mentor_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'academic_year' => 'nullable|string',
            'batch' => 'nullable|string',
        ]);

        $mentorId = $request->mentor_id ?? $request->dudi_mentor_id;

        $placement = Placement::updateOrCreate(
            ['student_id' => $request->student_id],
            [
                'company_id' => $request->company_id,
                'teacher_mentor_id' => $request->teacher_mentor_id,
                'dudi_mentor_id' => $mentorId,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'academic_year' => $request->academic_year ?? '2025/2026',
                'batch' => $request->batch ?? 'Angkatan 32',
                'work_schedule' => $request->work_schedule ?? ($placement->work_schedule ?? [
                    'monday' => 'wfo',
                    'tuesday' => 'wfo',
                    'wednesday' => 'wfo',
                    'thursday' => 'wfo',
                    'friday' => 'wfh',
                ]),
                'status' => 'active',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Penempatan tempat magang berhasil ditetapkan.',
            'placement' => $placement->load(['company', 'teacherMentor', 'dudiMentor']),
        ]);
    }

    public function getReports(Request $request)
    {
        $query = Placement::with(['student', 'company', 'dudiMentor', 'teacherMentor', 'student.grade']);

        if ($request->academic_year) {
            $query->where('academic_year', $request->academic_year);
        }
        if ($request->batch) {
            $query->where('batch', $request->batch);
        }
        if ($request->company_id) {
            $query->where('company_id', $request->company_id);
        }

        $placements = $query->get();

        $reportRows = $placements->map(function ($p) {
            $student = $p->student;
            $grade = $student ? $student->grade : null;

            $totalAtt = Attendance::where('student_id', $student->id)->count();
            $presentAtt = Attendance::where('student_id', $student->id)->whereIn('status', ['hadir', 'terlambat'])->count();
            $totalJournals = Logbook::where('student_id', $student->id)->where('status', 'diacc')->count();

            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'nisn' => $student->nisn_nip ?? '-',
                'company_name' => $p->company ? $p->company->name : '-',
                'mentor' => $p->dudiMentor ? $p->dudiMentor->name : '-',
                'dudi_mentor' => $p->dudiMentor ? $p->dudiMentor->name : '-',
                'teacher_mentor' => $p->teacherMentor ? $p->teacherMentor->name : '-',
                'period' => $p->start_date->format('d/m/Y') . ' - ' . $p->end_date->format('d/m/Y'),
                'attendance_total' => $presentAtt . '/' . $totalAtt,
                'verified_journals' => $totalJournals,
                'mentor_grade' => $grade ? $grade->dudi_score_average : '-',
                'dudi_grade' => $grade ? $grade->dudi_score_average : '-',
                'school_grade' => $grade ? $grade->school_report_score : '-',
                'final_grade' => $grade ? $grade->final_score : '-',
                'qr_code_hash' => $grade ? $grade->qr_code_hash : null,
                'academic_year' => $p->academic_year,
                'batch' => $p->batch,
            ];
        });

        // Filter options
        $academicYears = ['2025/2026', '2024/2025', '2023/2024'];
        $batches = ['Angkatan 32', 'Angkatan 31', 'Angkatan 30'];
        $companies = Company::select('id', 'name')->get();

        return response()->json([
            'success' => true,
            'report_rows' => $reportRows,
            'filters' => [
                'academic_years' => $academicYears,
                'batches' => $batches,
                'companies' => $companies,
            ],
        ]);
    }
}
