<?php

namespace App\Http\Controllers\guestWebsite;

use App\Models\Company;
use App\Models\Student;
use App\Models\Trainer;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Models\SettingWebsite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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

     public function contact_us(Request $request)
     {

        $request->validate([
            'firstname' => 'required|String',
            'lastname' => 'required|String',
            'email' => 'required|email|', //ends_with:gmail.com
            'message'=> 'required',

        ]);

        // dd($request->firstname);
        $data = $request->except('_token');


        Mail::to('sha7in147@gmail.com')->send(new ContactMail($data));

        // return ;
     }
}
