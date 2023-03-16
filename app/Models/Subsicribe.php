<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsicribe extends Model
{
    use HasFactory;

    protected $fillable = ['name','student_id','specialization_id','university_id'];

     // with specialization
     public function specialization()
     {
         return $this->belongsTo(Specialization::class);
     }

     // with university
     public function university()
     {
         return $this->belongsTo(University::class);
     }
}
