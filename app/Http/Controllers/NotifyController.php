<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Student;
use App\Models\Trainer;
use App\Models\Category;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\AcceptApplyNotification;

class NotifyController extends Controller
{

    public function read_notify()
    {
        Gate::authorize('notification');

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
        $received_hash = $request->hash;
        $student_id = $request->input('student_id');
        $company_id = $request->input('company_id');
        $category_id = $request->input('category_id');

        $generated_hash = hash('sha256', $company_id. $student_id. $category_id);

        if ($received_hash != $generated_hash) {
            return response()->json(['icon' => 'error','title'=>'The form data is not valid'],400);
        }else {
            $application = Application::where('company_id',$request->company_id )
                                        ->where('category_id' ,$request->category_id )
                                        ->where('student_id' ,$request->student_id )->first();


            $trainer = Trainer::where('company_id', $request->company_id)
            ->where('category_id', $request->category_id)
            ->first();
            $student = Student::where('id',$request->student_id)->first();
            $student->update([
                'company_id' => $request->company_id,
                'category_id' => $request->category_id,
                'trainer_id' => $trainer->id
            ]);

            $delete_application = Application::where('company_id' ,'!=',$request->company_id )
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
            $delete_application3 = Application::where('company_id',$request->company_id )
                                            ->where('category_id', '!=',$request->category_id )
                                            ->where('student_id' ,$request->student_id )->get();

            if($delete_application3){
                foreach($delete_application3  as $reject){
                    $reject->destroy($reject->id);
                }
            }



            $other_notifications = DB::table('notifications')
                            ->where('type','App\Notifications\AppliedNotification')
                            ->where('notifiable_type','App\Models\Company')
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
                                            ->where('type','App\Notifications\AppliedNotification')
                                            ->where('notifiable_type','App\Models\Company')
                                            ->where('notifiable_id', $request->company_id)
                                            ->get();

            if($other_notifications_diff_cat) {
                foreach($other_notifications_diff_cat as $other_notif) {
                    $data2 = json_decode($other_notif->data, true);
                    if($data2['category_id'] !== $request->category_id) {
                            DB::table('notifications')
                               ->where('id', $other_notif->id)
                               ->delete();
                    }
                }
            }

            $application->delete();

            $student = Student::where('id',$student_id)->first();
            $studentName =$student->name;
            $studentId = $student->id;

            $category = Category::where('id',$category_id)->first();
            $categoryName =$category->name;

            $student->notify(new AcceptApplyNotification(Auth::user()->name,
                                                        Auth::user()->slug , $request->company_id ,
                                                        $categoryName, $studentName , Auth::user()->image ,$studentId));
            return '<i class="fas fa-check text-success"> ' . __('admin.Approved').'</i>';
        }
    }

    public function reject_apply(Request $request ,$id)
    {
        $received_hash = $request->hash;
        $student_id = $request->input('student_id');
        $company_id = $request->input('company_id');
        $category_id = $request->input('category_id');

        $generated_hash = hash('sha256', $company_id. $student_id. $category_id);

        if ($received_hash != $generated_hash) {
            return response()->json(['icon' => 'error','title'=>'The form data is not valid'],400);
        }else {
             Application::where('company_id' , $company_id)
                        ->where('student_id',$student_id)
                        ->where('category_id',$category_id)->delete();

            DB::table('notifications')->where('id',$id)->delete();
            return  response()->json(['reject' =>'<i class="fas fa-times text-danger"> ' . __('admin.Rejected').'</i>' ,'id'=>$id]);
        }

    }


    public function read_student_notify()
    {
        $auth = Auth::user();
        return view('student.notifications' , compact('auth'));
    }


    public function mark_student_read($id)
    {
       $auth = Auth::user();
       $notify =$auth->notifications()->find($id);
       $notify->markAsRead();
        $langURL =  app()->getLocale();

            $notifyURL = $notify->data['url'];
            $appURL = env('APP_URL');
            if (strpos($notifyURL, $appURL) !== false) {
                 // Remove the appURL from the notifyURL
                $notifyURL = str_replace($appURL, $appURL .'/' . $langURL , $notifyURL);
                return redirect($notifyURL); // The updated notifyURL without appURL
            }
    }


}
