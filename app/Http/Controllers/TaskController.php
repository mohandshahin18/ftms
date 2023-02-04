<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Trainer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('category')->where('trainer_id', Auth::user()->id)->paginate(env('PAGINATION_COUNT'));
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

        $path = null;
        if($request->file('file')) {
            $path = $request->file('file')->store('/uploads/tasks-files', 'custom');
        }

        $sub_title = str_replace(' ', '-', $request->sub_title);

        $slug = Str::slug($request->main_title).'-'.$sub_title.'-'.Auth::user()->id;

            Task::create([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $path,
            'description' => $request->description,
            'category_id' => Auth::user()->category->id,
            'trainer_id' => Auth::user()->id,
            'slug' => $slug,
        ]);

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

        $sub_title = str_replace(' ', '-', $request->sub_title);

        $slug = Str::slug($request->main_title).'-'.$sub_title.'-'.Auth::user()->id;

        $task->update([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $path,
            'description' => $request->description,
            'category_id' => Auth::user()->category->id,
            'trainer_id' => Auth::user()->id,
            'slug' => $slug,
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
            File::delete(public_path($task->file));
        }
        $task->destroy($task->id);
        return $task->id;
    }
}
