<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Logbook;
use App\Models\Placement;
use App\Models\Notification;
use App\Models\WorkModeRequest;
use App\Models\Company;

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

        // Check today's logbook
        $todayLogbook = Logbook::where('student_id', $user->id)
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

        // Work mode schedule determination
        $dayNames = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu',
        ];
        $currentDayKey = strtolower(Carbon::today()->format('l'));
        $currentDayName = $dayNames[$currentDayKey] ?? 'Hari Ini';

        $resolvedSchedule = $placement ? $placement->resolveWorkModeForDate($today) : [
            'mode' => 'wfo',
            'source' => 'default',
        ];

        // Active / today's work mode request
        $todayRequest = WorkModeRequest::where('student_id', $user->id)
            ->where('date', $today)
            ->first();

        // Recent requests (up to 5)
        $recentRequests = WorkModeRequest::where('student_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        $allowedWorkModes = $placement && $placement->company
            ? explode(',', $placement->company->allowed_work_modes ?? 'wfo,wfh,wfa')
            : ['wfo', 'wfh', 'wfa'];

        $weeklySchedule = $placement && $placement->work_schedule
            ? $placement->work_schedule
            : [
                'monday' => 'wfo',
                'tuesday' => 'wfo',
                'wednesday' => 'wfo',
                'thursday' => 'wfo',
                'friday' => 'wfh',
            ];

        // Recent notifications
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'user' => $user,
            'today_attendance' => $todayAttendance,
            'today_logbook' => $todayLogbook,
            'is_today_logged' => !is_null($todayLogbook),
            'can_check_in' => !$todayAttendance,
            'can_check_out' => $todayAttendance && !$todayAttendance->check_out,
            'attendance_percentage' => $attendancePercentage,
            'total_present' => $presentDays,
            'total_recorded' => $totalDays,
            'remaining_days' => $remainingDays,
            'notifications' => $notifications,
            'placement' => $placement,
            // Work schedule & mode policy
            'day_key' => $currentDayKey,
            'day_name' => $currentDayName,
            'today_work_mode' => $resolvedSchedule['mode'],
            'work_mode_info' => $resolvedSchedule,
            'is_today_holiday' => $resolvedSchedule['is_holiday'] ?? false,
            'holiday_reason' => $resolvedSchedule['holiday_name'] ?? null,
            'scheduled_check_in_time' => $resolvedSchedule['check_in_time'] ?? '07:30',
            'scheduled_check_out_time' => $resolvedSchedule['check_out_time'] ?? '16:00',
            'late_tolerance_minutes' => $resolvedSchedule['late_tolerance_minutes'] ?? 15,
            'office_schedule' => $placement && $placement->company ? $placement->company->getEffectiveSchedule() : Company::getDefaultOfficeSchedule(),
            'today_request' => $todayRequest,
            'recent_requests' => $recentRequests,
            'allowed_work_modes' => $allowedWorkModes,
            'weekly_schedule' => $weeklySchedule,
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

        $placement = Placement::with('company')->where('student_id', $user->id)->first();
        $resolved = $placement ? $placement->resolveWorkModeForDate($today) : ['mode' => 'wfo', 'source' => 'default', 'is_holiday' => false];
        $isHoliday = !empty($resolved['is_holiday']);
        $effectiveMode = $isHoliday ? 'wfo' : $resolved['mode'];

        $dayNames = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu',
        ];
        $currentDayKey = strtolower(Carbon::today()->format('l'));
        $currentDayName = $dayNames[$currentDayKey] ?? 'Hari Ini';

        $requestedWorkMode = $request->input('work_mode', $effectiveMode);

        // Security / Policy Validation: student cannot arbitrarily bypass assigned mode (unless holiday)
        if (!$isHoliday && $requestedWorkMode !== $effectiveMode) {
            return response()->json([
                'success' => false,
                'message' => "Jadwal resmi Anda hari ini ({$currentDayName}) adalah " . strtoupper($effectiveMode) . ". Untuk bekerja dengan mode " . strtoupper($requestedWorkMode) . ", silakan ajukan Permohonan Dispensasi terlebih dahulu kepada Pembimbing Lapangan.",
                'effective_mode' => $effectiveMode,
            ], 422);
        }

        $workMode = $isHoliday ? ($request->input('work_mode') ?: 'wfo') : $effectiveMode;
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        $distanceMeters = null;
        $isWithinRadius = true;

        if ($placement && $placement->company && $lat && $lng) {
            $compLat = (float) $placement->company->latitude;
            $compLng = (float) $placement->company->longitude;
            $radius = (int) ($placement->company->radius_meters ?? 150);

            // Haversine distance formula
            $earthRadius = 6371000;
            $latFrom = deg2rad((float) $lat);
            $lonFrom = deg2rad((float) $lng);
            $latTo = deg2rad($compLat);
            $lonTo = deg2rad($compLng);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            $distanceMeters = round($angle * $earthRadius);

            if ($workMode === 'wfo') {
                $isWithinRadius = ($distanceMeters <= $radius);
                if (!$isWithinRadius && $request->input('strict', false)) {
                    return response()->json([
                        'success' => false,
                        'message' => "Di luar radius kantor! Jarak Anda {$distanceMeters}m (maksimum {$radius}m dari {$placement->company->name}). Anda dijadwalkan WFO di kantor hari ini.",
                        'distance_meters' => $distanceMeters,
                        'allowed_radius' => $radius,
                    ], 422);
                }
            } else {
                // WFH and WFA waive geofence boundary restriction
                $isWithinRadius = true;
            }
        }

        // Dynamic status check based on scheduled hours and late tolerance
        $status = 'hadir';
        if (!$isHoliday) {
            $scheduledInStr = $resolved['check_in_time'] ?? '07:30';
            $tolerance = (int) ($resolved['late_tolerance_minutes'] ?? 15);
            $parsedTarget = Carbon::createFromFormat('H:i', substr($scheduledInStr, 0, 5))->addMinutes($tolerance);
            $nowTime = Carbon::createFromFormat('H:i:s', $currentTime);
            if ($nowTime->gt($parsedTarget)) {
                $status = 'terlambat';
            }
        }

        $sourceNote = $isHoliday
            ? " [Presensi Lembur / Sesi Mandiri di Hari Libur: " . ($resolved['holiday_name'] ?? 'Libur Kantor') . "]"
            : ($resolved['source'] === 'approved_request'
                ? " [Dispensasi Disetujui: " . ($resolved['reason'] ?? 'Izin Khusus') . "]"
                : " [Jadwal Resmi {$currentDayName}]");

        $notes = $request->input('notes', "Presensi " . strtoupper($workMode) . $sourceNote . " SMKN 71");

        $attendance = Attendance::create([
            'student_id' => $user->id,
            'date' => $today,
            'check_in' => $currentTime,
            'check_out' => null,
            'status' => $status,
            'work_mode' => $workMode,
            'latitude' => $lat,
            'longitude' => $lng,
            'distance_meters' => $distanceMeters,
            'is_within_radius' => $isWithinRadius,
            'notes' => $notes,
            'location_in' => $lat && $lng ? "{$lat}, {$lng}" : '-6.2301, 106.8228',
        ]);

        $modeLabel = strtoupper($workMode);
        return response()->json([
            'success' => true,
            'message' => "Check-In ({$modeLabel}) berhasil dicatat pada pukul {$currentTime} WIB.",
            'attendance' => $attendance,
            'work_mode' => $workMode,
            'work_mode_info' => $resolved,
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

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        $attendance->update([
            'check_out' => $currentTime,
            'location_out' => $lat && $lng ? "{$lat}, {$lng}" : ($attendance->location_in ?? '-6.2301, 106.8228'),
        ]);

        $isTodayLogged = Logbook::where('student_id', $user->id)->where('date', $today)->exists();

        return response()->json([
            'success' => true,
            'message' => 'Check-Out kepulangan berhasil dicatat pada pukul ' . $currentTime . ' WIB.' . (!$isTodayLogged ? ' Mohon segera lengkapi jurnal harian Anda!' : ''),
            'attendance' => $attendance,
            'is_today_logged' => $isTodayLogged,
        ]);
    }

    public function requestWorkMode(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'requested_mode' => 'required|in:wfo,wfh,wfa',
            'reason' => 'required|string|min:5|max:500',
        ]);

        $user = $request->user();
        $placement = Placement::with('company')->where('student_id', $user->id)->first();

        if (!$placement) {
            return response()->json(['success' => false, 'message' => 'Data penempatan magang tidak ditemukan.'], 422);
        }

        // Validate if company allows requested mode
        $allowedModes = explode(',', $placement->company->allowed_work_modes ?? 'wfo,wfh,wfa');
        if (!in_array($request->requested_mode, $allowedModes)) {
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan mitra (' . $placement->company->name . ') tidak mengizinkan mode ' . strtoupper($request->requested_mode) . '.',
            ], 422);
        }

        // Check if student already checked in for that date
        $alreadyAttended = Attendance::where('student_id', $user->id)->where('date', $request->date)->first();
        if ($alreadyAttended) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi pada tanggal tersebut, mode kerja tidak dapat diubah.',
            ], 422);
        }

        $existing = WorkModeRequest::where('student_id', $user->id)
            ->where('date', $request->date)
            ->first();

        if ($existing && $existing->status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Permohonan Anda untuk tanggal tersebut sudah disetujui sebelumnya (' . strtoupper($existing->requested_mode) . ').',
            ], 422);
        }

        if ($existing) {
            $existing->update([
                'requested_mode' => $request->requested_mode,
                'reason' => $request->reason,
                'status' => 'pending',
                'dudi_notes' => null,
            ]);
            $reqRecord = $existing;
        } else {
            $reqRecord = WorkModeRequest::create([
                'student_id' => $user->id,
                'placement_id' => $placement->id,
                'date' => $request->date,
                'requested_mode' => $request->requested_mode,
                'reason' => $request->reason,
                'status' => 'pending',
            ]);
        }

        // Notify field mentor
        if ($placement->dudi_mentor_id) {
            Notification::create([
                'user_id' => $placement->dudi_mentor_id,
                'title' => 'Permohonan Izin Mode Kerja: ' . $user->name,
                'message' => "Siswa {$user->name} mengajukan dispensasi " . strtoupper($request->requested_mode) . " untuk tanggal " . Carbon::parse($request->date)->format('d/m/Y') . ". Alasan: {$request->reason}",
                'type' => 'info',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permohonan beralih ke ' . strtoupper($request->requested_mode) . ' berhasil diajukan dan sedang menunggu persetujuan Pembimbing Lapangan.',
            'request' => $reqRecord,
        ]);
    }

    public function getWorkModeRequests(Request $request)
    {
        $user = $request->user();
        $requests = WorkModeRequest::with('reviewer:id,name')
            ->where('student_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'requests' => $requests,
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
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $thisWeek = Logbook::with('validator:id,name,role')
            ->where('student_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date', 'desc')
            ->get();

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

        // Notify field mentor if placement exists
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
