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
        $totalDudi = User::where('role', 'dudi')->count();
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

        // Server sync status (simulating central sync state for desktop application)
        $syncStatus = [
            'status' => 'synchronized',
            'last_synced_at' => Carbon::now()->subMinutes(12)->format('d M Y H:i:s'),
            'pending_records' => 0,
            'server_health' => 'optimal',
            'storage_used' => '42.8 MB / 10 GB',
            'database_version' => 'SQLite 3.42 (WAL Mode Active)',
        ];

        return response()->json([
            'success' => true,
            'stats' => [
                'total_students' => $totalStudents,
                'total_dudi' => $totalDudi,
                'total_guru' => $totalGuru,
                'total_companies' => $totalCompanies,
                'active_placements' => $totalPlacements,
            ],
            'distribution' => $distribution,
            'sync_status' => $syncStatus,
        ]);
    }

    public function getMasterData(Request $request)
    {
        $role = $request->input('role', 'siswa'); // siswa, dudi, guru
        $search = $request->input('search');

        $query = User::where('role', $role);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:siswa,dudi,guru',
            'nisn_nip' => 'nullable|string',
            'phone' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nisn_nip' => $request->nisn_nip,
            'phone' => $request->phone,
            'password' => Hash::make($request->password ?? 'password123'),
            'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data pengguna berhasil ditambahkan.',
            'user' => $user,
        ]);
    }

    public function updateMasterData(Request $request, $id)
    {
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

    public function deleteMasterData($id)
    {
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
        $dudiMentors = User::where('role', 'dudi')->get();

        return response()->json([
            'success' => true,
            'students' => $students,
            'companies' => $companies,
            'teachers' => $teachers,
            'dudi_mentors' => $dudiMentors,
        ]);
    }

    public function assignPlacement(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'teacher_mentor_id' => 'nullable|exists:users,id',
            'dudi_mentor_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'academic_year' => 'nullable|string',
            'batch' => 'nullable|string',
        ]);

        $placement = Placement::updateOrCreate(
            ['student_id' => $request->student_id],
            [
                'company_id' => $request->company_id,
                'teacher_mentor_id' => $request->teacher_mentor_id,
                'dudi_mentor_id' => $request->dudi_mentor_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'academic_year' => $request->academic_year ?? '2025/2026',
                'batch' => $request->batch ?? 'Angkatan 32',
                'status' => 'active',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Penempatan berhasil ditetapkan.',
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
                'dudi_mentor' => $p->dudiMentor ? $p->dudiMentor->name : '-',
                'teacher_mentor' => $p->teacherMentor ? $p->teacherMentor->name : '-',
                'period' => $p->start_date->format('d/m/Y') . ' - ' . $p->end_date->format('d/m/Y'),
                'attendance_total' => $presentAtt . '/' . $totalAtt,
                'verified_journals' => $totalJournals,
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
