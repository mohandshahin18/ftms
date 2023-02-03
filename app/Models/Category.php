<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name'];

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
}
