<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory , SoftDeletes, Notifiable;
    protected $guarded = [];

    //with university
    public function university()
    {
        return $this->belongsTo(University::class)->withDefault();
    }

    //with specialization
    public function specialization()
    {
        return $this->belongsTo(Specialization::class)->withDefault();
    }

    //with teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }

    //with company
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    // with trainer
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }


    // with applied evaluations
    public function applied_evaluation()
    {
        return $this->hasOne(AppliedEvaluation::class)->withDefault();
    }


    // with applied task
    public function applied_tasks()
    {
        return $this->hasMany(AppliedTasks::class);
    }

    // with application
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    // with comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
