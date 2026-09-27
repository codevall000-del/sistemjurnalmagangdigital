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

class DudiController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Get all students mentored by this DUDI (or all students in the same company if mentor is null)
        $placements = Placement::with(['student', 'company'])
            ->where('dudi_mentor_id', $user->id)
            ->get();

        $students = [];
        $totalPendingAll = 0;

        foreach ($placements as $p) {
            $student = $p->student;
            if (!$student) continue;

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
            ];
        }

        return response()->json([
            'success' => true,
            'students' => $students,
            'total_active_students' => count($students),
            'total_pending_validations' => $totalPendingAll,
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

        $studentIds = $placements->pluck('student_id');

        $attendances = Attendance::with('student:id,name,nisn_nip,avatar')
            ->whereIn('student_id', $studentIds)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'attendances' => $attendances,
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
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'dudi_score_discipline' => 'required|numeric|min:0|max:100',
            'dudi_score_technical' => 'required|numeric|min:0|max:100',
            'dudi_score_teamwork' => 'required|numeric|min:0|max:100',
            'dudi_score_initiative' => 'required|numeric|min:0|max:100',
            'dudi_notes' => 'nullable|string',
        ]);

        $student = User::findOrFail($request->student_id);

        $avg = round((
            $request->dudi_score_discipline +
            $request->dudi_score_technical +
            $request->dudi_score_teamwork +
            $request->dudi_score_initiative
        ) / 4, 2);

        $grade = Grade::firstOrNew(['student_id' => $student->id]);
        $grade->dudi_score_discipline = $request->dudi_score_discipline;
        $grade->dudi_score_technical = $request->dudi_score_technical;
        $grade->dudi_score_teamwork = $request->dudi_score_teamwork;
        $grade->dudi_score_initiative = $request->dudi_score_initiative;
        $grade->dudi_score_average = $avg;
        $grade->dudi_notes = $request->dudi_notes;
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
            'title' => 'Nilai PKL DUDI Telah Difinalisasi',
            'message' => 'Pembimbing Industri telah menyelesaikan rubrik evaluasi dan memfinalisasi nilai rata-rata DUDI Anda (' . $avg . ').',
            'type' => 'success',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai evaluasi berhasil difinalisasi & QR Code telah diterbitkan.',
            'grade' => $grade,
        ]);
    }
}
