<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'dudi_score_discipline',
        'dudi_score_technical',
        'dudi_score_teamwork',
        'dudi_score_initiative',
        'dudi_score_average',
        'dudi_notes',
        'school_report_score',
        'final_score',
        'qr_code_hash',
        'is_finalized',
        'finalized_at',
    ];

    protected $casts = [
        'dudi_score_average' => 'float',
        'school_report_score' => 'float',
        'final_score' => 'float',
        'is_finalized' => 'boolean',
        'finalized_at' => 'datetime',
    ];

    protected $appends = [
        'mentor_score_average',
        'mentor_notes',
    ];

    public function getMentorScoreAverageAttribute()
    {
        return $this->dudi_score_average;
    }

    public function getMentorNotesAttribute()
    {
        return $this->dudi_notes;
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
