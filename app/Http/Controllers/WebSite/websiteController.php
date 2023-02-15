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
use App\Models\AppliedTasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\AppliedNotification;
use Carbon\Carbon;

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
        $task = Task::with('applied_tasks')->whereSlug($slug)->firstOrFail();
        $applied_task = null;
        foreach($task->applied_tasks as $applied) {
            $applied_task = $applied->where('student_id', Auth::user()->id)->first();
        }
        $end_date = Carbon::parse($task->end_date);
        $remaining_seconds = $end_date->diffInSeconds(now());
        $remaining_minutes = floor($remaining_seconds / 60);
        $remaining_hours = floor($remaining_minutes / 60);
        $remaining_days = floor($remaining_hours / 24);
        $remaining_hours = $remaining_hours % 24;
        return view('student.task',compact('task', 'remaining_days' ,'remaining_hours', 'remaining_minutes', 'applied_task'));

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

        $company->notify(new AppliedNotification(Auth::user()->name  ,
                                                $request->reason, $category->name ,
                                                Auth::user()->id ,$request->category_id ,
                                                $request->company_id ));

        $response = array();
        $response['content'] = '<p>Your application under review, we will send a message when we approved it</p>
        <form action="/company/cancel/'.$ap->id.'/request" id="cancel_form" method="POST">
            '. csrf_field(). '
            '. method_field('DELETE'). '
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

    // Submit Task
    public function submit_task(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120'
        ]);

        $student = Student::where('id', Auth::user()->id)->first();
        

        $file_name = $student->student_id .'-'. $request->file('file')->getClientOriginalName(); 
        $request->file('file')->move(public_path('uploads/applied-tasks/'), $file_name);

        $applied_task = AppliedTasks::create([
            'task_id' => $request->task_id,
            'student_id' => Auth::user()->id,
            'file' => $file_name,
        ]);

        return response()->json($applied_task->toArray());
    }

}
