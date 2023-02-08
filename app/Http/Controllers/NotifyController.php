<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppliedNotification;
use Illuminate\Notifications\Notification;

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
    //    $notify =notifications()->where('notifiable_id','!=' ,$request->company_id)->get();
    //     dd($notify);

    // dd($request->notify_id);



        $application = Application::where('company_id' ,$request->company_id )
                                    ->where('category_id' ,$request->category_id )
                                    ->where('student_id' ,$request->student_id )->first();

        $application->delete();

        $delete_application = Application::where('company_id' ,'!=',$request->company_id )->orWhere('company_id' ,$request->company_id)
                                        ->where('category_id', '!=',$request->category_id )
                                        ->where('student_id' ,$request->student_id )->get();

        if($delete_application){
            foreach($delete_application  as $reject){
                $reject->destroy($reject->id);
            }
        }

        $delete_application2 = Application::where('company_id' ,'!=',$request->company_id )
                                        ->where('category_id',$request->category_id )
                                        ->where('student_id' ,$request->student_id )->get();

        if($delete_application2){
            foreach($delete_application2  as $reject){
                $reject->destroy($reject->id);
            }
        }


        $student = Student::where('id',$request->student_id)->first();
        $student->update([
            'company_id' => $request->company_id
        ]);

       return redirect()->route('admin.read_notify')->with('msg','The student joined to your company')->with('type','success');
    }



}
