<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('attendance');

        $students = Student::with('attendances')
                    ->where('trainer_id',Auth::user()->id)->paginate(env('PAGINATION_COUNT'));
        return view('admin.attendances.index',compact('students'));
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
        try {

            foreach ($request->attendances as $studentid => $attendance) {
                // dd($attendance);

                if( $attendance == 'presence' ) {
                    $attendance_status = true;
                } else if( $attendance == 'absent' ){
                    $attendance_status = false;
                }

                Attendance::create([
                    'student_id'=> $studentid,
                    'attendance_date'=> date('Y-m-d'),
                    'attendance_status'=> $attendance_status
                ]);

            }
            return redirect()->route('admin.attendances.index')
            ->with('msg', __('admin.Attendance has been entered successfully'))
            ->with('type', 'success');



        }

        catch (\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
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
    public function destroy($id)
    {
        //
    }
}
