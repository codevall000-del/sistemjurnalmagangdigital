<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Placement;
use App\Models\Logbook;
use App\Models\Attendance;
use App\Models\Grade;

class GuruController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Advised students
        $placements = Placement::with(['student', 'company', 'dudiMentor'])
            ->where('teacher_mentor_id', $user->id)
            ->get();

        $studentsData = [];
        $systemAlerts = [];
        $today = Carbon::today();

        $totalActiveStudents = $placements->count();
        $totalJournalsAcc = 0;
        $totalJournalsPending = 0;

        foreach ($placements as $p) {
            $student = $p->student;
            if (!$student) continue;

            $totalAtt = Attendance::where('student_id', $student->id)->count();
            $presentAtt = Attendance::where('student_id', $student->id)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();
            $attPct = $totalAtt > 0 ? round(($presentAtt / $totalAtt) * 100, 1) : 100;

            $accCount = Logbook::where('student_id', $student->id)->where('status', 'diacc')->count();
            $pendingCount = Logbook::where('student_id', $student->id)->where('status', 'menunggu')->count();
            $totalJournalsAcc += $accCount;
            $totalJournalsPending += $pendingCount;

            // Check inactivity: last attendance or logbook date
            $lastAttendance = Attendance::where('student_id', $student->id)->orderBy('date', 'desc')->first();
            $lastLogbook = Logbook::where('student_id', $student->id)->orderBy('date', 'desc')->first();

            $lastActiveDate = null;
            if ($lastAttendance && $lastLogbook) {
                $lastActiveDate = $lastAttendance->date > $lastLogbook->date ? $lastAttendance->date : $lastLogbook->date;
            } elseif ($lastAttendance) {
                $lastActiveDate = $lastAttendance->date;
            } elseif ($lastLogbook) {
                $lastActiveDate = $lastLogbook->date;
            }

            $inactiveDays = $lastActiveDate ? $lastActiveDate->diffInDays($today) : 99;

            // System warning if inactive > 3 days
            if ($inactiveDays >= 3) {
                $systemAlerts[] = [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'company_name' => $p->company ? $p->company->name : '-',
                    'inactive_days' => $inactiveDays,
                    'last_activity' => $lastActiveDate ? $lastActiveDate->format('d M Y') : 'Belum pernah aktif',
                    'message' => "Siswa {$student->name} tidak mengisi presensi maupun jurnal selama {$inactiveDays} hari berturut-turut!",
                    'severity' => 'danger',
                ];
            }

            $studentsData[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'avatar' => $student->avatar,
                'company' => $p->company ? $p->company->name : '-',
                'dudi_mentor' => $p->dudiMentor ? $p->dudiMentor->name : '-',
                'attendance_pct' => $attPct,
                'journals_count' => $accCount + $pendingCount,
                'inactive_days' => $inactiveDays,
            ];
        }

        // Weekly activity trends for charts (Mon-Fri)
        $chartData = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            'attendance_series' => [92, 95, 88, 90, 85],
            'journal_series' => [85, 90, 82, 88, 80],
        ];

        return response()->json([
            'success' => true,
            'students' => $studentsData,
            'system_alerts' => $systemAlerts,
            'chart_data' => $chartData,
            'total_students' => $totalActiveStudents,
            'total_journals_acc' => $totalJournalsAcc,
            'total_journals_pending' => $totalJournalsPending,
        ]);
    }

    public function getStudents(Request $request)
    {
        $user = $request->user();
        $query = Placement::with(['student', 'company'])
            ->where('teacher_mentor_id', $user->id);

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn_nip', 'like', "%{$search}%");
            });
        }

        $placements = $query->get();

        $students = $placements->map(function ($p) {
            return [
                'id' => $p->student->id,
                'name' => $p->student->name,
                'nisn_nip' => $p->student->nisn_nip,
                'avatar' => $p->student->avatar,
                'company_name' => $p->company ? $p->company->name : '-',
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $students,
        ]);
    }

    public function monitorStudentLogbooks(Request $request, $studentId)
    {
        $student = User::with(['studentPlacement.company', 'studentPlacement.dudiMentor'])->findOrFail($studentId);

        $logbooks = Logbook::with('validator:id,name,role')
            ->where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get();

        $attendances = Attendance::where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'student' => $student,
            'logbooks' => $logbooks,
            'attendances' => $attendances,
        ]);
    }

    public function getGradesCompilation(Request $request)
    {
        $user = $request->user();

        $placements = Placement::with(['student', 'student.grade', 'company'])
            ->where('teacher_mentor_id', $user->id)
            ->get();

        $compilation = $placements->map(function ($p) {
            $student = $p->student;
            $grade = $student->grade;

            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'nisn_nip' => $student->nisn_nip,
                'avatar' => $student->avatar,
                'company_name' => $p->company ? $p->company->name : '-',
                'dudi_score_average' => $grade ? $grade->dudi_score_average : null,
                'is_dudi_finalized' => $grade ? $grade->is_finalized : false,
                'school_report_score' => $grade ? $grade->school_report_score : null,
                'final_score' => $grade ? $grade->final_score : null,
                'qr_code_hash' => $grade ? $grade->qr_code_hash : null,
            ];
        });

        return response()->json([
            'success' => true,
            'compilation' => $compilation,
        ]);
    }

    public function updateSchoolReportScore(Request $request, $studentId)
    {
        $request->validate([
            'school_report_score' => 'required|numeric|min:0|max:100',
        ]);

        $student = User::findOrFail($studentId);
        $grade = Grade::firstOrNew(['student_id' => $student->id]);

        $grade->school_report_score = $request->school_report_score;

        // Auto-calculate final grade: (DUDI 60% + School Report 40%)
        if ($grade->dudi_score_average !== null && $grade->dudi_score_average > 0) {
            $grade->final_score = round(($grade->dudi_score_average * 0.6) + ($request->school_report_score * 0.4), 2);
        } else {
            $grade->final_score = $request->school_report_score;
        }

        $grade->save();

        return response()->json([
            'success' => true,
            'message' => 'Nilai Laporan Sekolah berhasil disimpan dan Nilai Akhir PKL telah dikalkulasi.',
            'grade' => $grade,
        ]);
    }
}
