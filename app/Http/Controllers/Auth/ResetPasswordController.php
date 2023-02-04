<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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


     /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm($type)
      {
        if($type == 'teacher' || $type == 'trainer'|| $type == 'company' || $type == 'admin' || $type == 'student'){
            return view('auth.forgetPassword',compact('type'));
        }else{
            return abort(404);
        }

      }


      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {

        if( $request->type == 'teacher'){
            $email ='exists:teachers,email';
        }elseif($request->type == 'admin'){
            $email ='exists:admins,email';
        }elseif($request->type == 'company'){
            $email ='exists:companies,email';
        }elseif($request->type == 'trainer'){
            $email ='exists:trainers,email';
        }elseif($request->type == 'student'){
            $email ='exists:students,email';

        }
        $request->validate([
            'email'=> 'required|email|string| '.$email
        ]);

        $type = $request->type;
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'type' => $type,
            'created_at' => Carbon::now()
          ]);

        //   dd($type);
        Mail::send('emails.forgetPassword', compact('type','token'), function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });



          return back()->with('msg', 'We have e-mailed your password reset link!')->with('type','warning');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm( $type,$token ) {
        if($type == 'teacher' || $type == 'trainer'|| $type == 'company' || $type == 'admin' || $type == 'student'){
            return view('auth.forgetPasswordLink', compact('type' ,'token') );
        }else{
            return abort(404);
        }
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {

        if( $request->type == 'teacher'){
            $email ='exists:teachers,email';
        }elseif($request->type == 'admin'){
            $email ='exists:admins,email';
        }elseif($request->type == 'company'){
            $email ='exists:companies,email';
        }elseif($request->type == 'trainer'){
            $email ='exists:trainers,email';
        }elseif($request->type == 'student'){
            $email ='exists:students,email';

        }
        $request->validate([
            'email'=> 'required|email|string| '.$email,
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);





          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token,
                                'type' => $request->type
                              ])
                              ->first();

        if(!$updatePassword){
            return back()->withInput()->with('msg', 'Invalid token!')->with('type','danger');
        }
        elseif($request->type == 'student'){
            $student = Student::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        }elseif($request->type == 'admin'){
            $admin = Admin::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        }elseif($request->type == 'trainer'){
            $trainer = Trainer::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        }elseif($request->type == 'company'){
            $company = Company::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        }



          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          if($request->type == 'student'){
            return redirect()->route('student.login.show')->with('msg', 'Your password has been changed!')->with('type','success');

          }else{
            return redirect()->route('login.show',$request->type)->with('msg', 'Your password has been changed!')->with('type','success');

          }
      }
}
