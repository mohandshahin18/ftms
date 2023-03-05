<?php

namespace App\Http\Controllers\Auth;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subsicribe;
use App\Rules\TwoSyllables;
use Illuminate\Support\Str;
use App\Models\Users_Verify;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    public function showStudentRegisterForm($student_id)
    {
        $subsicribe= Subsicribe::where('university_id',$student_id)->first();

            if($subsicribe){
                return view('auth.register' , compact('subsicribe'));
            }else{
                abort(403);
            }


    }

    public function createStudent(Request $request , $student_id)
    {

        $subsicribe= Subsicribe::where('university_id',$student_id)->first();


        $request->validate([
            'email' => ['required', 'string', 'email', 'unique:students'],
            'phone' => ['required', 'string','min:10', 'max:20', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'university_id' => ['required'],
            'specialization_id' => ['required'],
        ]);


        $teacher = Teacher::where('university_id',$request->university_id)->where('specialization_id', $request->specialization_id)->first();
        $slug = Str::slug($subsicribe->name);
        $slugCount = Student::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $random;
        }



        $student = Student::create([
                'name' => $subsicribe->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'teacher_id' => $teacher ? $teacher->id : null,
                'student_id' => $subsicribe->university_id,
                'university_id' => $request->university_id,
                'specialization_id' => $request->specialization_id,
                'password' => Hash::make($request->password),
                'slug' => $slug,
            ]);


                $token = Str::random(64);

                Users_Verify::create([
                  'student_id' => $student->id,
                  'token' => $token
                ]);

            Mail::send('emails.virefyEmail', ['token' => $token], function($message) use($request){
                  $message->to($request->email);
                  $message->subject('Email Verification Mail');
              });


            return redirect()->route('student.login.show')
                             ->with('msg' ,__('admin.We have sent you an activation code, please check your email.'))
                             ->with('type' , 'warning');


    }


    public function get_specialization($id)
    {
        $specializations = Specialization::where('university_id', $id)->pluck("name", 'id');
        return json_encode($specializations);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($token)
    {
        $verifyStudent = Users_Verify::where('token', $token)->first();

        if(!is_null($verifyStudent) ){
            $student = $verifyStudent->student;

            if(!$student->is_email_verified) {
                $verifyStudent->student->is_email_verified = 1;
                $verifyStudent->student->save();
                $message = __('admin.Your email is verified. You can now login.');
                $type = 'success';
                DB::table('users_verifies')->where(['token'=> $token])->delete();
            } else {
                $message = __("admin.Your email is already verified. You can now login.");
                $type = 'success';
            }
        }else{
            $message =__("admin.Your email is already verified. You can now login.");
            $type = 'success';

        }

      return redirect()->route('student.login.show')->with('msg', $message)->with('type' , $type);
    }

}
