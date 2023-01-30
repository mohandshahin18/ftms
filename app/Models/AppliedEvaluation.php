<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedEvaluation extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    // with student
    public function student()
    {
        return $this->belongsTo(Student::class)->withDefault();
    }

    // with company
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    // with evaluation
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class)->withDefault();
    }
}
