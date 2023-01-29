<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedEvaluation extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
