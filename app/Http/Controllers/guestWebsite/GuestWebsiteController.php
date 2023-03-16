<?php

namespace App\Http\Controllers\guestWebsite;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Company;
use Illuminate\Http\Request;

class GuestWebsiteController extends Controller
{
     public function index()
     {
        $student = Student::get();
        $trainer = Trainer::get();
        $company = Company::get();
        return view('guestWebsite.index',compact('student','trainer','company'));
     }
}
