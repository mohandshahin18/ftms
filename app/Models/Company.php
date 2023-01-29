<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Company extends Authenticatable
{
    use HasFactory, SoftDeletes ,Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



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

    // with evaluation
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
