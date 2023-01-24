<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function university(){
        return $this->belongsTo(University::class)->withDefault();
    }

    // with student
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // with specialization
    public function specialization()
    {
        return $this->belongsTo(Specialization::class)->withDefault();
    }
}
