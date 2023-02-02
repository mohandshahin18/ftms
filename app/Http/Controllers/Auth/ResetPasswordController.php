<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;


    public function editPassword($type)
    {
        if($type == 'teacher' || $type == 'trainer'|| $type == 'company' || $type == 'admin'){
            return view('admin.resetPassword' , compact('type'));
        }elseif($type == 'student'){
            return view('student.resetPassword' );
        }else{
            return abort(404);

        }
    }

    public function updatePassword(Request $request ){


        $request->validate([
        'current_password'=>'required',
        'new_password'=>'required|string|min:6|max:25|confirmed',
        'new_password_confirmation'=>'required'
        ], [
        'current_password.required'=> "The current password field is required.",
        ]);



            $student = Auth::guard()->user();

            //Match The current Password
            if(!Hash::check($request->current_password, $student->password)){
                return redirect()->back()->with('msg' , "The Current Password Doesn't match!")->with('type' , 'danger') ;
            }
            elseif (Hash::check($request->current_password, $student->password) && Hash::check($request->new_password, $student->password)) {
                return redirect()->back()->with('msg' , 'The new password can not be the current password!')->with('type' , 'danger') ;
            } //new password can not be the current password!
            else{
                $student->password = Hash::make($request->new_password);
                $student->save();
                return redirect()->back()->with('msg' , 'Updated Password is successfully')->with('type','success') ;
            }
        }
    
}
