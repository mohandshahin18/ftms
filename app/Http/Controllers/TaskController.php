<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;
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





        $slug = Str::slug($request->sub_title);
        $slugCount = Task::where('slug', 'like', $slug . '%')->count();
        $random =  $slugCount + 1;

        if ($slugCount > 0) {
            $slug = $slug . '-' . $random;
        }

        $file_name = null;
        if($request->hasFile('file')) {
            $file = $request->file('file')->getClientMimeType();
            $allowed_types = ['application/pdf', 'application/zip', 'application/octet-stream', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];

            try{
                if(in_array($file, $allowed_types)) {

                    $task_title = str_replace(' ', '-', $request->main_title);
                    $file_name = $task_title.'-'.$request->file('file')->getClientOriginalName();
                    $request->file('file')->move(public_path('uploads/tasks-files/'),     $file_name);
                } else {
                    return response()->json(['errors' => ['file' => ['File type is invalid']]], 422);
                }
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // $fileName = null;
        // if($request->hasFile('file')) {
        //     $task_title = str_replace(' ', '-', $request->main_title);
        //     $fileName =$task_title.'-'.$request->file('file')->getClientOriginalName();
        //     $request->file('file')->move(public_path('uploads/tasks-files/'),$fileName);
        // }

            $task = Task::create([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $file_name,
            'description' => $request->description,
            'company_id' => $company_id,
            'category_id' => Auth::user()->category->id,
            'trainer_id' => Auth::user()->id,
            'slug' => $slug,
        ]);


        $delay = Carbon::parse($request->start_date)->diffInSeconds(now());

        $students = Student::where('category_id', Auth::user()->category->id)
            ->where('company_id', $company_id)->get();

        foreach ($students as $student) {
            $student->notify((new NewTaskNotification(Auth::user()->name, $slug, Auth::user()->id,
                                                     Auth::user()->image))
                                                     ->delay($delay));
        }


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
        $fileName = $task->file;
        if ($request->hasFile('file')) {
            $path = public_path($task->file);
            if ($path) {
                try {
                    File::delete($path);
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }
            $task_title = str_replace(' ', '-', $task->main_title);
            $fileName = $task_title . '-' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/tasks-files/'), $fileName);
        }

        $slug = Str::slug($request->sub_title);
        $slugCount = Task::where('slug', 'like', $slug . '%')->count();
        $random =  $slugCount + 1;

        if ($slugCount > 1) {
            $slug = $slug . '-' . $random;
        }

        $task->update([
            'main_title' => $request->main_title,
            'sub_title' => $request->sub_title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'file' => $fileName,
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
        $students = Student::where('category_id', Auth::user()->category->id)
            ->where('company_id', $task->company_id)->get();


        foreach ($students as $student) {
            $other_notifications = DB::table('notifications')
                ->where('type', 'App\Notifications\NewTaskNotification')
                ->where('notifiable_type', 'App\Models\Student')
                ->where('notifiable_id', $student->id)
                ->get();

            foreach ($other_notifications as $notification) {
                $data = json_decode($notification->data, true);

                if (($data['slug'] == $task->slug)) {
                    DB::table('notifications')
                        ->where('id', $notification->id)
                        ->delete();
                }
            }
        }



        if ($task->file) {
            try {
                File::delete(public_path($task->file));
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $task->destroy($task->id);
        return $task->id;
    }
}
