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
use App\Models\University;
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
        $subsicribe= Subsicribe::where('student_id',$student_id)->first();
        $university = University::where('id',$subsicribe->university_id)->first();
        $specialization = Specialization::where('id',$subsicribe->specialization_id)->first();
            if($subsicribe){
                return view('auth.register' , compact('subsicribe','university','specialization'));
            }else{
                abort(403);
            }


    }

    public function slug($string, $separator = '-') {
        if (is_null($string)) {
            return "";
        }

        $string = trim($string);

        $string = mb_strtolower($string, "UTF-8");

        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);

        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }


    public function createStudent(Request $request,$student_id)
    {

        $subsicribe= Subsicribe::where('student_id',$student_id)->first();

        $request->validate([
            'email' => ['required', 'string', 'email', 'unique:students'],
            'phone' => ['required', 'string','min:10', 'max:20', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);


        $teacher = Teacher::where('university_id',$subsicribe->university_id)->where('specialization_id', $subsicribe->specialization_id)->first();

        $slug = $this->slug($subsicribe->name);
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
                'student_id' => $subsicribe->student_id,
                'university_id' => $subsicribe->university_id,
                'specialization_id' =>  $subsicribe->specialization_id,
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
                             ->with('msg' ,__('admin.We have sent you an activation code to your email, please check your email.'))
                             ->with('type' , 'warning');


    }


    public function get_specialization($id)
    {
        $university = University::findOrFail($id);
        $specializations = $university->specializations()->get()->map(function($specialization) {
            return [
                'id' => $specialization->id,
                'name' => $specialization->name
            ];
        });
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
