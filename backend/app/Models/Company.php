<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sector',
        'address',
        'phone',
        'email',
        'website',
        'quota',
        'latitude',
        'longitude',
        'radius_meters',
        'allowed_work_modes',
        'office_schedule',
    ];

    protected $casts = [
        'office_schedule' => 'array',
    ];

    /**
     * Default office schedule template.
     */
    public static function getDefaultOfficeSchedule(): array
    {
        return [
            'work_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            'days' => [
                'monday' => ['is_work_day' => true, 'mode' => 'wfo', 'check_in_time' => '07:30', 'check_out_time' => '16:00', 'notes' => 'WFO di Kantor'],
                'tuesday' => ['is_work_day' => true, 'mode' => 'wfh', 'check_in_time' => '07:30', 'check_out_time' => '16:00', 'notes' => 'WFH Mandiri (Pola BKKBN)'],
                'wednesday' => ['is_work_day' => true, 'mode' => 'wfo', 'check_in_time' => '07:30', 'check_out_time' => '16:00', 'notes' => 'WFO di Kantor'],
                'thursday' => ['is_work_day' => true, 'mode' => 'wfh', 'check_in_time' => '07:30', 'check_out_time' => '16:00', 'notes' => 'WFH Mandiri (Pola BKKBN)'],
                'friday' => ['is_work_day' => true, 'mode' => 'wfo', 'check_in_time' => '07:30', 'check_out_time' => '16:30', 'notes' => 'WFO di Kantor & Evaluasi'],
                'saturday' => ['is_work_day' => false, 'mode' => 'libur', 'check_in_time' => null, 'check_out_time' => null, 'notes' => 'Libur Akhir Pekan'],
                'sunday' => ['is_work_day' => false, 'mode' => 'libur', 'check_in_time' => null, 'check_out_time' => null, 'notes' => 'Libur Akhir Pekan'],
            ],
            'late_tolerance_minutes' => 15,
            'policy_name' => 'Sistem Kerja Hybrid Kantor (WFO / WFH Terjadwal)',
            'policy_description' => 'Jadwal operasional mingguan kantor: Masuk pukul 07:30 WIB, Pulang pukul 16:00 WIB (Jumat 16:30). Menerapkan sistem WFH terjadwal seperti regulasi instansi BKKBN pada hari Selasa & Kamis. Sabtu dan Minggu libur.',
            'special_holidays' => [],
        ];
    }

    public function getEffectiveSchedule(): array
    {
        return !empty($this->office_schedule) ? array_merge(self::getDefaultOfficeSchedule(), $this->office_schedule) : self::getDefaultOfficeSchedule();
    }

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
