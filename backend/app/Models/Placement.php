<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Placement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'dudi_mentor_id',
        'teacher_mentor_id',
        'start_date',
        'end_date',
        'academic_year',
        'batch',
        'default_work_mode',
        'work_schedule',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'work_schedule' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'dudi_mentor_id');
    }

    public function dudiMentor()
    {
        return $this->belongsTo(User::class, 'dudi_mentor_id');
    }

    public function teacherMentor()
    {
        return $this->belongsTo(User::class, 'teacher_mentor_id');
    }

    public function workModeRequests()
    {
        return $this->hasMany(WorkModeRequest::class, 'placement_id');
    }

    /**
     * Resolves the scheduled work mode based on day of week and requests.
     */
    public function resolveWorkModeForDate($date = null)
    {
        $targetDate = $date ? Carbon::parse($date) : Carbon::today();
        $formattedDate = $targetDate->format('Y-m-d');
        $dayKey = strtolower($targetDate->format('l')); // monday, tuesday, etc.

        // 1. Check if there's an approved override request for this date
        $approvedRequest = WorkModeRequest::where('placement_id', $this->id)
            ->where('date', $formattedDate)
            ->where('status', 'approved')
            ->first();

        if ($approvedRequest) {
            return [
                'mode' => $approvedRequest->requested_mode,
                'source' => 'approved_request',
                'reason' => $approvedRequest->reason,
                'request_id' => $approvedRequest->id,
                'is_holiday' => false,
            ];
        }

        // 2. Company office schedule
        $company = $this->relationLoaded('company') ? $this->company : $this->company()->first();
        $officeSchedule = $company ? $company->getEffectiveSchedule() : Company::getDefaultOfficeSchedule();

        // 2a. Check special holidays
        if (!empty($officeSchedule['special_holidays'])) {
            foreach ($officeSchedule['special_holidays'] as $h) {
                if (isset($h['date']) && $h['date'] === $formattedDate) {
                    return [
                        'mode' => 'libur',
                        'source' => 'special_holiday',
                        'holiday_name' => $h['name'] ?? 'Hari Libur Khusus',
                        'is_holiday' => true,
                    ];
                }
            }
        }

        // 2b. Check weekly day in office schedule
        $dayConfig = $officeSchedule['days'][$dayKey] ?? null;
        $isHoliday = $dayConfig && isset($dayConfig['is_work_day']) ? !$dayConfig['is_work_day'] : in_array($dayKey, ['saturday', 'sunday']);

        if ($isHoliday) {
            return [
                'mode' => 'libur',
                'source' => 'weekend_holiday',
                'holiday_name' => $dayConfig['notes'] ?? 'Libur Kantor / Akhir Pekan',
                'is_holiday' => true,
                'check_in_time' => null,
                'check_out_time' => null,
            ];
        }

        // 3. If student has individual placement work_schedule override
        $scheduledMode = null;
        if (is_array($this->work_schedule) && isset($this->work_schedule[$dayKey])) {
            $scheduledMode = $this->work_schedule[$dayKey];
        } elseif ($dayConfig && isset($dayConfig['mode'])) {
            $scheduledMode = $dayConfig['mode'];
        } else {
            $scheduledMode = $this->default_work_mode ?: 'wfo';
        }

        return [
            'mode' => $scheduledMode,
            'source' => is_array($this->work_schedule) && isset($this->work_schedule[$dayKey]) ? 'individual_schedule' : 'company_office_schedule',
            'is_holiday' => false,
            'day_key' => $dayKey,
            'check_in_time' => $dayConfig['check_in_time'] ?? '07:30',
            'check_out_time' => $dayConfig['check_out_time'] ?? '16:00',
            'late_tolerance_minutes' => $officeSchedule['late_tolerance_minutes'] ?? 15,
        ];
    }

    /**
     * Get the effective weekly schedule for this placement.
     */
    public function getEffectiveSchedule(): array
    {
        $company = $this->relationLoaded('company') ? $this->company : $this->company()->first();
        $officeSchedule = $company ? $company->getEffectiveSchedule() : Company::getDefaultOfficeSchedule();

        if (is_array($this->work_schedule) && !empty($this->work_schedule)) {
            $days = $officeSchedule['days'] ?? [];
            foreach ($this->work_schedule as $dayKey => $mode) {
                if (isset($days[$dayKey])) {
                    if ($mode === 'libur') {
                        $days[$dayKey]['is_work_day'] = false;
                        $days[$dayKey]['mode'] = 'libur';
                    } else {
                        $days[$dayKey]['is_work_day'] = true;
                        $days[$dayKey]['mode'] = $mode;
                    }
                }
            }
            $officeSchedule['days'] = $days;
        }

        return $officeSchedule;
    }
}
