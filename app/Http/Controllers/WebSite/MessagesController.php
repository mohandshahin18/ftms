<?php

namespace App\Http\Controllers\Website;

use App\Events\CreateMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Teacher;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MessagesController extends Controller
{
    //chats
    public function student_chats($slug)
    {
        $auth = Auth::user();
        $trainer = Trainer::whereSlug($slug)->first();
        $teacher = Teacher::whereSlug($slug)->first();

        if($trainer) {
            $user = $trainer;
            $last = $auth->messages()->where('trainer_id', $trainer->id)->latest('id')->first();
        }else {
            $user = $teacher;
            $last = $auth->messages()->where('teacher_id', $teacher->id)->latest('id')->first();
        }
        if($last) {
            $last->read_at = now();
            $last->save();
        }
        return view('student.messages.index', compact('user'));
    }

    // send message
    public function send_message(Request $request)
    {
        $user = Auth::user();
        $trainer = Trainer::whereSlug($request->reciver_id)->first();
        $teacher = Teacher::whereSlug($request->reciver_id)->first();

        if($trainer) {
            $messages = Message::create([
                'message' => $request->message,
                'receiver_id' => $trainer->id,
                'sender_id' => $user->id,
                'trainer_id' => $trainer->id,
                'student_id' => $user->id,
                'sender_type' => 'student',
                'receiver_type' => 'trainer',
            ]);
        }else {
            $messages = Message::create([
                'message' => $request->message,
                'receiver_id' => $teacher->id,
                'sender_id' => $user->id,
                'teacher_id' => $teacher->id,
                'student_id' => $user->id,
                'sender_type' => 'student',
                'receiver_type' => 'teacher',
            ]);
        }

        broadcast(new CreateMessage($messages, $user->image));
    }


    // get messages
    public function get_messages(Request $request)
    {
        $slug = $request->reciver_id;
        $user = Auth::user();
        $trainer = Trainer::whereSlug($slug)->first();
        $teacher = Teacher::whereSlug($slug)->first();

        if($trainer) {
            $messages = $user->messages()
            ->where('trainer_id', $trainer->id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->reverse();

        }else {
            $messages = $user->messages()
            ->where('teacher_id', $teacher->id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->reverse();

        }

        $output = '';

        if($messages) {
            foreach($messages as $message) {
                $time = $message->created_at->format('h:i');
                $period = $message->created_at->format('a');
                $total_time = $time.' '.$period;

                if($message->sender_id == $user->id) {
                    $output .= '<div class="chat outgoing message" data-id="'.$message->id.'">
                                <div class="details">
                                    <p>'.$message->message.'</p>
                                    <span class="time">'.$total_time.'</span>
                                </div>
                                </div>';
                }else {
                    if($trainer) {
                        $image = $trainer->image;
                    }else {
                        $image = $teacher->image;
                    }
                    $output .= '<div class="chat incoming message" data-id="'.$message->id.'">
                                    <img src="'.'http://127.0.0.1:8000/'.$image.'" alt="">
                                    <div class="details">
                                        <p>'.$message->message.'</p>
                                        <span class="time">'.$total_time.'</span>
                                    </div>
                                </div>';
                }
            }


        }

        return $output;
    }

    // get chats
    public function get_chats()
    {
        $user = Auth::user();
        $trainer = $user->trainer;
        $teacher = $user->teacher;

        $output = '';

        $trainerMessage = Message::where([
            ['sender_id', $trainer->id],
            ['receiver_id', $user->id],
            ['sender_type', 'trainer'],
            ['receiver_type', 'student']
        ])
        ->orWhere([
            ['sender_id', $user->id],
            ['receiver_id', $trainer->id],
            ['sender_type', 'student'],
            ['receiver_type', 'trainer'],
        ])
        ->latest('id')
        ->first();

        $teacherMessage = Message::where([
            ['sender_id', $teacher->id],
            ['receiver_id', $user->id],
            ['sender_type', 'teacher'],
            ['receiver_type', 'student']
        ])
        ->orWhere([
            ['sender_id', $user->id],
            ['receiver_id', $teacher->id],
            ['sender_type', 'student'],
            ['receiver_type', 'teacher'],
        ])
        ->latest('id')
        ->first();

        if($teacherMessage) {
            $teacherTime = $teacherMessage->created_at->diffForHumans();
            $teacherLastMessage = Str::words($teacherMessage->message, 4, '...');
        }else {
            $teacherTime = '';
            $teacherLastMessage = 'No messages yet';
        }

        if($trainerMessage) {
            $trainerTime = $trainerMessage->created_at->diffForHumans();
            $trainerLastMessage = Str::words($trainerMessage->message, 4, '...');
        }else {
            $trainerTime = '';
            $trainerLastMessage = 'No messages yet';
        }

       if($trainerMessage && $teacherMessage) {
            if($trainerMessage->created_at > $teacherMessage->created_at) {
                $output .= '<a href="" class="chat-box " data-slug="'.$trainer->slug.'">
                                <div class="content">
                                    <div class="chat-img">
                                        <img src="'.'http://127.0.0.1:8000/'.$trainer->image.'" alt="">
                                    </div>
                                    <div class="chat-details">
                                        <span><b>'.$trainer->name.'</b></span>
                                        <div class="chat-message">
                                            <p id="last_msg">'.$trainerLastMessage.'</p>
                                            <span id="time-send">'.$trainerTime.'</span>
                                        </div>
                                    </div>
                                </div>
                            </a>'
                ;

                $output .= '<a href="" class="chat-box" data-slug="'.$teacher->slug.'">
                                <div class="content">
                                    <div class="chat-img">
                                        <img src="'.'http://127.0.0.1:8000/'.$teacher->image.'" alt="">
                                    </div>
                                    <div class="chat-details">
                                        <span><b>'.$teacher->name.'</b></span>
                                        <div class="chat-message">
                                            <p id="last_msg">'.$teacherLastMessage.'</p>
                                            <span id="time-send">'.$teacherTime.'</span>
                                        </div>
                                    </div>
                                </div>
                            </a>'
                ;
        }else {
                $output .= '<a href="" class="chat-box " data-slug="'.$teacher->slug.'">
                                <div class="content">
                                    <div class="chat-img">
                                        <img src="'.'http://127.0.0.1:8000/'.$teacher->image.'" alt="">
                                    </div>
                                    <div class="chat-details">
                                        <span><b>'.$teacher->name.'</b></span>
                                        <div class="chat-message">
                                            <p id="last_msg">'.$teacherLastMessage.'</p>
                                            <span id="time-send">'.$teacherTime.'</span>
                                        </div>
                                    </div>
                                </div>
                            </a>'
                ;

                $output .= '<a href="" class="chat-box" data-slug="'.$trainer->slug.'">
                                <div class="content">
                                    <div class="chat-img">
                                        <img src="'.'http://127.0.0.1:8000/'.$trainer->image.'" alt="">
                                    </div>
                                    <div class="chat-details">
                                        <span><b>'.$trainer->name.'</b></span>
                                        <div class="chat-message">
                                            <p id="last_msg">'.$trainerLastMessage.'</p>
                                            <span id="time-send">'.$trainerTime.'</span>
                                        </div>
                                    </div>
                                </div>
                            </a>'
                ;
        }
       } elseif($trainerMessage) {
            $output .= '<a href="" class="chat-box " data-slug="'.$trainer->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$trainer->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$trainer->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$trainerLastMessage.'</p>
                                        <span id="time-send">'.$trainerTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
            ;

            $output .= '<a href="" class="chat-box" data-slug="'.$teacher->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$teacher->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$teacher->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$teacherLastMessage.'</p>
                                        <span id="time-send">'.$teacherTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
            ;
       } elseif($teacherMessage) {
            $output .= '<a href="" class="chat-box " data-slug="'.$teacher->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$teacher->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$teacher->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$teacherLastMessage.'</p>
                                        <span id="time-send">'.$teacherTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
            ;

            $output .= '<a href="" class="chat-box" data-slug="'.$trainer->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$trainer->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$trainer->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$trainerLastMessage.'</p>
                                        <span id="time-send">'.$trainerTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
            ;
       } else {
            $output .= '<a href="" class="chat-box " data-slug="'.$trainer->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$trainer->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$trainer->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$trainerLastMessage.'</p>
                                        <span id="time-send">'.$trainerTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
                    ;

            $output .= '<a href="" class="chat-box" data-slug="'.$teacher->slug.'">
                            <div class="content">
                                <div class="chat-img">
                                    <img src="'.'http://127.0.0.1:8000/'.$teacher->image.'" alt="">
                                </div>
                                <div class="chat-details">
                                    <span><b>'.$teacher->name.'</b></span>
                                    <div class="chat-message">
                                        <p id="last_msg">'.$teacherLastMessage.'</p>
                                        <span id="time-send">'.$teacherTime.'</span>
                                    </div>
                                </div>
                            </div>
                        </a>'
            ;
       }


        return $output;
    }

    // get user messages
    public function get_user_messages($slug)
    {
        $auth = Auth::user();
        $trainer = Trainer::whereSlug($slug)->first();
        $teacher = Teacher::whereSlug($slug)->first();

        if($trainer) {
            $user = $trainer;
            $messages = $auth->messages()->where('trainer_id', $user->id)->orderBy('id', 'desc')->limit(10)->get()->reverse();
        }else {
            $user = $teacher;
            $messages = $auth->messages()->where('teacher_id', $user->id)->orderBy('id', 'desc')->limit(10)->get()->reverse();
        }


        $image = 'http://127.0.0.1:8000/'.$user->image;
        $data = [
            'messages' => $messages,
            'user' => $user,
            'auth' => $auth,
            'image' => $image
        ];
        return $data;


    }


    // mark message as read
    public function read_message(Request $request)
    {
        $message = Message::where('id', $request->msg)->first();

        $message->read_at = now();
        $message->save();
    }
}
