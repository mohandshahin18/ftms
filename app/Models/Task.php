<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    // with category
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    // with trainer 
    public function trainer()
    {
        return $this->belongsTo(Trainer::class)->withDefault();
    }

    // with applied tasks
    public function applied_tasks()
    {
        return $this->hasMany(AppliedTasks::class);
    }
}
