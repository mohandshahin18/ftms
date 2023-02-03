<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCompany extends Model
{
    use HasFactory;

    public function companies()
    {
        return $this->belongsToMany(Category::class, Company::class,
        'category_company',
        'company_id',
        'category_id',
        'id',
        'id');
    }
}
