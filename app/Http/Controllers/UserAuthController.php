<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserAuthController extends Controller
{
    public function showLogin($guard){
        if($guard == 'trainer' || $guard == 'teacher' ){
            return response()->view('auth.login' , compact('guard'));

        }else{
            return 'ldkjfldskj';
        }
    }


    public function teacherLogin(Request $request){
        // dd(Auth::guard($request->get('guard')) );
        $request->validate([
            'email' => 'required|email|exists:teachers,email',
            'password' => 'required|string|min:4|in:teachers,password'
        ] , [
            'email.required' => 'Please Enter Your Email',
            'email.email' => 'Must Be An Email',
            'email.exists' => 'The Email Dos not exist',
            'password.required' => "Please Enter Your Password",
            'password.in' => "Your Password Is Incorrect",
        ]);
        
        $credintial = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if(Auth::guard($request->get('guard'))->attempt($credintial )){
            return redirect()->route('admin.teachers.index')->with('msg','teacher login success');
        }else{
            // return 'dfkljdlks';
            return redirect()->back()->with('msg', 'error in email or password')->with('type','danger');
        }

        
    }



}
