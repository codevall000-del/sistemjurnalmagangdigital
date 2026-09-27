<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Logbook;
use App\Models\Placement;
use App\Models\Notification;

class SiswaController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');

        // Check today's attendance
        $todayAttendance = Attendance::where('student_id', $user->id)
            ->where('date', $today)
            ->first();

        // Calculate attendance stats
        $totalDays = Attendance::where('student_id', $user->id)->count();
        $presentDays = Attendance::where('student_id', $user->id)
            ->whereIn('status', ['hadir', 'terlambat'])
            ->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 1) : 100;

        // Calculate remaining internship days
        $placement = Placement::with(['company', 'dudiMentor', 'teacherMentor'])
            ->where('student_id', $user->id)
            ->first();

        $remainingDays = 0;
        if ($placement && $placement->end_date) {
            $endDate = Carbon::parse($placement->end_date);
            $now = Carbon::now();
            $remainingDays = max(0, $now->diffInDays($endDate, false));
        }

        // Recent notifications
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'today_attendance' => $todayAttendance,
            'can_check_in' => !$todayAttendance,
            'can_check_out' => $todayAttendance && !$todayAttendance->check_out,
            'attendance_percentage' => $attendancePercentage,
            'total_present' => $presentDays,
            'total_recorded' => $totalDays,
            'remaining_days' => $remainingDays,
            'notifications' => $notifications,
            'placement' => $placement,
        ]);
    }

    public function checkIn(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $existing = Attendance::where('student_id', $user->id)->where('date', $today)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan check-in hari ini.'], 422);
        }

        $status = Carbon::now()->hour >= 8 && Carbon::now()->minute > 0 ? 'terlambat' : 'hadir';

        $attendance = Attendance::create([
            'student_id' => $user->id,
            'date' => $today,
            'check_in' => $currentTime,
            'check_out' => null,
            'status' => $status,
            'notes' => $request->input('notes', 'Check-In Mandiri dari Aplikasi Desktop'),
            'location_in' => $request->input('location', '-6.2301, 106.8228'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-In berhasil dicatat pada pukul ' . $currentTime,
            'attendance' => $attendance,
        ]);
    }

    public function checkOut(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $attendance = Attendance::where('student_id', $user->id)->where('date', $today)->first();
        if (!$attendance) {
            return response()->json(['success' => false, 'message' => 'Anda belum melakukan check-in hari ini.'], 422);
        }

        if ($attendance->check_out) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan check-out hari ini.'], 422);
        }

        $attendance->update([
            'check_out' => $currentTime,
            'location_out' => $request->input('location', '-6.2301, 106.8228'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-Out berhasil dicatat pada pukul ' . $currentTime,
            'attendance' => $attendance,
        ]);
    }

    public function getAttendanceHistory(Request $request)
    {
        $user = $request->user();
        $attendances = Attendance::where('student_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'attendances' => $attendances,
        ]);
    }

    public function getLogbooks(Request $request)
    {
        $user = $request->user();

        // This week's logbooks
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $thisWeek = Logbook::with('validator:id,name,role')
            ->where('student_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date', 'desc')
            ->get();

        // All logbooks
        $allLogbooks = Logbook::with('validator:id,name,role')
            ->where('student_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'this_week' => $thisWeek,
            'all' => $allLogbooks,
        ]);
    }

    public function storeLogbook(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'activity_description' => 'required|string',
        ]);

        $user = $request->user();

        $logbook = Logbook::create([
            'student_id' => $user->id,
            'date' => $request->date,
            'title' => $request->title,
            'activity_description' => $request->activity_description,
            'photo_url' => $request->photo_url,
            'status' => 'menunggu',
        ]);

        // Notify DUDI mentor if placement exists
        $placement = Placement::where('student_id', $user->id)->first();
        if ($placement && $placement->dudi_mentor_id) {
            Notification::create([
                'user_id' => $placement->dudi_mentor_id,
                'title' => 'Jurnal Baru dari ' . $user->name,
                'message' => 'Siswa ' . $user->name . ' telah mengirimkan jurnal magang untuk tanggal ' . $request->date,
                'type' => 'info',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jurnal harian berhasil disimpan dan menunggu validasi.',
            'logbook' => $logbook,
        ]);
    }

    public function getPlacementInfo(Request $request)
    {
        $user = $request->user();

        $placement = Placement::with(['company', 'dudiMentor', 'teacherMentor'])
            ->where('student_id', $user->id)
            ->first();

        return response()->json([
            'success' => true,
            'placement' => $placement,
        ]);
    }
}
