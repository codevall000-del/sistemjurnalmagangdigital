<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'title',
        'activity_description',
        'photo_url',
        'status', // menunggu, diacc, revisi
        'feedback_note',
        'is_auto_approved',
        'teacher_note',
        'teacher_noted_at',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'date' => 'date',
        'is_auto_approved' => 'boolean',
        'teacher_noted_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
