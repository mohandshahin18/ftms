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

use function PHPSTORM_META\type;

class MessagesController extends Controller
{
    //chats
    public function all_chats()
    {
        $auth = Auth::user();
        $output = '';
        $active = '';

        if ($auth->trainer_id && $auth->teacher_id) {
            $teacher = $auth->teacher;
            $trainer = $auth->trainer;

            $teacherLastMessage = $auth
                ->messages()
                ->where('teacher_id', $teacher->id)
                ->latest('id')
                ->first();

            $trainerLastMessage = $auth
                ->messages()
                ->where('trainer_id', $trainer->id)
                ->latest('id')
                ->first();

            $activeTrainerMessage = $auth
                ->messages()
                ->where('trainer_id', $trainer->id)
                ->where('sender_id', $trainer->id)
                ->where('sender_type', 'trainer')
                ->latest('id')
                ->first();

            $activeTeacherMessage = $auth
                ->messages()
                ->where('teacher_id', $teacher->id)
                ->where('sender_id', $teacher->id)
                ->where('sender_type', 'teacher')
                ->latest('id')
                ->first();
                
        } elseif ($auth->trainer_id) {

            // teacher = null
            $teacherLastMessage = null;
            $activeTeacherMessage = null;

            $trainer = $auth->trainer;
            $trainerLastMessage = $auth
                ->messages()
                ->where('trainer_id', $trainer->id)
                ->latest('id')
                ->first();

            $activeTrainerMessage = $auth
                ->messages()
                ->where('trainer_id', $trainer->id)
                ->where('sender_id', $trainer->id)
                ->where('sender_type', 'trainer')
                ->latest('id')
                ->first();
        } elseif ($auth->teacher_id) {
            // trainer = null
            $activeTrainerMessage = null;
            $trainerLastMessage = null;

            $teacher = $auth->teacher;
            $teacherLastMessage = $auth
                ->messages()
                ->where('teacher_id', $teacher->id)
                ->latest('id')
                ->first();
            $activeTeacherMessage = $auth
                ->messages()
                ->where('teacher_id', $teacher->id)
                ->where('sender_id', $teacher->id)
                ->where('sender_type', 'teacher')
                ->latest('id')
                ->first();
        } else {
            // teacher = null
            $teacherLastMessage = null;
            $activeTeacherMessage = null;
            // trainer = null
            $activeTrainerMessage = null;
            $trainerLastMessage = null;
        }

        if ($auth->trainer_id || $auth->teacher_id) {
            if($auth->trainer_id) {
                if ($trainerLastMessage) {
                    $LastMessage = Str::words($trainerLastMessage->message, 4, '...');
                    $time = $trainerLastMessage->created_at->diffForHumans();
                    if ($activeTrainerMessage) {
                        if ($activeTrainerMessage->read_at == null) {
                            $active = 'active';
                        }
                    }
                    $output .= '<div class="media">
                                    <a href="#" data-type="trainer"
                                        data-slug="'.$trainer->slug.'"
                                        data-name="'.$trainer->name.'"
                                        data-id="'.$trainerLastMessage->id.'"
                                        class="list-group-item list-group-item-action chat-circle '.$active.'">
                                        <div class="main-info">
                                            <div class="msg-img">
                                                <img
                                                    src="http://127.0.0.1:8000/' . $trainer->image . '">
                                            </div>
                                            <div class="msg-body" style="width: 100%;">
                                                <h3 class="dropdown-item-title">
                                                    ' . $trainer->name . '
                                                </h3>
                                                <p class="text-sm message">
                                                '.$LastMessage.'
                                                    <i class="fas fa-circle active-dot"
                                                        style="color: #003e83ad !important; font-size: 8px; "></i>
    
                                                </p>
                                                <p class="d-flex justify-content-start align-items-center msg-time"
                                                    style="gap:4px; font-size: 12px; margin:0 ">
                                                    <i class="far fa-clock "
                                                        style="line-height: 1; font-size: 12px; color: #464a4c !important;"></i>
                                                        ' . $time . '
                                                </p>
    
                                            </div>
    
    
                                        </div>
    
                                    </a>
                                </div>';
                } else {
                    $output .= '<div class="media">
                                    <a href="#" data-type="trainer"
                                        data-slug="'.$trainer->slug.'"
                                        data-name="'.$trainer->name.'"
                                        class="list-group-item list-group-item-action chat-circle">
                                        <div class="main-info">
                                            <div class="msg-img">
                                                <img
                                                    src="http://127.0.0.1:8000/' . $trainer->image . '">
                                            </div>
                                            <div class="msg-body" style="width: 100%;">
                                                <h3 class="dropdown-item-title">
                                                    '.$trainer->name.'
                                                </h3>
                                                <p class="text-sm message">
                                                    There is no messages yet!
    
                                                </p>
    
                                            </div>
    
    
                                        </div>
    
                                    </a>
                                </div>';
                }
            }

            if ($auth->teacher_id) {
                if($teacherLastMessage) {
                    $time = $teacherLastMessage->created_at->diffForHumans();
                    $LastMessage = Str::words($teacherLastMessage->message, 4, '...');
                    if($activeTeacherMessage) {
                        if($activeTeacherMessage->read_at == null) {
                            $active = 'active';
                        }
                    }
                    $output .= '<div class="media">
                                <a href="#" data-type="teacher"
                                    data-slug="'.$teacher->slug.'"
                                    data-name="'.$teacher->name.'"
                                    data-id="'.$teacherLastMessage->id.'"
                                    class="list-group-item list-group-item-action chat-circle '.$active.'">
                                    <div class="main-info">
                                        <div class="msg-img">
                                            <img
                                                src="http://127.0.0.1:8000/' . $teacher->image . '">
                                        </div>
                                        <div class="msg-body" style="width: 100%;">
                                            <h3 class="dropdown-item-title">
                                                ' . $teacher->name . '
                                            </h3>
                                            <p class="text-sm message">
                                            '.$LastMessage.'
                                                <i class="fas fa-circle active-dot"
                                                    style="color: #003e83ad !important; font-size: 8px; "></i>

                                            </p>
                                            <p class="d-flex justify-content-start align-items-center msg-time"
                                                style="gap:4px; font-size: 12px; margin:0 ">
                                                
                                                <i class="far fa-clock "
                                                    style="line-height: 1; font-size: 12px; color: #464a4c !important;"></i>
                                                    ' . $time . '
                                            </p>

                                        </div>


                                    </div>

                                </a>
                            </div>';
                } else {
                    $output .= '<div class="media">
                                    <a href="#" data-type="teacher"
                                        data-slug="'.$teacher->slug.'"
                                        data-name="'.$teacher->name.'"
                                        class="list-group-item list-group-item-action chat-circle">
                                        <div class="main-info">
                                            <div class="msg-img">
                                                <img
                                                    src="http://127.0.0.1:8000/' . $teacher->image . '">
                                            </div>
                                            <div class="msg-body" style="width: 100%;">
                                                <h3 class="dropdown-item-title">
                                                    '.$teacher->name.'
                                                </h3>
                                                <p class="text-sm message">
                                                    '.__('admin.No messages yet!').'
    
                                                </p>
    
                                            </div>
    
    
                                        </div>
    
                                    </a>
                                </div>';
                }
            } 
        } else {
            $output .='<div class="media mb-0">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="main-info" style="justify-content: center;">

                                {{-- <div class="msg-body" style="width: 100%;"> --}}
                                <p class="text-sm message"
                                    style="margin: 8px 0; color: #292b2c;">You have no one
                                    to message</p>

                                {{-- </div> --}}


                            </div>

                        </a>
                    </div>';
        }

        $msgsNumber = '';
        
        if($activeTrainerMessage || $activeTeacherMessage) {
            if($activeTrainerMessage && $activeTeacherMessage) {
                if($activeTeacherMessage->read_at == null && $activeTrainerMessage->read_at == null) {
                    $msgsNumber = 2;
                }
            } elseif($activeTrainerMessage) {
                if($activeTrainerMessage->read_at == null) {
                    $msgsNumber = 1;
                }
            } elseif($activeTeacherMessage) {
                if($activeTeacherMessage->read_at == null) {
                    $msgsNumber = 1;
                }
            }
        }

        $data = [
            "output" => $output,
            "number" => $msgsNumber,
        ];

        return $data;
    }

    // send message
    public function send_message(Request $request)
    {
        $user = Auth::user();
        $trainer = Trainer::whereSlug($request->slug)->first();
        $teacher = Teacher::whereSlug($request->slug)->first();

        if ($request->type == 'trainer') {
            $message = Message::create([
                'message' => $request->message,
                'receiver_id' => $trainer->id,
                'sender_id' => $user->id,
                'trainer_id' => $trainer->id,
                'student_id' => $user->id,
                'sender_type' => 'student',
                'receiver_type' => 'trainer',
            ]);
        } else {
            $message = Message::create([
                'message' => $request->message,
                'receiver_id' => $teacher->id,
                'sender_id' => $user->id,
                'teacher_id' => $teacher->id,
                'student_id' => $user->id,
                'sender_type' => 'student',
                'receiver_type' => 'teacher',
            ]);
        }

        broadcast(new CreateMessage($message));

        $output = '<div class="chat outgoing message" data-id="' . $message->id . '">
                                <div class="details">
                                    <p>' . $message->message . '</p>
                                </div>
                                </div>';
        return $output;
    }


    // get messages
    public function get_messages(Request $request)
    {
        $slug = $request->slug;
        $type = $request->type;
        $user = Auth::user();

        if ($type == 'trainer') {
            $trainer = Trainer::whereSlug($slug)->first();
        } else {
            $teacher = Teacher::whereSlug($slug)->first();
        }



        if ($type == 'trainer') {
            $messages = $user->messages()
                ->where('trainer_id', $trainer->id)
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
                ->reverse();
        } else {
            $messages = $user->messages()
                ->where('teacher_id', $teacher->id)
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
                ->reverse();
        }

        $output = '';

        if ($messages) {
            foreach ($messages as $message) {
                // $time = $message->created_at->format('h:i');
                // $period = $message->created_at->format('a');
                // $total_time = $time.' '.$period;

                if ($message->sender_id == $user->id) {
                    $output .= '<div class="chat outgoing message" data-id="' . $message->id . '">
                                <div class="details">
                                    <p>' . $message->message . '</p>
                                </div>
                                </div>';
                } else {
                    $output .= '<div class="chat incoming message" data-id="' . $message->id . '">
                                    <div class="details">
                                        <p>' . $message->message . '</p>
                                    </div>
                                </div>';
                }
            }
        }



        return $output;
    }


    // mark message as read
    public function read_message(Request $request)
    {
        $auth = Auth::user();
        if($request->type == 'trainer') {
            $message = $auth->messages()
            ->where([
                ['sender_type', 'trainer'],
                ['sender_id', $auth->trainer_id]
            ])
            ->latest('id')
            ->first();
        } else {
            $message = $auth->messages()
            ->where([
                ['sender_type', 'teacher'],
                ['sender_id', $auth->teacher_id]
            ])
            ->latest('id')
            ->first();
        }
        

        $message->read_at = now();
        $message->save();

    }
}
