<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'university_id'];

    public function university(){
        return $this->belongsTo(University::class)->withDefault();
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
}
