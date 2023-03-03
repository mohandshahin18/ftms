<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Teacher extends Authenticatable
{
    use HasFactory , Notifiable ;
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

    // with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
