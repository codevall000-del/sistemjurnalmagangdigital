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
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'date' => 'date',
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
