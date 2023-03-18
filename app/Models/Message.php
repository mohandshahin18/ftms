<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];


    // with student
    public function student()
    {
        return $this->belongsTo(Student::class)->withDefault();
    }
    // with trinaer
    public function trinaer()
    {
        return $this->belongsTo(Trainer::class)->withDefault();
    }
    // with teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }
    // with admin
    public function admin()
    {
        return $this->belongsTo(Admin::class)->withDefault();
    }
}
