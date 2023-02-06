<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Student;
use App\Notifications\AppliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{

    public function read_notify()
    {
        $auth = Auth::user();
        $application = Application::get();
        return view('admin.notifications' , compact('auth','application'));
    }

    public function mark_read($id)
    {
       $auth = Auth::user();
       $notify =$auth->notifications()->find($id);
       $notify->markAsRead();

       return redirect()->route('admin.read_notify');
    }


    public function accept_apply(Request $request)
    {
        $application = Application::where('company_id' ,$request->company_id )
                                    ->where('category_id' ,$request->category_id )
                                    ->where('student_id' ,$request->student_id )->first();
        $application->update([
            'status' => 1
        ]);

        $student = Student::where('id',$request->student_id)->first();
        $student->update([
            'company_id' => $request->company_id
        ]);

       return redirect()->route('admin.read_notify')->with('msg','The student joined to your company')->with('type','success');
    }



}
