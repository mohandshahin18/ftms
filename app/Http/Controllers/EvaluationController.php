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
        $evaluations = Evaluation::latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.evaluations.create');
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
            'start_date' => ['required'],
            'end_date' => ['required'],
        ]);

        $evaluation = Evaluation::create([
            'name' => $request->name,
            'evaluation_type' => $request->evaluation_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
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
        ->with('msg', __('admin.Evaluation has been added successfully'))
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
        return view('admin.evaluations.edit', compact('evaluation'));
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
            'evaluation_type' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ]);

        $evaluation->update([
            'name' => $request->name,
            'evaluation_type' => $request->evaluation_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if($request->has('questions')) {

            foreach($request->questions as $qid => $question) {
                Question::updateOrCreate([
                    'id' => $qid,
                    'question' => $question,
                    'evaluation_id' => $evaluation->id
                ]);
            }
        }

        return redirect()->route('admin.evaluations.index')
        ->with('msg', __('admin.Evaluation has been updated successfully'))
        ->with('type', 'success');
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
            'company_id' => Auth::user()->company_id,
            'data' => json_encode($request->answer),
        ]);

        return redirect()->route('admin.students.index')
        ->with('msg', $student->name. __('admin.has been evaluated successfully'))
        ->with('type', 'success');
    }

}
