<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecilaizationUniversity extends Model
{
    use HasFactory;

    public function universities()
    {
        return $this->belongsToMany(Specialization::class, University::class,
        'specialization_university',
        'specialization_id',
        'university_id',
        'id',
        'id');
    }
}
