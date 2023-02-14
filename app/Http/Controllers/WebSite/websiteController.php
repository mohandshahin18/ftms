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
        foreach($company->categories as $category) {
            if($program == $category->name){
                $ap= Auth::user()->applications->where('category_id', $category->id)
                                ->where('student_id', Auth::user()->id)
                                ->where('company_id', $company->id)
                                ->first();
            }
        }
        

        $applied =Application::get();

        return view('student.company',compact('company','program' ,'applied', 'ap'));
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
       
        foreach($company->categories as $cat) {
            if($category->name == $cat->name){
                $ap= Auth::user()->applications->where('category_id', $cat->id)
                                ->where('student_id', Auth::user()->id)
                                ->where('company_id', $company->id)
                                ->first();
            }
        }

        $company->notify(new AppliedNotification(Auth::user()->name ,Auth::user()->image ,
                                                $request->reason, $category->name ,
                                                Auth::user()->id ,$request->category_id ,
                                                $request->company_id ));

        $response = array();
        $response['content'] = '<p>Your application under review, we will send a message when we approved it</p>
        <form action="/company/cancel/'.$ap->id.'/request" id="cancel_form" method="POST">
            "@csrf"
            "@method("delete")"
            <button type="button" class="btn btn-brand" id="cancle_btn">Cancel Request</button>
        </form>';

        return response()->json($response);
    }



    public function company_cancel($id){
        Application::destroy($id);
        return $id;

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

        
       if($request->name != Auth::user()->name){
            $slug = Str::slug($request->name);
            $slugCount = Student::where('slug' , 'like' , $slug. '%')->count();
            $random = (rand(00000,99999));
            if($slugCount > 0){
                $slug = $slug . '-' . $random;
        }

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
