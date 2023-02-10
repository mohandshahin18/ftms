<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Trainer extends Authenticatable
{
    use HasFactory , Notifiable;

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


    // with company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // with task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
