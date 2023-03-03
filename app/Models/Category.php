<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name','slug'];

    // with company
    public function companies()
    {
        return $this->belongsToMany(Company::class,'category_company','category_id','company_id', 'id', 'id');
    }

    // with task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    // with tariners
    public function tariners()
    {
        return $this->hasMany(Trainer::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
