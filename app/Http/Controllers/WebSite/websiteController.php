<?php

namespace App\Http\Controllers\WebSite;

use App\Models\Task;
use App\Models\Company;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $tasks = Task::where('category_id', Auth::user()->category_id)->where('company_id', Auth::user()->company_id)->get();



        return view('student.index' , compact('companies','company','students' ,'trainers','tasks') );
    }

    public function task($slug )
    {
        $task = Task::whereSlug($slug)->firstOrFail();
        return view('student.task',compact('task'));

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




    public function profile($slug)
    {
        $student = Student::with('university' , 'specialization' ,'teacher' ,'company')->whereSlug($slug)->first();
        if($student) {
            return view('student.profile' , compact('student'));
        } else {
            return abort(404);
        }

    }


    public function editProfile(Request $request , $slug)
    {

        $student = Student::whereSlug($slug)->firstOrFail();

        $path = $student->image;
        if($request->file('image')) {
            File::delete(public_path($student->image));
            $path = $request->file('image')->store('/uploads/student', 'custom');
        }


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|',
            'image' => 'nullable'
        ]);


    //    if($request->name != Auth::user()->name){
            $slug = Str::slug($request->name);
            $slugCount = Student::where('slug' , 'like' , $slug. '%')->count();
            $random =  $slugCount + 1;
            if($slugCount > 1){
                $slug = $slug . '-' . $random;
        // }
       }

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $path,
            'slug' =>$slug
        ]);

        return json_encode(array("name"=>$student->name, "email"=>$student->email, "slug"=>$student->slug));

    }

}
