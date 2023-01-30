<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Traits\AuthTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Rules\Password;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;
    use AuthTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function loginForm($type)
    {
        if($type == 'teacher' || $type == 'trainer'|| $type == 'company' || $type == 'admin'){
            return view('auth.login' , compact('type'));
        }else{
            return abort(404);
        }
    }

    public function login(Request $request)
    {


        // $password =Hash::make($request->password);
        // dd(new Password($request->type));

        if( $request->type == 'teacher'){
            $email ='exists:teachers,email';
            $password = 'in:teachers';
        }elseif($request->type == 'admin'){
            $email ='exists:admins,email';
            $password = 'in:admins';
        }elseif($request->type == 'company'){
            $email ='exists:companies,email';
            $password = 'in:companies';
        }elseif($request->type == 'trainer'){
            $email ='exists:trainers,email';
            $password = 'in:trainers,';
        }

        $this->validate($request, [

            'email'=> 'required|email|string| '.$email,
            'password'=>['required','string','min:3'],
        ]);

        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            $type =ucfirst($this->chekGuard($request));

            return $this->redirect($request)->with('msg', $type.' Login successfully ')->with('type','success');
         }
    }

    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/selection-guard');
    }



}
