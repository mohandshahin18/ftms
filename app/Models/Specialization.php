<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'slug'];

    public function university(){
        return $this->belongsToMany(University::class)->withDefault();
    }


    // with student
    public function students()
    {
        return $this->hasMany(Student::class);
    }

      // with teacher
      public function teachers()
      {
          return $this->hasMany(Teacher::class);
      }

      // with subsicribe
      public function subsicribes()
      {
          return $this->hasMany(Subsicribe::class);
      }
}
