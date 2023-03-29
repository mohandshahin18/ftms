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




    // Relations
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_company','company_id','category_id', 'id', 'id');
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

    // with advert
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }

}
