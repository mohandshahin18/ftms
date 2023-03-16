<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    protected $guarded =[];

    // with company
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    // with trainer
    public function trainer()
    {
        return $this->belongsTo(Trainer::class)->withDefault();
    }

    // with teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class)->withDefault();
    }
}
