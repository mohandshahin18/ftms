<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function specializations(){
        return $this->hasMany(Specialization::class);
    }


    public function teachers(){
        return $this->hasMany(Teacher::class);
    }


    protected static function boot() {
        parent::boot();

        static::deleting(function($university) {
            $university->specializations()->delete();
            // $university->specializations()->delete();

        });
    }
}
