<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //with trainers
    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    // with student
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
