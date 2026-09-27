<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function dudiMentor()
    {
        return $this->belongsTo(User::class, 'dudi_mentor_id');
    }

    public function teacherMentor()
    {
        return $this->belongsTo(User::class, 'teacher_mentor_id');
    }
}
