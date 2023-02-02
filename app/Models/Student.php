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


    // with applied evaluations
    public function applied_evaluation()
    {
        return $this->hasOne(AppliedEvaluation::class)->withDefault();
    }


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
}
