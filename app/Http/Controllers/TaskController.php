<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Notifications\NewTaskNotification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('category')->where('trainer_id', Auth::user()->id)->latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainers = Trainer::with('category')->findOrFail(Auth::user()->id);
        return view('admin.tasks.create', compact('trainers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
       $trainer = Trainer::with('company')->where('id',  Auth::user()->id)->first();
        $company_id = $trainer->company->id;


        $path = null;
        if($request->file('file')) {
            $path = $request->file('file')->store('/uploads/tasks-files', 'custom');
        }


        $slug = Str::slug($request->sub_title);
        $slugCount = Task::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $random;
        }

            Task::create([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $path,
            'description' => $request->description,
            'company_id' =>$company_id,
            'category_id' => Auth::user()->category->id,
            'trainer_id' => Auth::user()->id,
            'slug' => $slug,
        ]);




            $student = Student::where('category_id',Auth::user()->category->id)
                              ->where('company_id' ,$company_id )->first();



            $student->notify(new NewTaskNotification(Auth::user()->name,$slug,Auth::user()->id ));

        return redirect()->route('admin.tasks.index')
        ->with('msg', 'Task has been addedd successfully')
        ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $task = Task::where('slug', $slug)->first();
        $trainer = Trainer::with('category')->findOrFail(Auth::user()->id);
        return view('admin.tasks.edit', compact('task', 'trainer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $path = null;
        if($request->file('file')) {
            $path = $request->file('file')->store('/uploads/tasks-files', 'custom');
        }

        $slug = Str::slug($request->sub_title);
        $slugCount = Task::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $random;
        }

        $task->update([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $path,
            'description' => $request->description,
            'category_id' => Auth::user()->category->id,
            'trainer_id' => Auth::user()->id,
            'slug' => $slug
        ]);

        return redirect()->route('admin.tasks.index')
        ->with('msg', 'Task has been updated successfully')
        ->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if($task->file){
            try {
                File::delete(public_path($task->file));
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $task->destroy($task->id);
        return $task->id;
    }
}
