<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    protected $guarded =[];

    // with company
    public function companies()
    {
        return $this->belongsToMany(Company::class)->withDefault();
    }
}
