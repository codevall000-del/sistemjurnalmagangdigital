<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'work_mode',
        'latitude',
        'longitude',
        'distance_meters',
        'is_within_radius',
        'notes',
        'location_in',
        'location_out',
        'is_dispute',
        'dispute_reason',
        'dispute_status',
        'dispute_resolved_by',
        'dispute_resolved_at',
    ];

    protected $casts = [
        'date' => 'date',
        'is_dispute' => 'boolean',
        'is_within_radius' => 'boolean',
        'dispute_resolved_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function disputeResolver()
    {
        return $this->belongsTo(User::class, 'dispute_resolved_by');
    }
}
