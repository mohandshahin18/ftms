<?php

namespace App\Http\Controllers;

use App\Models\AppliedEvaluation;
use App\Models\Evaluation;
use App\Models\Student;
use App\Models\University;
use Arcanedev\LaravelSettings\Utilities\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $keyword = request()->keyword;

        // if(Auth::guard('teacher')->check()) {

        //     $students = Student::with('company')->where('teacher_id', Auth::user()->id);

        //     if(request()->has('keyword')){

        //         $students->where('name' , 'like' , '%' .$keyword.'%')
        //         ->orWhere('student_id', 'like', '%'.$keyword.'%')
        //         ->latest('id')
        //         ->paginate(env('PAGINATION_COUNT'));

        //     } else {

        //         $students->latest('id')->paginate(env('PAGINATION_COUNT'));

        //     }

        // } elseif(Auth::guard('trainer')->check()) {

        //     $students = Student::with('specialization', 'university')->where('trainer_id', Auth::user()->id);

        //     if(request()->has('keyword')){

        //         $students->where('name' , 'like' , '%' .$keyword.'%')
        //         ->orWhere('student_id', 'like', '%'.$keyword.'%')
        //         ->orWhereHas('university', function($query) use ($keyword) {
        //             $query->where('name', 'like', '%'.$keyword.'%');
        //         })
        //         ->orWhereHas('specialization', function($query) use ($keyword) {
        //             $query->where('name', 'like', '%'.$keyword.'%');
        //         })
        //         ->latest('id')
        //         ->paginate(env('PAGINATION_COUNT'));

        //     } else {

        //         $students->latest('id')->paginate(env('PAGINATION_COUNT'));

        //     }

        // } elseif(Auth::guard('company')->check()) {

        //     $students = Student::with('specialization', 'university')->where('company_id', Auth::user()->id);

        //         if(request()->has('keyword')){

        //             $students->where('name' , 'like' , '%' .$keyword.'%')
        //             ->orWhere('student_id', 'like', '%'.$keyword.'%')
        //             ->orWhereHas('university', function($query) use ($keyword) {
        //                 $query->where('name', 'like', '%'.$keyword.'%');
        //             })
        //             ->orWhereHas('specialization', function($query) use ($keyword) {
        //                 $query->where('name', 'like', '%'.$keyword.'%');
        //             })
        //             ->latest('id')
        //             ->paginate(env('PAGINATION_COUNT'));

        //         } else {

        //             $students->latest('id')->paginate(env('PAGINATION_COUNT'));

        //         }


        // } else {
        //     $students = Student::with('company', 'specialization', 'university');

        //     if(request()->has('keyword')){

        //         $students->where('name' , 'like' , '%' .$keyword.'%')
        //         ->orWhere('student_id', 'like', '%'.$keyword.'%')
        //         ->orWhereHas('university', function($query) use ($keyword) {
        //             $query->where('name', 'like', '%'.$keyword.'%');
        //         })
        //         ->orWhereHas('specialization', function($query) use ($keyword) {
        //             $query->where('name', 'like', '%'.$keyword.'%');
        //         })
        //         ->latest('id')
        //         ->paginate(env('PAGINATION_COUNT'));

        //     } else {

        //         $students->latest('id')->paginate(env('PAGINATION_COUNT'));
        //     }


        // }

        $students = Student::latest('id')->paginate(env('PAGINATION_COUNT'));

        $applied_evaluations = AppliedEvaluation::where('evaluation_type', 'student')
        ->get();

        return view('admin.students.index', compact('students', 'applied_evaluations'));
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
    public function show_evaluation($id)
    {
        $student = Student::whereHas('applied_evaluation')->findOrFail($id);
        $evaluation = AppliedEvaluation::where('student_id', $id)
        ->where('evaluation_type', 'student')
        ->where('company_id', Auth::user()->company_id)
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


    // Filter students by evaluated or not

    public function filter(Request $request)
    {
        $filter = request()->filter;
        $students = Student::with('applied_evaluation', 'university', 'specialization');

        if($filter == 'evaluated') {
            $students = $students->has('applied_evaluation')->latest('id')->paginate(env('PAGINATION_COUNT'));
        } elseif($filter == 'not evaluated') {
            $students = $students->doesntHave('applied_evaluation')->latest('id')->paginate(env('PAGINATION_COUNT'));
        } else {
            $students = $students->latest('id')->paginate(env('PAGINATION_COUNT'));
        }

        $evaluated_students = Student::has('applied_evaluation')->get();

        return view('admin.students.index', compact('students', 'evaluated_students', 'filter'));
    }
}
