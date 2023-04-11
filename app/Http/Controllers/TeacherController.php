<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TeacherRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_teachers');

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
        Gate::authorize('add_teacher');
        $roles =Role::get();
        $universities = University::get();
        $specializations = Specialization::get();
        return view('admin.teachers.create',compact('universities','specializations','roles'));
    }

    public function slug($string, $separator = '-') {
        if (is_null($string)) {
            return "";
        }

        $string = trim($string);

        $string = mb_strtolower($string, "UTF-8");

        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);

        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
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

        $slug = $this->slug($request->name);
        $slugCount = Teacher::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }


        $teacher = Teacher::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'university_id' => $request->university_id,
            'specialization_id' => $request->specialization_id,
            'password' => Hash::make($request->password),
            'image' => $path,
            'slug' => $slug,
            'role_id' => $request->role_id,
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
    public function destroy($slug)
    {
        Gate::authorize('delete_teacher');

        $teacher = Teacher::whereSlug($slug)->first();
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
        return $slug;
    }


    public function get_specialization($id)
    {
        $university = University::with('specializations')->where('id',$id)->first();
        $specializations = $university->specializations->pluck("name", 'id');
        return json_encode($specializations);


    }

}
