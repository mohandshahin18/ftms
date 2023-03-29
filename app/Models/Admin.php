<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory ,Notifiable;

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

<<<<<<< HEAD
    // with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // with role
    public function role()
    {
        return $this->belongsTo(Role::class)->withDefault();
    }
=======
    
>>>>>>> 5fac50ed4736d30afbd2aa4575421f5981d3751c
}
