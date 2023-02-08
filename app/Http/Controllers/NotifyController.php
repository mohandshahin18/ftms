<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Student;
use App\Notifications\AppliedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifyController extends Controller
{

    public function read_notify()
    {

        // dd(notify());
        
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

    // accept applications

    public function accept_apply(Request $request)
    {
        $application = Application::where('company_id' ,$request->company_id )
                                    ->where('category_id' ,$request->category_id )
                                    ->where('student_id' ,$request->student_id )->first();
        $application->delete();

        
        $student = Student::where('id',$request->student_id)->first();
        $student->update([
            'company_id' => $request->company_id
        ]);

       $delete_application = Application::where('company_id' ,'!=',$request->company_id )   ->orWhere('company_id' ,$request->company_id)
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
        
        $other_notifications = DB::table('notifications')
                        ->where('notifiable_id', '!=', $request->company_id)
                        ->get();
                        

        if($other_notifications) {
            foreach($other_notifications as $notification) {
                $data = json_decode($notification->data, true);
                if($data['student_id'] == $request->student_id){
                    DB::table('notifications')
                        ->where('id', $notification->id)
                        ->delete();
                }
                
            }
        }

        $other_notifications_diff_cat = DB::table('notifications')
                                        ->where('notifiable_id', $request->company_id)
                                        ->get();

        if($other_notifications_diff_cat) {
            foreach($other_notifications_diff_cat as $other_notif) {
                $data2 = json_decode($other_notif->data, true);
                if($data2['category_id'] !== $request->category_id) {
                    DB::table('notifications')->where('id', $other_notif->id)->delete();
                }
            }
        }

        if($delete_application2){
            foreach($delete_application2  as $reject){
                $reject->destroy($reject->id);
            }
        }

       return '<i class="fas fa-check text-success">Approved</i>';
    }



}
