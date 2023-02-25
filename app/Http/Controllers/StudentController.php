<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AppliedEvaluation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::guard('company')->check()) {

            if(request()->has('keyword')){
                $students = Student::with('specialization', 'university')
                ->where('company_id', Auth::user()->id)
                ->where('name' , 'like' , '%' .request()->keyword.'%')
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }else{
                $students = Student::with('specialization', 'university')
                ->where('company_id', Auth::user()->id)
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }


        }elseif(Auth::guard('teacher')->check()){

            if(request()->has('keyword')){
                $students = Student::with('specialization', 'university')
                ->where('teacher_id', Auth::user()->id)
                ->where('name' , 'like' , '%' .request()->keyword.'%')
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }else{
                $students = Student::with('specialization', 'university')
                ->where('teacher_id', Auth::user()->id)
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }

        }elseif(Auth::guard('trainer')->check()){

            if(request()->has('keyword')){
                $students = Student::with('specialization', 'university')
                ->where('trainer', Auth::user()->id)
                ->where('name' , 'like' , '%' .request()->keyword.'%')
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }else{
                $students = Student::with('specialization', 'university')
                ->where('trainer', Auth::user()->id)
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }

        }else{
            if(request()->has('keyword')){
                $students = Student::with('specialization', 'university')
                ->where('name' , 'like' , '%' .request()->keyword.'%')
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }else{
                $students = Student::with('specialization', 'university')
                ->latest('id')
                ->paginate(env('PAGINATION_COUNT'));
            }
        }

        $applied_evaluations = AppliedEvaluation::where('evaluation_type', 'student')->get();

        return view('admin.students.index', compact('students', 'applied_evaluations'));
    }

    // search and return students names
    public function search(Request $request)
    {
        $search = $request->search;

        if($search != null) {
            if(Auth::guard('company')->check()) {
                $students = Student::where('company_id', Auth::user()->id)
                ->where(function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('student_id', 'like', '%'.$search.'%');
                })
                ->pluck('name');

            } elseif(Auth::guard('trainer')->check()) {
                $students = Student::where('trainer_id', Auth::user()->id)
                ->where(function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('student_id', 'like', '%'.$search.'%');
                })
                ->pluck('name');

            } elseif(Auth::guard('teacher')->check()) {
                $students = Student::where('teacher_id', Auth::user()->id)
                ->where(function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('student_id', 'like', '%'.$search.'%');
                })
                ->pluck('name');

            } else {
                $students = Student::where(function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('student_id', 'like', '%'.$search.'%');
                })
                ->pluck('name');
            }

            if($students) {
                return response()->json(["students" => $students]);
            } else {
                return response()->json(["message"=> "meg"]);
            }
        }
    }

    public function delete_company_student($id)
    {
        $student= Student::where('id',$id)->first();


        $applyNotifications = DB::table('notifications')
                    ->where('type','App\Notifications\AppliedNotification')
                    ->where('notifiable_type','App\Models\Company')
                    ->where('notifiable_id',$student->company_id)
                    ->get();

        if($applyNotifications) {
            foreach($applyNotifications as $notification) {

                $data = json_decode($notification->data, true);
                if(($data['student_id'] == $student->id)&&
                    ($data['category_id'] == $student->category_id) &&
                    ($data['company_id'] == $student->company_id))
                    {
                        DB::table('notifications')
                            ->where('id', $notification->id)
                            ->delete();
                    }
            }
        }

        $acceptApplyNotifications = DB::table('notifications')
        ->where('type','App\Notifications\AcceptApplyNotification')
        ->where('notifiable_type','App\Models\Student')
        ->where('notifiable_id',$student->id)
        ->get();

        if($acceptApplyNotifications) {
            foreach($acceptApplyNotifications as $notification) {

                $data = json_decode($notification->data, true);
                if(($data['studentId'] == $student->id)&&
                    ($data['company_id'] == $student->company_id))
                    {
                        DB::table('notifications')
                            ->where('id', $notification->id)
                            ->delete();
                    }
            }
        }



        $student->update([
            'company_id'=> null ,
            'category_id'=> null ,
            'trainer_id'=> null ,
        ]);

        return $id ;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $evaluation = Evaluation::where('evaluation_type', 'student')->first();

        if($evaluation) {
            return view('admin.students.evaluate', compact('evaluation', 'student'));

        } else {
            return redirect()->back()
            ->with('msg', 'Please Add Evaluation First')
            ->with('type', 'info');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return $id;
    }


    /**
     * Display a trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        if(request()->has('keyword')){
            $students = Student::onlyTrashed()->where('name' , 'like' , '%' .request()->keyword.'%')
            ->paginate(env('PAGINATION_COUNT'));
        }else{
            $students = Student::onlyTrashed()->latest('id')->paginate(env('PAGINATION_COUNT'));

        }
        return view('admin.students.trash', compact('students'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $students = Student::onlyTrashed()->findOrFail($id);
        $students->restore();
        return $id;
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($id)
    {
        $students = Student::onlyTrashed()->findOrFail($id);

        if(public_path($students->image)) {
            try {
                File::delete(public_path($students->image));
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $students->forcedelete();
        return $id;




    }


    /**
     * Display the student evaluation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_evaluation($slug)
    {
        $student = Student::whereHas('applied_evaluation')->whereSlug($slug)->first();
        $evaluation = AppliedEvaluation::where('student_id', $student->id)
        ->where('evaluation_type', 'student')
        ->first();
        $data = json_decode($evaluation->data, true);
        $scores = [
            'bad' => 20,
            'acceptable' => 40,
            'good' => 60,
            'very good' => 80,
            'excellent' => 100,
        ];

        $total_score = 0;
        $count = count($data);
        foreach ($data as $response) {
            $total_score += $scores[$response];
        }

        $average_score = $total_score / $count;
        $average_score = floor($average_score);

        return view('admin.students.evaluation_page', compact('student', 'data', 'average_score'));
    }



    /**
     * Export student evaluation as PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export_pdf($id)
    {
        $student = Student::findOrFail($id);
        $applied_evaluation = AppliedEvaluation::with('evaluation')->where('student_id', $id)->first();
        $questions = json_decode($applied_evaluation->data, true);
        $data = [
            'student' => $student,
            'questions' => $questions,
            'applied_evaluation' => $applied_evaluation
        ];

        $name_of_pdf = str_replace(' ', '-', $student->name).'-'.$student->student_id;

        $pdf = Pdf::loadView('admin.students.pdf', $data);
        return $pdf->download($name_of_pdf.'.pdf');
    }


    // // Filter students by evaluated or not

    // public function filter(Request $request)
    // {
    //     $filter = request()->filter;
    //     $students = Student::with('applied_evaluation', 'university', 'specialization');

    //     if($filter == 'evaluated') {
    //         $students = $students->has('applied_evaluation')->latest('id')->paginate(env('PAGINATION_COUNT'));
    //     } elseif($filter == 'not evaluated') {
    //         $students = $students->doesntHave('applied_evaluation')->latest('id')->paginate(env('PAGINATION_COUNT'));
    //     } else {
    //         $students = $students->latest('id')->paginate(env('PAGINATION_COUNT'));
    //     }

    //     $evaluated_students = Student::has('applied_evaluation')->get();

    //     return view('admin.students.index', compact('students', 'evaluated_students', 'filter'));
    // }
}
