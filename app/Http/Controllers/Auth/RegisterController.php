<?php

namespace App\Http\Controllers\Auth;

use App\Models\Student;
use App\Models\Teacher;
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
use App\Rules\TwoSyllables;

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


    public function showStudentRegisterForm()
    {
        return view('auth.register');
    }

    public function createStudent(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255' , new TwoSyllables()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone' => ['required', 'string','min:10', 'max:20', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'student_id' => ['required', 'digits:8', 'min:8'],
            'university_id' => ['required'],
            'specialization_id' => ['required'],
        ]);


        $teacher = Teacher::where('university_id',$request->university_id)->where('specialization_id', $request->specialization_id)->first();
        $slug = Str::slug($request->name);
        $slugCount = Student::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $random;
        }

        $student = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'teacher_id' => $teacher ? $teacher->id : null,
                'student_id' => $request->student_id,
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
                             ->with('msg' ,'We have sent you an activation code, please check your email.')
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

        $message = 'Sorry your email cannot be identified.';
        $type = 'danger';

        if(!is_null($verifyStudent) ){
            $student = $verifyStudent->student;

            if(!$student->is_email_verified) {
                $verifyStudent->student->is_email_verified = 1;
                $verifyStudent->student->save();
                $message = "Your e-mail is verified. You can now login.";
                $type = 'success';
                DB::table('users_verifies')->where(['token'=> $token])->delete();
            } else {
                $message = "Your e-mail is already verified. You can now login.";
                $type = 'success';
            }
        }

      return redirect()->route('student.login.show')->with('msg', $message)->with('type' , $type);
    }

}
