<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }
}
