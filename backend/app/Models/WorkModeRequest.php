<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkModeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'placement_id',
        'date',
        'requested_mode',
        'reason',
        'status',
        'dudi_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    protected $appends = [
        'mentor_notes',
        'reviewer_notes',
    ];

    public function getMentorNotesAttribute()
    {
        return $this->dudi_notes;
    }

    public function getReviewerNotesAttribute()
    {
        return $this->dudi_notes;
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
