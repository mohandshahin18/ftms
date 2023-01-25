<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'evaluation_id'];

    // with evaluation
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
