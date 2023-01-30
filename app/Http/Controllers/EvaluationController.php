<?php

namespace App\Http\Controllers;

use App\Models\AppliedEvaluation;
use App\Models\Company;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::with('student', 'company')->latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['students'] = Student::all();
        $data['companies'] = Company::all();
        return view('admin.evaluations.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'evaluation_type' => ['required'],
        ]);

        $evaluation = Evaluation::create([
            'name' => $request->name,
            'evaluation_type' => $request->evaluation_type,
        ]);

        if($request->has('questions')) {
            foreach($request->questions as $questions) {
                Question::create([
                    'question' => $questions,
                    'evaluation_id' => $evaluation->id
                ]);
            }
        }

        return redirect()->route('admin.evaluations.index')
        ->with('msg', 'Evaluation Created Successfully')
        ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        $companies = Company::all();
        $students = Student::all();
        return view('admin.evaluations.edit', compact('evaluation', 'companies', 'students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'name' => ['required'],
            'student_id' => ['required'],
            'company_id' => ['required']
        ]);

        $evaluation->update([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'company_id' => $request->company_id
        ]);

        if($request->has('questions')) {
            Question::where('evaluation_id', $evaluation->id)->delete();

            foreach($request->questions as $qid => $question) {
                Question::create([
                    'question' => $question,
                    'evaluation_id' => $evaluation->id
                ]);
            }
        }

        return redirect()->route('admin.evaluations.index')
        ->with('msg', 'Evaluation Updated Successfully')
        ->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        Question::where('evaluation_id', $evaluation->id)->delete();
        $evaluation->forceDelete();
        return $evaluation->id;
    }


    /**
     * Get The Applied for Evaluation.
     *
     * @return \Illuminate\Http\Response
     */

     public function applied_evaluations()
     {
        $applied = AppliedEvaluation::latest('id')
                   ->pginate(env('PAGINATION_COUNT'));

        return view('admin.appliedEvaluations.index', compact('evaluations'));
     }


     /**
     * Store a new evaluations of student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apply_evaluation(Request $request, $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $student = Student::findOrFail($request->student_id);

        AppliedEvaluation::create([
            'evaluation_type' => $evaluation->evaluation_type,
            'evaluation_id' => $id,
            'student_id' => $request->student_id,
            'company_id' => Auth::id(),
            'data' => json_encode($request->answer),
        ]);

        return redirect()->route('admin.evaluations.index')
        ->with('msg', $student->name.' has been evaluated successfully')
        ->with('type', 'success');
    }

}
