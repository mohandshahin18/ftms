<?php

namespace App\Http\Controllers\WebSite;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Advert;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Student;
use App\Models\Category;
use App\Models\Evaluation;
use App\Models\Application;
use Illuminate\Support\Str;
use App\Models\AppliedTasks;
use Illuminate\Http\Request;
use App\Models\AppliedEvaluation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AppliedNotification;
use App\Models\Users_Verify;


class websiteController extends Controller
{



    public function index()
    {
        $companies = Company::with('categories')->where('status', 1)->inRandomOrder()->limit(3)->latest('id')->get();

        $tasks = Task::with('applied_tasks')->where('trainer_id', Auth::user()->trainer_id)->get();

        $adverts = Advert::where('trainer_id', Auth::user()->trainer_id)
            ->orWhere('teacher_id', Auth::user()->teacher_id)
            ->orWhere('company_id', Auth::user()->company_id)
            ->latest('created_at')
            ->limit(10)
            ->get();
        return view('student.index', compact('companies', 'tasks', 'adverts'));
    }

    public function task($slug)
    {
        $task = Task::with('applied_tasks')->whereSlug($slug)->firstOrFail();
        $applied_task = null;
        foreach ($task->applied_tasks as $applied) {
            $applied_task = $applied->where('student_id', Auth::user()->id)->where('task_id', $task->id)->first();
        }
        $end_date = Carbon::parse($task->end_date);
        $remaining_seconds = $end_date->diffInSeconds(now());
        $remaining_minutes = floor($remaining_seconds / 60);
        $remaining_hours = floor($remaining_minutes / 60);
        $remaining_days = floor($remaining_hours / 24);
        $remaining_hours = $remaining_hours % 24;

        if ($task->start_date > now()) {
            abort(404);
        } else {

            return view('student.task', compact('task', 'remaining_days', 'remaining_hours', 'remaining_minutes', 'applied_task'));
        }
    }


    public function showCompany($slug, $program)
    {
        $company = Company::with('categories')->whereSlug($slug)->firstOrFail();

        if (Auth::user()->company_id) {
            $evaluated = AppliedEvaluation::where('evaluation_type', 'company')
                ->where('student_id', Auth::user()->id)
                ->where('company_id', Auth::user()->company_id)
                ->first();
            $applied = DB::table('applied_evaluations')->where('student_id', Auth::user()->id)
                ->where('company_id', $company->id)->first();
            if ($applied) {
                $evaluations = json_decode($applied->data, true);
                $scores = [
                    'bad' => 20,
                    'acceptable' => 40,
                    'good' => 60,
                    'very good' => 80,
                    'excellent' => 100,
                ];

                $total_score = 0;
                $count = count($evaluations);
                foreach ($evaluations as $response) {
                    $total_score += $scores[$response];
                }

                $average_score = $total_score / $count;
                $average_score = floor($average_score);
            }
            return view('student.company', compact('company', 'program', 'evaluated'));
        } else {
            foreach ($company->categories as $category) {
                if ($program == $category->name) {
                    $ap = Auth::user()->applications->where('category_id', $category->id)
                        ->where('student_id', Auth::user()->id)
                        ->where('company_id', $company->id)
                        ->first();
                }
            }
            return view('student.company', compact('company', 'program', 'ap'));
        }
    }



    public function company_apply(Request $request)
    {

        $request->validate([
            'reason' => 'required'
        ]);

        $category = Category::where('id', $request->category_id)->first();
        Application::create([
            'company_id' => $request->company_id,
            'student_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'reason' => $request->reason,
        ]);

        $company = Company::where('id', $request->company_id)->first();

        foreach ($company->categories as $cat) {
            if ($category->name == $cat->name) {
                $ap = Auth::user()->applications->where('category_id', $cat->id)
                    ->where('student_id', Auth::user()->id)
                    ->where('company_id', $company->id)
                    ->first();
            }
        }

        $company->notify(new AppliedNotification(
            Auth::user()->name,
            $request->reason,
            $category->name,
            Auth::user()->id,
            $request->category_id,
            $request->company_id,
            Auth::user()->image
        ));

        $response = array();
        $response['content'] = '<p>' . __('admin.Your application under review, we will send a notification when we approved it') . '</p>

        <a href="/company/cancel/' . $ap->id . '/request" class="btn btn-brand" id="cancle_btn">' . __('admin.Cancel Request') . '</a>
        ';

        return response()->json($response);
    }



    public function company_cancel($id)
    {
        $applied = Application::findOrFail($id);

        $notifications = DB::table('notifications')
            ->where('type', 'App\Notifications\AppliedNotification')
            ->where('notifiable_type', 'App\Models\Company')
            ->where('notifiable_id', $applied->company_id)
            ->get();

        if ($notifications) {
            foreach ($notifications as $notification) {

                $data = json_decode($notification->data, true);
                if (($data['student_id'] == Auth::user()->id) &&
                    ($data['category_id'] == $applied->category_id) &&
                    ($data['company_id'] == $applied->company_id)
                ) {
                    DB::table('notifications')
                        ->where('id', $notification->id)
                        ->delete();
                }
            }
        }


        Application::destroy($id);
        return redirect()->back();
    }


    public function comment(Request $request)
    {

        //    $student = Student::whereSlug($slug)->first();

        $request->validate([
            'body' => 'required'
        ]);

        $comment = Comment::create([
            'body' => $request->body,
            'student_id' => Auth::user()->id,
        ]);

        return $comment;
    }



    public function allCompanies()
    {
        $companies = Company::with('categories')->where('status', 1)->latest('id')->take(3)->get();
        return view('student.allCompanies', compact('companies'));
    }




    public function profile($slug)
    {
        $student = Student::with('university', 'specialization', 'teacher', 'company')->whereSlug($slug)->first();
        if ($student) {
            return view('student.profile', compact('student'));
        } else {
            return abort(404);
        }
    }


    public function editProfile(Request $request, $slug)
    {
        if ($slug == Auth::user()->slug) {


            $student = Student::whereSlug($slug)->firstOrFail();

            $path = $student->image;
            if ($request->file('image')) {
                File::delete(public_path($student->image));
                $path = $request->file('image')->store('/uploads/student', 'custom');
            }


            $request->validate([
                'email' => 'required|email',
                'phone' => 'required|',
                'image' => 'nullable'
            ]);

            $is_email_verified = 1;
            $token = Str::random(64);


            if ($request->email != Auth::user()->email) {
                $exisitEmail = Student::where('email', $request->email)->get();

                if (is_null($exisitEmail)) {
                    $is_email_verified = 0;
                    Users_Verify::create([
                        'student_id' => $student->id,
                        'token' => $token
                    ]);

                    Mail::send('emails.virefyEmail', ['token' => $token], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Email Verification Mail');
                    });
                } else {
                    return response()->json(['email' => __('admin.The email is already in use'), 'filed' => 'email'], 400);
                }
            }

            $phone = Auth::user()->phone;
            if ($request->phone != $phone) {
                $exisitPhone = Student::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {

                    $phone = $request->phone;
                } else {
                    return response()->json(['phone' => __('admin.The mobile number is already in use'), 'field' => 'phone'], 400);
                }
            }
            $student->update([
                'is_email_verified' => $is_email_verified,
                'email' => $request->email,
                'phone' => $phone,
                'image' => $path,
            ]);


            return json_encode(array("name" => $student->name, "email" => $student->email, "slug" => $student->slug, "image" => $student->image));
        } else {

            return 'Not Allowed';
        }
    }

    // Submit Task
    public function submit_task(Request $request)
    {
        $request->validate([
            'file' => 'required|max:5120'
        ], [
            'file.max' => 'The file size must be less than 5MB.'
        ]);


        $file = $request->file('file')->getClientMimeType();
        $allowed_types = ['application/pdf', 'application/zip', 'application/octet-stream', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];


        if (in_array($file, $allowed_types)) {
            // $size = $request->file('file')->getSize();
            // $size = number_format($size / 1048576, 2);
            // if($size <= 5) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $file_name = $request->file('file')->getClientOriginalName();
                $file_name = str_replace(' ', '-', $file_name);
                $request->file('file')->move(public_path('uploads/applied-tasks/'),     $file_name);

                $applied_task = AppliedTasks::create([
                    'task_id' => $request->task_id,
                    'student_id' => Auth::user()->id,
                    'file' => $file_name,
                ]);


                return redirect()->back()->with('msg', __('admin.Task submitted'))->with('type', 'success');
            }
            // }else {
            //     return redirect()->back()->with('msg', __('admin.File size is large'))->with('type', 'danger');
            // }
        } else {
            return redirect()->back()->with('msg', __('admin.File type is not allowed'))->with('type', 'danger');
        }
    }

    // Edit task
    public function edit_applied_task(Request $request, $id)
    {
        $applied_task = AppliedTasks::findOrFail($id);

        if ($request->file('file')) {

            File::delete(public_path('uploads/applied-tasks/' . $applied_task->file));

            $file = $request->file('file')->getClientOriginalName();
            $file = str_replace(' ', '-', $file);
            $request->file('file')->move(public_path('uploads/applied-tasks/'), $file);
        }

        $applied_task->update([
            'file' => $file,
        ]);

        return redirect()->back()->with('msg', 'Task updated')->with('type', 'success');
    }

    // load more categories
    public function load_more_categories(Request $request)
    {
        $page = $request->page;
        $offset = $page * 3;
        $companies = Company::with('categories')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->offset($offset)
            ->take(3)
            ->get();
        return view('student.load_more_categories', compact('companies'));
    }


    // get companies names for dropdown
    public function get_companies_names(Request $request)
    {
        $search = $request->search;
        if ($search != null && strlen($search) > 1) {
            $companies = Company::where('name', 'like', '%' . $search . '%')->where('status', 1)->pluck('name', 'id');

            if (!$companies->isEmpty()) {
                return response()->json(['companies' => $companies]);
            } else {
                return response()->json(['message' => 'empty']);
            }
        } else {
            $companies = Company::with('categories')->where('status', 1)->latest('id')->take(3)->get();
            $content = view('student.companies_content', compact('companies'))->render();

            return response()->json(['content' => $content]);
        }
    }

    // content for ajax
    public function companies_content()
    {
        $companies = Company::with('categories')->where('status', 1)->latest('id')->take(3)->get();
        return view('student.companies_content', compact('companies'));
    }



    // AJAX search
    public function ajax_search(Request $request)
    {
        $company = Company::with('categories')->findOrFail($request->company_id);

        return view('student.search_result', compact('company'));
    }



    // evaluate company
    public function evaluate_company($slug)
    {
        $company = Company::whereSlug($slug)->first();
        $evaluation = Evaluation::where('evaluation_type', 'company')->first();
        return view('student.evaluate', compact('company', 'evaluation'));
    }


    /**
     * Store a new evaluations of company.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apply_evaluation(Request $request, $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $company = Company::findOrFail($request->company_id);
        $program = Category::where('id', Auth::user()->category_id)->first();

        AppliedEvaluation::create([
            'evaluation_type' => $evaluation->evaluation_type,
            'evaluation_id' => $id,
            'student_id' => Auth::user()->id,
            'company_id' => $request->company_id,
            'data' => json_encode($request->answer),
        ]);

        return redirect()->route('student.company', [$company->slug, $program])
            ->with('msg', $company->name . ' has been evaluated successfully')
            ->with('type', 'success');
    }
}
