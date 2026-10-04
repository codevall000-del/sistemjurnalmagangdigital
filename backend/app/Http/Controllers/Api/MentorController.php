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
use App\Models\Notification;
use App\Models\WorkModeRequest;
use App\Models\Company;

class MentorController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Get all students mentored by this Pembimbing Lapangan
        $placements = Placement::with(['student', 'company'])
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $students = [];
        $totalPendingAll = 0;
        $studentIds = [];

        foreach ($placements as $p) {
            $student = $p->student;
            if (!$student) continue;

            $studentIds[] = $student->id;

            $pendingCount = Logbook::where('student_id', $student->id)
                ->where('status', 'menunggu')
                ->count();

            $totalPendingAll += $pendingCount;

            $totalAttendances = Attendance::where('student_id', $student->id)->count();
            $presentCount = Attendance::where('student_id', $student->id)
                ->whereIn('status', ['hadir', 'terlambat'])
                ->count();
            $attPct = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 1) : 100;

            $lastLogbook = Logbook::where('student_id', $student->id)
                ->orderBy('date', 'desc')
                ->first();

            $resolvedToday = $p->resolveWorkModeForDate();

            $students[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'avatar' => $student->avatar,
                'nisn_nip' => $student->nisn_nip,
                'phone' => $student->phone,
                'company_name' => $p->company ? $p->company->name : '-',
                'pending_journals' => $pendingCount,
                'attendance_pct' => $attPct,
                'last_activity' => $lastLogbook ? $lastLogbook->date->format('d M Y') : 'Belum ada',
                'batch' => $p->batch,
                'today_work_mode' => $resolvedToday['mode'],
                'today_source' => $resolvedToday['source'],
            ];
        }

        $pendingRequestsCount = WorkModeRequest::whereIn('student_id', $studentIds)
            ->where('status', 'pending')
            ->count();

        return response()->json([
            'success' => true,
            'students' => $students,
            'total_active_students' => count($students),
            'total_pending_validations' => $totalPendingAll,
            'total_pending_requests' => $pendingRequestsCount,
        ]);
    }

    public function getStudents(Request $request)
    {
        $user = $request->user();
        $placements = Placement::with('student')
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $students = $placements->map(function ($p) {
            $pendingCount = Logbook::where('student_id', $p->student->id)
                ->where('status', 'menunggu')
                ->count();

            return [
                'id' => $p->student->id,
                'name' => $p->student->name,
                'email' => $p->student->email,
                'avatar' => $p->student->avatar,
                'nisn_nip' => $p->student->nisn_nip,
                'pending_journals' => $pendingCount,
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $students,
        ]);
    }

    public function getStudentLogbooks(Request $request, $studentId)
    {
        $student = User::findOrFail($studentId);
        $logbooks = Logbook::with('validator:id,name')
            ->where('student_id', $studentId)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'student' => $student,
            'logbooks' => $logbooks,
        ]);
    }

    public function validateLogbook(Request $request, $logbookId)
    {
        $request->validate([
            'status' => 'required|in:diacc,revisi',
            'feedback_note' => 'nullable|string',
        ]);

        $user = $request->user();
        $logbook = Logbook::findOrFail($logbookId);

        $logbook->update([
            'status' => $request->status,
            'feedback_note' => $request->feedback_note,
            'validated_by' => $user->id,
            'validated_at' => Carbon::now(),
        ]);

        // Send notification to student
        $actionText = $request->status === 'diacc' ? 'telah disetujui (Di-ACC)' : 'memerlukan revisi';
        $type = $request->status === 'diacc' ? 'success' : 'warning';

        Notification::create([
            'user_id' => $logbook->student_id,
            'title' => 'Status Logbook: ' . ($request->status === 'diacc' ? 'Disetujui' : 'Perlu Revisi'),
            'message' => 'Jurnal Anda untuk tanggal ' . $logbook->date->format('d/m/Y') . ' ' . $actionText . '. Catatan: ' . ($request->feedback_note ?? '-'),
            'type' => $type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil ' . ($request->status === 'diacc' ? 'di-ACC' : 'ditolak/diminta revisi') . '.',
            'logbook' => $logbook,
        ]);
    }

    public function getAttendanceRecap(Request $request)
    {
        $user = $request->user();
        $placements = Placement::with('student')
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $studentIds = $placements->pluck('student_id')->filter()->toArray();

        $today = Carbon::today()->format('Y-m-d');
        $attendances = Attendance::with('student:id,name,nisn_nip,avatar,class_name')
            ->whereIn('student_id', $studentIds)
            ->where('date', $today)
            ->get();

        return response()->json([
            'success' => true,
            'date' => $today,
            'attendances' => $attendances,
        ]);
    }

    public function getWorkModeRequests(Request $request)
    {
        $user = $request->user();
        $placements = Placement::with(['student', 'company'])
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $studentIds = $placements->pluck('student_id')->filter()->toArray();

        $requests = WorkModeRequest::with('student:id,name,nisn_nip,avatar,class_name')
            ->whereIn('student_id', $studentIds)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'requests' => $requests,
        ]);
    }

    public function reviewWorkModeRequest(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'mentor_notes' => 'nullable|string',
            'dudi_notes' => 'nullable|string',
        ]);

        $user = $request->user();
        $req = WorkModeRequest::findOrFail($id);
        $notes = $request->input('mentor_notes', $request->input('dudi_notes'));

        $req->update([
            'status' => $request->status,
            'dudi_notes' => $notes,
            'reviewed_by' => $user->id,
            'reviewed_at' => Carbon::now(),
        ]);

        // Send notification to student
        $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        Notification::create([
            'user_id' => $req->student_id,
            'title' => 'Permohonan Mode Kerja ' . ucfirst($statusText),
            'message' => "Permohonan mode kerja " . strtoupper($req->requested_mode) . " Anda untuk tanggal {$req->date->format('d/m/Y')} telah {$statusText} oleh Pembimbing Lapangan. Catatan: " . ($notes ?? '-'),
            'type' => $request->status === 'approved' ? 'success' : 'warning',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Permohonan berhasil {$statusText}.",
            'request' => $req,
        ]);
    }

    public function getStudentsWithSchedules(Request $request)
    {
        $user = $request->user();

        $placements = Placement::with(['student', 'company'])
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $data = $placements->map(function ($p) {
            $effective = $p->getEffectiveSchedule();
            return [
                'placement_id' => $p->id,
                'student_id' => $p->student ? $p->student->id : null,
                'student_name' => $p->student ? $p->student->name : '-',
                'nisn_nip' => $p->student ? $p->student->nisn_nip : '-',
                'avatar' => $p->student ? $p->student->avatar : null,
                'class_name' => $p->student ? $p->student->class_name : '-',
                'company_name' => $p->company ? $p->company->name : '-',
                'has_custom_schedule' => !empty($p->work_schedule),
                'schedule' => $effective,
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $data,
        ]);
    }

    public function updateStudentSchedule(Request $request, $placementId)
    {
        $user = $request->user();
        $placement = Placement::where('id', $placementId)
            ->where('dudi_mentor_id', $user->id)
            ->firstOrFail();

        $request->validate([
            'schedule' => 'nullable|array',
            'reset_to_default' => 'nullable|boolean',
        ]);

        if ($request->reset_to_default) {
            $placement->work_schedule = null;
        } else {
            $placement->work_schedule = $request->schedule;
        }

        $placement->save();

        if ($placement->student_id) {
            Notification::create([
                'user_id' => $placement->student_id,
                'title' => 'Jadwal Kerja Tempat Magang Diperbarui',
                'message' => 'Pembimbing Lapangan telah memperbarui jadwal kerja mingguan (WFO/WFH) untuk Anda.',
                'type' => 'info',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jadwal kerja siswa berhasil diperbarui.',
            'schedule' => $placement->getEffectiveSchedule(),
        ]);
    }

    public function getCompanyOfficeSchedule(Request $request)
    {
        $user = $request->user();

        $placement = Placement::where('dudi_mentor_id', $user->id)->first();
        $company = $placement ? $placement->company : null;

        if (!$company) {
            $company = Company::first();
        }

        $schedule = $company ? $company->getEffectiveSchedule() : Company::getDefaultOfficeSchedule();

        return response()->json([
            'success' => true,
            'company_id' => $company ? $company->id : null,
            'company_name' => $company ? $company->name : 'Tempat Magang',
            'schedule' => $schedule,
        ]);
    }

    public function updateCompanyOfficeSchedule(Request $request)
    {
        $user = $request->user();

        $placement = Placement::where('dudi_mentor_id', $user->id)->first();
        $company = $placement ? $placement->company : null;

        if (!$company) {
            $company = Company::first();
        }

        if (!$company) {
            return response()->json(['success' => false, 'message' => 'Data tempat magang tidak ditemukan.'], 404);
        }

        $request->validate([
            'schedule' => 'required|array',
        ]);

        $company->office_schedule = $request->schedule;
        $company->save();

        return response()->json([
            'success' => true,
            'message' => "Jadwal operasional tempat magang ({$company->name}) berhasil diperbarui.",
            'schedule' => $company->getEffectiveSchedule(),
        ]);
    }

    public function getEvaluations(Request $request)
    {
        $user = $request->user();

        $placements = Placement::with(['student', 'student.grade'])
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $evaluations = $placements->map(function ($p) {
            $student = $p->student;
            $grade = $student->grade;

            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'nisn_nip' => $student->nisn_nip,
                'avatar' => $student->avatar,
                'grade' => $grade,
                'is_finalized' => $grade ? $grade->is_finalized : false,
            ];
        });

        return response()->json([
            'success' => true,
            'evaluations' => $evaluations,
        ]);
    }

    public function storeEvaluation(Request $request)
    {
        $discipline = $request->input('mentor_score_discipline', $request->input('dudi_score_discipline'));
        $technical = $request->input('mentor_score_technical', $request->input('dudi_score_technical'));
        $teamwork = $request->input('mentor_score_teamwork', $request->input('dudi_score_teamwork'));
        $initiative = $request->input('mentor_score_initiative', $request->input('dudi_score_initiative'));
        $notes = $request->input('mentor_notes', $request->input('dudi_notes'));

        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        if ($discipline === null || $technical === null || $teamwork === null || $initiative === null) {
            return response()->json([
                'success' => false,
                'message' => 'Semua komponen rubrik nilai (Disiplin, Teknis, Tim, Inisiatif) wajib diisi.',
            ], 422);
        }

        $student = User::findOrFail($request->student_id);

        $avg = round((
            floatval($discipline) +
            floatval($technical) +
            floatval($teamwork) +
            floatval($initiative)
        ) / 4, 2);

        $grade = Grade::firstOrNew(['student_id' => $student->id]);
        $grade->dudi_score_discipline = $discipline;
        $grade->dudi_score_technical = $technical;
        $grade->dudi_score_teamwork = $teamwork;
        $grade->dudi_score_initiative = $initiative;
        $grade->dudi_score_average = $avg;
        $grade->dudi_notes = $notes;
        $grade->is_finalized = true;
        $grade->finalized_at = Carbon::now();

        // Calculate final score if school report score already exists
        if ($grade->school_report_score !== null) {
            $grade->final_score = round(($avg * 0.6) + ($grade->school_report_score * 0.4), 2);
        }

        // Generate unique QR verification hash
        $qrHash = 'PKL-VERIFY-' . strtoupper(substr(md5($student->id . $avg . time()), 0, 16));
        $grade->qr_code_hash = $qrHash;
        $grade->save();

        Notification::create([
            'user_id' => $student->id,
            'title' => 'Nilai PKL Pembimbing Lapangan Telah Difinalisasi',
            'message' => 'Pembimbing Lapangan telah menyelesaikan rubrik evaluasi dan memfinalisasi nilai rata-rata Tempat Magang Anda (' . $avg . ').',
            'type' => 'success',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai evaluasi berhasil difinalisasi & QR Code telah diterbitkan.',
            'grade' => $grade,
        ]);
    }
}
