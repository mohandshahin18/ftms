<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_Verify extends Model
{
    use HasFactory;

    public $table = "users_verifies";

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'student_id',
        'token',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
