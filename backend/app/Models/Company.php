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
    ];

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
