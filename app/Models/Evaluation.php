<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $guarded = [];

    // with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // with company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // with question
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
