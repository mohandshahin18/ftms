<?php

namespace App\Http\Controllers\guestWebsite;

use App\Models\Comment;
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
        $comments = Comment::with('student')->latest('id')->limit(20)->get();



        return view('guestWebsite.index',compact('student','trainer','company','members','comments'));
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


        Mail::to('ftms.website@gmail.com')->send(new ContactMail($data));

        // return ;
     }
}
