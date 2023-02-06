<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedTasks extends Model
{
    use HasFactory;

    protected $guarded = [];

    // with student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // with task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
