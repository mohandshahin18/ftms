<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class);
    }
}
