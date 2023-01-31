<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Mail\OTPVerified;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'phone' => ['required', 'string','min:10', 'max:20', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'student_id' => ['required', 'digits:8', 'min:8'],
            'university_id' => ['required'],
            'specialization_id' => ['required'],
        ]);

        $code = rand(000000, 999999);

        $teacher = Teacher::where('university_id',$request->university_id)->where('specialization_id', $request->specialization_id)->first();
        $student = Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'teacher_id' => $teacher->id ,
                'student_id' => $request->student_id,
                'university_id' => $request->university_id,
                'specialization_id' => $request->specialization_id,
                'password' => Hash::make($request->password),
                'otp' => $code
            ]);

            Mail::to($request->email)->send(new OTPVerified($code, $request->name));
            // event(new Registered($student));

            return redirect()->route('student.home');


    }

    public function get_specialization($id)
    {
        $specializations = Specialization::where('university_id', $id)->pluck("name", 'id');
        return json_encode($specializations);
    }
}
