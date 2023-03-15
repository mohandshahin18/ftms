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

        // get students messages on page load
        public function get_students_messages(Request $request)
        {
            $auth = Auth::user();
            $slug = $request->slug;
            $students = $auth->students()->limit(3)->get();
    
            if(Auth::guard('trainer')->check()) {
                $type = 'trainer';
            } else {
                $type = 'teacher';
            }
    
            $output = '';
            $number = 0;
            
            
            foreach($students as $student) {
                $active = '';
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

                $studentMessage = $auth->messages()
                ->where([
                    ['sender_id', $student->id]
                ])
                ->first();

                if($studentMessage) {

                    $activelastMessage = $auth->messages()
                    ->where([
                        ['sender_id', $student->id],
                        ['sender_type', 'student']
                    ])
                    ->latest('created_at')
                    ->first();

                    if($activelastMessage->read_at == null) {
                        $number++;
                        $active = 'active';
                    }
                }

                $output .= '<a href="#" class="dropdown-item chat-circle '.$active.'" data-slug="'.$student->slug.'" data-name="'.$student->name.'">
                                <div class="media">
                                    <img src="'.env('APP_URL').'/'.$student->image.'" alt="User Avatar"
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
            $data = [
                "output" => $output,
                "number" => $number,
            ];
            return $data;
        }

    // get student messages in chat box
    public function student_messages(Request $request)
    {
        $auth = Auth::user();
        $student = Student::whereSlug($request->slug)->first();
        $messages = $auth->messages()
        ->where('student_id', $student->id)
        ->latest('id')
        ->limit(10)
        ->get()
        ->reverse();

        $sender_type = 'teacher';
        if(Auth::guard('trainer')->check()) {
            $sender_type = 'trainer';
        }

        $output = '';
        if($messages) {
            foreach($messages as $message) {
                if($message->sender_id == $auth->id && $message->sender_type == $sender_type) {
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

    // send messages
    public function send_message(Request $request)
    {

        $auth = Auth::user();

        $student = Student::whereSlug($request->slug)->first();
        if (Auth::guard('trainer')->check()) {
            $message = Message::create([
                'message' => $request->message,
                'trainer_id' => $auth->id,
                'student_id' => $student->id,
                'sender_id' => $auth->id,
                'receiver_id' => $student->id,
                'sender_type' => 'trainer',
                'receiver_type' => 'student'
            ]);
        } else {
            $message = Message::create([
                'message' => $request->message,
                'teacher_id' => $auth->id,
                'student_id' => $student->id,
                'sender_id' => $auth->id,
                'receiver_id' => $student->id,
                'sender_type' => 'teacher',
                'receiver_type' => 'student'
            ]);
        }

        $output = '<div class="chat outgoing message" data-id="' . $message->id . '">
                                <div class="details">
                                    <p>' . $message->message . '</p>
                                </div>
                                </div>';

        broadcast(new CreateMessage($message));

        return $output;
    }


    public function readAt(Request $request)
    {
        $student = Student::whereSlug($request->slug)->first();

        $auth = Auth::user();

        $message = $auth->messages()
        ->where('sender_id', $student->id)
        ->where('sender_type', 'student')
        ->latest('created_at')
        ->first();

       if($message) {
        $message->read_at = now();
        $message->save();
       }

    }

}
