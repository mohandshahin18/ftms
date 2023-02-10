<?php

namespace App\Http\Controllers\WebSite;

use App\Models\Company;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\AppliedNotification;

class websiteController extends Controller
{



    public function index()
    {
        $companies = Company::with('categories')->where('status' , 1)->limit(3)->latest('id')->get();
        $company = Company::get();
        $students = Student::get();
        $trainers = Trainer::get();
        return view('student.index' , compact('companies','company','students' ,'trainers') );
    }


    public function showCompany($slug , $program)
    {
        $company = Company::with('categories')->whereSlug($slug)->firstOrFail();

        $applied =Application::get();

        return view('student.company',compact('company','program' ,'applied'));
    }

    public function company_apply(Request $request){

        $request->validate([
            'reason' => 'required'
        ]);

       $category = Category::where('id',$request->category_id )->first();
        Application::create([
            'company_id' => $request->company_id ,
            'student_id' => Auth::user()->id ,
            'category_id' => $request->category_id ,
            'reason' => $request->reason ,
        ]);

        $company = Company::where('id',$request->company_id)->first();


        $company->notify(new AppliedNotification(Auth::user()->name  ,
                                                $request->reason, $category->name ,
                                                Auth::user()->id ,$request->category_id ,
                                                $request->company_id ));

        return redirect()->back()->with('msg','Apllied is successfully')->with('type' , 'success');
    }



    public function company_cancel($id){
        Application::destroy($id);
        return redirect()->back()->with('msg', 'Course Canceld Successfully')->with('type','warning');

    }



    public function allCompany(){
        $companies = Company::with('categories')->where('status' , 1)->limit(6)->latest('id')->paginate(6);
        return view('student.allCompanies' ,compact('companies'));

    }




    public function profile()
    {
        $student = Student::with('university' , 'specialization' ,'teacher' ,'company')->where('id',  Auth::guard()->user()->id)->first();
        $university = $student->university->name;
        $specialization = $student->specialization->name;
        $teacher = $student->teacher->name ? $student->teacher->name : 'No teacher yet';
        $company = $student->company->name;
        return view('student.profile' , compact('university','specialization' ,'teacher','company'));

    }


    public function editProfile(Request $request , $slug)
    {

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
