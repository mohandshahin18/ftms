<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\University;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with('university','specialization')->latest('id')->paginate(env('PAGINATION_COUNT '));
        return view('admin.teachers.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::get();
        $specializations = Specialization::get();
        return view('admin.teachers.create',compact('universities','specializations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        $path = $request->file('image')->store('/uploads/teacher', 'custom');

        $teacher = Teacher::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'university_id' => $request->university_id,
            'specialization_id' => $request->specialization_id,
            'password' => Hash::make($request->password),
            'image' => $path,
        ]);

        $students = Student::where('university_id', $teacher->university_id)->where('specialization_id', $request->specialization_id)->get();

        if($students) {
            foreach($students as $student){
                $student->update([
                    'teacher_id' => $teacher->id
                ]);
            }
        }

        return redirect()
        ->route('admin.teachers.index')
        ->with('msg', __('admin.Teacher has been added successfully'))
        ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Teacher $teacher)
    {
        $photo_path = public_path($teacher->image);

        if(File::exists($photo_path)) {
            try {
                File::delete($photo_path);
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        // File::delete();
        $teacher->forceDelete();
        return $teacher->id;
    }


}
