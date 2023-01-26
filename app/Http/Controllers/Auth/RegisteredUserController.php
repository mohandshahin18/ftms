<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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


        $teacher = Teacher::where('university_id', $request->university_id)->where('specialization_id', $request->specialization_id)->first();

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'teacher_id' => $teacher->id ,
            'student_id' => $request->student_id,
            'university_id' => $request->university_id,
            'specialization_id' => $request->specialization_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($student));

        Auth::login($student);

        return redirect(RouteServiceProvider::HOME);
    }
}
