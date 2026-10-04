<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // siswa, mentor (pembimbing lapangan), guru, admin
        'nisn_nip',
        'phone',
        'major',
        'class_name',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentPlacement()
    {
        return $this->hasOne(Placement::class, 'student_id');
    }

    public function mentorPlacements()
    {
        return $this->hasMany(Placement::class, 'dudi_mentor_id');
    }

    public function dudiPlacements()
    {
        return $this->hasMany(Placement::class, 'dudi_mentor_id');
    }

    public function teacherPlacements()
    {
        return $this->hasMany(Placement::class, 'teacher_mentor_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'student_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'student_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
