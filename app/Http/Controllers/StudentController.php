<?php

namespace App\Http\Controllers;

use App\Models\AppliedEvaluation;
use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('university', 'specialization')->paginate(env('PAGINATION_COUNT'));

        $evaluated_student = Student::has('applied_evaluation')->first();

        return view('admin.students.index', compact('students', 'evaluated_student'));
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
            if($evaluation->type != Auth::guard() && !Auth::guard('admin')->check()) {
                abort(403, 'Your Not Authorized');
            } else {
            return view('admin.students.evaluate', compact('evaluation', 'student'));
            }
        } else {
            abort(403, 'There Is No Evaluations Addedd');
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
        $students = Student::onlyTrashed()->latest('id')->paginate(env('PAGINATION_COUNT'));
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
        $data = json_decode($student->applied_evaluation->data, true);

        // $excellent = 0;
        // $very_good = 0;
        // $good = 0;
        // $aceptable = 0;
        // $bad = 0;
        // $unique_ratings = [];
        
        return view('admin.students.evaluation_page', compact('student', 'data'));
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
}
