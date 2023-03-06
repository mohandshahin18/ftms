<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Traits\AuthTrait;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;

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

    // login to control panel

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

        if( $request->type == 'teacher'){
            $email ='exists:teachers,email';
            $user = Teacher::where('email', $request->email)->first();
        }elseif($request->type == 'admin'){
            $email ='exists:admins,email';
            $user = Admin::where('email', $request->email)->first();
        }elseif($request->type == 'company'){
            $email ='exists:companies,email';
            $user = Company::where('email', $request->email)->first();
        }elseif($request->type == 'trainer'){
            $email ='exists:trainers,email';
            $user = Trainer::where('email', $request->email)->first();
        }

        $this->validate($request, [

            'email'=> 'required|email|string| '.$email,
            'password'=>['required','string','min:3'],
        ], [
            'email.exists' => ' The selected email is invalid.'
        ]);

        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            $type =ucfirst($this->chekGuard($request));
            $name = $user->name;
            $firstname = substr($name, 0, strpos($name, " "));


            return $this->redirect($request)->with('login',__('admin.Welcome back'). $firstname.' ! ' )->with('login_type','warning');
         }else {
            return redirect()->back()->with('msg' ,__('admin.The selected email or password is invalid.'))->with('type','danger');
         }
    }

    // logout from control panel
    public function logout(Request $request,$type)
    {
        // dd();

        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if( $request->type == 'admin' ||$request->type == 'teacher' ||
         $request->type == 'company' || $request->type == 'trainer'  ){

            return redirect('selection-type');

        }elseif(Auth::guard('student')){
            return redirect('students');
        }

    }


    // login to website
    public function loginForm_student()
    {
        return view('auth.login-student');

    }

    public function login_studens(Request $request)
    {

        $this->validate($request, [

            'email'=> 'required|email|string|',
            'password'=>['required','string','min:3'],
        ]);

        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('student.home')->with('msg', ' Welcome back ')->with('type','success');
         }else {
            return redirect()->back()->with('msg' ,__('admin.The selected email or password is invalid.'))->with('type','danger');
         }
    }

}
