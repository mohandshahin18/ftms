<?php

namespace App\Http\Controllers;

use App\Events\CreateMessage;
use App\Models\Message;
use App\Models\Student;
use Illuminate\Support\Str;
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

        $user = Auth::user();

        $student = Student::whereSlug($request->reciver_id)->first();
        if (Auth::guard('trainer')->check()) {
            $message = Message::create([
                'receiver_id' => $student->id,
                'student_id' => $student->id,
                'trainer_id' => $user->id,
                'sender_id' => $user->id,
                'message' => $request->message,
                'sender_type' => 'trainer',
                'receiver_type' => 'student'
            ]);
        } else {
            $message = Message::create([
                'receiver_id' => $student->id,
                'student_id' => $student->id,
                'teacher_id' => $user->id,
                'sender_id' => $user->id,
                'message' => $request->message,
                'sender_type' => 'teacher',
                'receiver_type' => 'student'
            ]);
        }

        broadcast(new CreateMessage($message, $user->image));

        $time = $message->created_at->format('h:i');
        $am_pm = $message->created_at->format('a');
        $total_time = $time . ' ' . $am_pm;
        return $total_time;
    }

    // load messages
    public function get_messages(Request $request)
    {
        $student = Student::whereSlug($request->reciver_id)->first();

        $user = Auth::user();
        $messages = $user->messages()->where('student_id', $student->id)->orderBy('id', 'desc')->limit(10)->get()->reverse();



        $output = "";

        if ($messages) {

            foreach ($messages as $message) {
                $time = $message->created_at->format('h:i');
                $period = $message->created_at->format('a');
                $total_time = $time . ' ' . $period;
                if ($message->sender_id == $user->id) {


                    $output .= '<div class="chat outgoing message" data-id="' . $message->id . '">
                                    <div class="details">
                                        <p>' . $message->message . '</p>
                                        <span class="time">' . $total_time . '</span>
                                    </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming message" data-id="' . $message->id . '">
                                    <img src="' . 'http://127.0.0.1:8000/' . $student->image . '" alt="">
                                    <div class="details">
                                        <p>' . $message->message . '</p>
                                        <span class="time">' . $total_time . '</span>
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

        if (Auth::guard('trainer')) {
            $students = Student::where('trainer_id', $user->id)->latest('id')->get();
        } else {
            $students = Student::where('teacher_id', $user->id)->latest('id')->get();
        }

        $output = '';
        if (Auth::guard('trainer')->check()) {
            $guard = 'trainer';
        } else {
            $guard = 'teacher';
        }

        foreach ($students as $student) {

            $message = Message::where([
                ['sender_id', $user->id],
                ['receiver_id', $student->id],
                ['sender_type', $guard],
                ['receiver_type', 'student'],
            ])
                ->orWhere([
                    ['sender_id', $student->id],
                    ['receiver_id', $user->id],
                    ['receiver_type', $guard],
                    ['sender_type', 'student'],
                ])
                ->latest('id')
                ->first();



            if ($message) {
                $total_time = $message->created_at->diffForHumans();
                $last_message = $message->message;
            } else {
                $last_message = 'No messages yet';
                $total_time = '';
            }

            $output .= ' <a href="" class="chat-box" data-slug="' . $student->slug . '">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="' . 'http://127.0.0.1:8000/' . $student->image . '" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>' . $student->name . '</b></span>
                                    <div class="chat-message">
                                        <p>' . $last_message . '</p>
                                        <span>' . $total_time . '</span>
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
        $auth = Auth::user();

        $student = Student::whereSlug($request->slug)->first();
        $messages = $auth->messages()
            ->where('student_id', $student->id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->reverse();

        $image = 'http://127.0.0.1:8000/' . $student->image;
        $data = [
            "messages" => $messages,
            "student" => $student,
            "auth" => $auth,
            "image" => $image,
        ];

        return $data;
    }

    // get students messages on page load
    public function get_students_messages(Request $request)
    {
        $auth = Auth::user();
        $slug = $request->slug;
        $students = $auth->students;

        if(Auth::guard('trainer')->check()) {
            $type = 'trainer';
        } else {
            $type = 'teacher';
        }

        $output = '';
        foreach($students as $student) {

            $message = $auth->messages()->where([
                ['sender_id', $auth->id],
                ['receiver_id', $student->id],
                ['sender_type', $type],
                ['receiver_type', 'student'],
            ])
            ->orWhere([
                ['sender_id', $student->id],
                ['receiver_id', $auth->id],
                ['sender_type', 'student'],
                ['receiver_type', $type],
            ])
            ->latest('id')
            ->first();

            $activelastMessage = $auth->messages()
            ->where([
                ['sender_id', $student->id],
                ['receiver_id', $auth->id],
                ['sender_type', 'student'],
                ['receiver_type', $type]
            ])
            ->latest('created_at')
            ->first();

            if($message) {
                $messageTime = $message->created_at->diffForHumans();
                $lastMessage = Str::words($message->message, 4, '...');
                $clock = '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$messageTime.'</p>';
            } else {
                $messageTime = '';
                $lastMessage = 'No messages yet';
                $clock = '';
            }

            $active = '';
            if($activelastMessage) {
                if($activelastMessage->read_at == null) {
                    $active = 'active';
                }
            }

            $output .= '<a href="#" class="dropdown-item '.$active.'">
                            <div class="media">
                                <img src="'.'http://127.0.0.1:8000/'.$student->image.'" alt="User Avatar"
                                    class="mr-3 img-circle" style="    width: 47px;
                                    height: 47px;
                                    object-fit: cover;">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                         '.$student->name.'

                                    </h3>
                                    <p class="text-sm">'.$lastMessage.'</p>
                                    '.$clock.'
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>'
            ;
        }

        return $output;
    }
}
