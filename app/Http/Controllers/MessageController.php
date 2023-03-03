<?php

namespace App\Http\Controllers;

use App\Events\CreateMessage;
use App\Models\Message;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class MessageController extends Controller
{
    public function index($slug)
    {
        $student = Student::whereSlug($slug)->first();
        return view('admin.messages.index', compact('student'));
    }

    // send messages
    public function send_message(Request $request)
    {
        $student = Student::whereSlug($request->reciver_id)->first();
        $message = Message::create([
            'receiver_id' => $student->id,
            'student_id' => $student->id,
            'trainer_id' => Auth::user()->id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
        ]);

        broadcast(new CreateMessage($message));

        $time = $message->created_at->format('h:i');
        $am_pm = $message->created_at->format('a');
        $total_time = $time. ' '. $am_pm;
        return $total_time;

    }

    // load messages
    public function get_messages(Request $request)
    {
        $student = Student::whereSlug($request->reciver_id)->first();

        $user = Auth::user();
        $messages = $user->messages()->where('student_id', $student->id)->orderBy('id', 'desc')->limit(10)->get()->reverse();

        

        $output = "";

        if($messages) {
            
            foreach($messages as $message) {
                $time = $message->created_at->format('h:i');
                $am_pm = $message->created_at->format('a');
                $total_time = $time.' '.$am_pm;
                if($message->sender_id == $user->id) {


                    $output .= '<div class="chat outgoing message" data-id="'.$message->id.'">
                                    <div class="details">
                                        <p>'.$message->message.'</p>
                                        <span class="time">'.$total_time.'</span>
                                    </div>
                                </div>';
                }else {
                    $output .= '<div class="chat incoming message" data-id="'.$message->id.'"> 
                                    <img src="'.'http://127.0.0.1:8000/'.$student->image.'" alt="">
                                    <div class="details">
                                        <p>'.$message->message.'</p>
                                        <span class="time">'.$total_time.'</span>
                                    </div>
                                </div>';
                }

            }
            // return response()->json(["output" => $output]);
            echo $output;
        }
    }

    // load chats 
    public function get_chats(Request $request)
    {
        $user = Auth::user();
        $students = Student::where('trainer_id', $user->id)->latest('id')->get();
        
        $output = '';

        foreach($students as $student) {

            $message = Message::where([
                ['sender_id', $user->id],
                ['receiver_id', $student->id]
            ])
            ->orWhere([
                ['receiver_id', $user->id],
                ['sender_id', $student->id]
            ])
            ->latest('id')
            ->first();
            
            

            if($message) {
                // $time = $message->created_at->format('h:i');
                // $am_pm = $message->created_at->format('a');
                // $total_time = $time.' '.$am_pm;
                $total_time = $message->created_at->diffForHumans();
                $last_message = $message->message;
            } else {
                $last_message = 'No messages yet';
                $total_time = '';
            }

            $output .= ' <a href="" class="chat-box" data-slug="'.$student->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$student->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$student->name.'</b></span>
                                    <div class="chat-message">
                                        <p>'.$last_message.'</p>
                                        <span>'.$total_time.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>';
        }

        return $output;
    }

    // get user messages by clicking 
    public function get_user_messages(Request $request)
    {
        $user = Auth::user();
        $student = Student::whereSlug($request->slug)->first();
        $messages = $user->messages()->where('student_id', $student->id)->orderBy('id', 'desc')->limit(10)->get()->reverse();
        $image = 'http://127.0.0.1:8000/'.$student->image;
        $data = [
            "messages" => $messages,
            "student" => $student,
            "user" => $user,
            "image" => $image,
        ];

        return $data;
        
    }
}
