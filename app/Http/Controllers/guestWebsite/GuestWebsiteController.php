<?php

namespace App\Http\Controllers\guestWebsite;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Company;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;

class GuestWebsiteController extends Controller
{
     public function index()
     {
        $members = SettingWebsite::get();
        $student = Student::get();
        $trainer = Trainer::get();
        $company = Company::get();
        return view('guestWebsite.index',compact('student','trainer','company','members'));
     }
}
