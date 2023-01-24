<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $guarded = [];


    // with specialization
    public function specializations(){
        return $this->hasMany(Specialization::class);
    }

    // with teacher
    public function teachers(){
        return $this->hasMany(Teacher::class);
    }

    // with student
    public function students()
    {
        return $this->hasMany(Student::class);
    }


}
