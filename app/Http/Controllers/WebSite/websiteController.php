<?php

namespace App\Http\Controllers\WebSite;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class websiteController extends Controller
{

    public function index()
    {
        return view('student.index' );
    }

    public function showCompany()
    {
        return view('student.company');
    }


    public function profile()
    {
        $student = Student::with('university' , 'specialization' ,'teacher')->where('id',  Auth::guard()->user()->id)->first();
        $university = $student->university->name;
        $specialization = $student->specialization->name;
        $teacher = $student->teacher->name;
        // $specializations = Specialization::where('university_id', $student->university_id)->get();
        return view('student.profile' , compact('university','specialization' ,'teacher')); //,'specializations'

    }


    public function profile_edit(Request $request , $slug)
    {

        // dd($slug);
        $student = Student::whereSlug($slug)->firstOrFail();

        $path = $student->image;
        if($request->image) {
            File::delete(public_path($student->image));
            $path = $request->file('image')->store('/uploads/student', 'custom');
        }


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|',
            'image' => 'nullable'
        ]);

        $slug = Str::slug($request->name);
        $slugCount = Student::where('slug' , 'like' , $slug. '%')->count();
        $random = (rand(00000,99999));
        if($slugCount > 0){
            $slug = $slug . '-' . $random;
        }

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $path,
            'slug' =>$slug
        ]);

        return redirect()->back();

    }

}
