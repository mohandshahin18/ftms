<?php

namespace App\Http\Controllers;

use App\Events\CreateMessage;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Trainer;
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

        if (Auth::guard('admin')->check()) {
            $output = '<div class="all">
                            <a href="' . route('admin.all.messages.page') . '" class="dropdown-item dropdown-footer text-center">Show All Messages</a>
                        </div>';
            $data = [
                "output" => $output,
            ];
            return $data;
        } else {
            $students = $auth->students()->limit(3)->get();

            if (Auth::guard('trainer')->check()) {
                $type = 'trainer';
            } elseif (Auth::guard('teacher')->check()) {
                $type = 'teacher';
            } else {
                $type = 'company';
            }

            $output = '';
            $number = 0;


            foreach ($students as $student) {
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

                if ($message) {
                    $messageTime = $message->created_at->diffForHumans();
                    $lastMessage = Str::words($message->message, 4, '...');
                    $clock = '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>' . $messageTime . '</p>';
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

                if ($studentMessage) {

                    $activelastMessage = $auth->messages()
                        ->where([
                            ['sender_id', $student->id],
                            ['sender_type', 'student']
                        ])
                        ->latest('created_at')
                        ->first();

                    if ($activelastMessage->read_at == null) {
                        $number++;
                        $active = 'active';
                    }
                }

                $output .= '<a href="#" class="dropdown-item chat-circle ' . $active . '" data-slug="' . $student->slug . '" data-name="' . $student->name . '">
                            <div class="media">
                                <img src="' . env('APP_URL') . '/' . $student->image . '" alt="User Avatar"
                                    class="mr-3 img-circle" style="    width: 47px;
                                    height: 47px;
                                    object-fit: cover;">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                            ' . $student->name . '

                                    </h3>
                                    <p class="text-sm">' . $lastMessage . '</p>
                                    ' . $clock . '
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>';
            }
            $output .= '<div class="all">
                        <a href="' . route('admin.all.messages.page') . '" class="dropdown-item dropdown-footer text-center">Show All Messages</a>
                    </div>';
            $data = [
                "output" => $output,
                "number" => $number,
            ];
            return $data;
        }
    }

    // get student messages in chat box
    public function student_messages(Request $request)
    {
        $auth = Auth::user();
        if (!Auth::guard('admin')->check()) {
            $student = Student::whereSlug($request->slug)->first();
            $admin = Admin::whereSlug($request->slug)->first();

            if ($student) {
                $messages = $auth->messages()
                    ->where('student_id', $student->id)
                    ->latest('id')
                    ->limit(10)
                    ->get()
                    ->reverse();
            } else {
                $messages = $auth->messages()
                    ->where('admin_id', $admin->id)
                    ->latest('id')
                    ->limit(10)
                    ->get()
                    ->reverse();
            }

            $sender_type = 'teacher';
            if (Auth::guard('trainer')->check()) {
                $sender_type = 'trainer';
            } else {
                $sender_type = 'company';
            } 

            $output = '';
            if ($messages) {
                foreach ($messages as $message) {
                    if ($message->sender_id == $auth->id && $message->sender_type == $sender_type) {
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
        } else {
            $company = Company::whereSlug($request->slug)->first();
            $trainer = Trainer::whereSlug($request->slug)->first();

            
            if($company) {
                $messages = $auth->messages()->where('company_id', $company->id)->latest('created_at')->limit(10)->get()->reverse();
            } else {
                $messages = $auth->messages()->where('trainer_id', $trainer->id)->latest('created_at')->limit(10)->get()->reverse();
            }

            $output = '';
            if ($messages) {
                foreach ($messages as $message) {
                    if ($message->sender_id == $auth->id && $message->sender_type == 'admin') {
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

    // message read at 
    public function readAt(Request $request)
    {
        $auth = Auth::user();
        $slug = $request->slug;

        if(Auth::guard('admin')->check()) {
            $trainer = Trainer::whereSlug($slug)->first();
            $company = Company::whereSlug($slug)->first();

            if($company) {
                $message = $auth->messages()
                    ->where('sender_type', 'company')
                    ->where('sender_id', $company->id)
                    ->latest('created_at')
                    ->first();
            } else {
                $message = $auth->messages()
                    ->where('sender_type', 'trainer')
                    ->where('sender_id', $trainer->id)
                    ->latest('created_at')
                    ->first();
            }

            if($message) {
                $message->read_at = now();
                $message->save();
            }

        } else {
            $student = Student::whereSlug($slug)->first();

            $message = $auth->messages()
                ->where('sender_id', $student->id)
                ->where('sender_type', 'student')
                ->latest('created_at')
                ->first();

            if ($message) {
                $message->read_at = now();
                $message->save();
            }
        }
    }

    // all messages page
    public function all_messages_request()
    {
        $output = '';
        $auth = Auth::user();

        if (Auth::guard('admin')->check()) {
        } else {
            if ($auth->students) {
                foreach ($auth->students as $student) {
                    $message = $auth->messages()
                        ->where('student_id', $student->id)
                        ->latest('created_at')
                        ->first();
                    $Lastmessage = __('admin.No messages yet!');
                    $time = '';
                    $unread = '';

                    if ($message) {
                        $Lastmessage = $message->message;
                        $time = $message->created_at->diffForHumans();
                        $time = '<small><i
                        class="far fa-clock mr-1"></i>' . $time . '</small>';

                        if ($message->read_at == null) {
                            $unread = 'notification-list--unread';
                        }
                    }

                    if($student->image) {
                        $src = asset($student->image);
                    } else {
                        $src = 'https://ui-avatars.com/api/?background=random&name=' . $student->name;
                    }


                    $output .= '<a href="#" style="font-weight: unset" class="chat-circle main-msg" data-slug="' . $student->slug . '"
                    data-name="' . $student->name . '">
                                    <div class="notification-list ' . $unread . '">
                                        <p class="open-msg">open</p>
                                        <div class="notification-list_content">
                                            <div class="notification-list_img">
                                                <img src="' . $src . '" width="60" height="60" alt="user"
                                                    style="object-fit: cover; border-radius: 50%">
                                            </div>
                                            <div style="width: 100%">
                                                <div class="notification-list_detail">
                                                    <p><b>' . $student->name . '</b>
                                                        <br>' . $Lastmessage . ' 
                                                    </p>
                                                    <p class="text-muted">' . $time . '</p>
                                                </div>
    
    
    
    
                                            </div>
                                        </div>
                                    </div>
                                </a>';
                }
            } else {
                $output .= '<div class="text-center">
                                <img src="' . asset('adminAssets/dist/img/folder.png') . '" alt="" width="300">
                                <br>
                                <p class=" mt-3 mb-5 text-center">There is no students yet</p>
                            </div>';
            }
        }

        return $output;
    }

    // all admins messages 
    public function all_admins_messages()
    {
        $admins = Admin::all();
        $output = '';

        if (Auth::guard('admin')->check()) {
        } else {
            foreach ($admins as $admin) {
                $message = Auth::user()->messages()
                    ->where('student_id', $admin->id)
                    ->latest('created_at')
                    ->first();

                $Lastmessage = __('admin.No messages yet!');
                $time = '';
                $unread = '';

                if ($message) {
                    $Lastmessage = $message->message;
                    $time = $message->created_at->diffForHumans();
                    $time = '<small><i
                    class="far fa-clock mr-1"></i>' . $time . '</small>';

                    if ($message->read_at == null) {
                        $unread = 'notification-list--unread';
                    }
                }

                if($admin->image) {
                    $src = asset($admin->image);
                } else {
                    $src = 'https://ui-avatars.com/api/?background=random&name=' . $admin->name;
                }

                $output .= '<a href="#" style="font-weight: unset" class="chat-circle main-msg" data-slug="' . $admin->slug . '"
                data-name="' . $admin->name . '">
                                <div class="notification-list ' . $unread . '">
                                    <p class="open-msg">open</p>
                                    <div class="notification-list_content">
                                        <div class="notification-list_img">
                                            <img src="' . $src . '" width="60" height="60" alt="user"
                                                style="object-fit: cover; border-radius: 50%">
                                        </div>
                                        <div style="width: 100%">
                                            <div class="notification-list_detail">
                                                <p><b>' . $admin->name . '</b>
                                                    <br>' . $Lastmessage . ' 
                                                </p>
                                                <p class="text-muted">' . $time . '</p>
                                            </div>
    
    
    
    
                                        </div>
                                    </div>
                                </div>
                            </a>';
            }

            return $output;
        }
    }

    // ajax search students messages
    public function search_students_messages(Request $request)
    {
        $value = $request->value;

        $students = Student::where('name', 'like', '%' . $value . '%')
            ->orWhere('student_id', 'like', '%' . $value . '%')
            ->get();
        return view('admin.messages.messages_search_result', compact('students'));
    }

    // request all companies msgs for admin
    public function all_companies_messages()
    {
        $auth = Auth::user();
        $companies = Company::latest('id')->take(2)->get();
        $output = '';

        foreach ($companies as $company) {
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';

            $message = $auth->messages()->where('company_id', $company->id)->latest('created_at')->first();

            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';

                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }

            if($company->image) {
                $src = asset($company->image);
            } else {
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $company->name;
            }

            $output .= '<a href="" style="font-weight: unset" class="chat-circle main-msg" data-slug="' . $company->slug . '"
                data-name="' . $company->name . '">
                                <div class="notification-list ' . $unread . '">
                                    <p class="open-msg">open</p>
                                    <div class="notification-list_content">
                                        <div class="notification-list_img">
                                            <img src="' . $src . '" width="60" height="60" alt="user"
                                                style="object-fit: cover; border-radius: 50%">
                                        </div>
                                        <div style="width: 100%">
                                            <div class="notification-list_detail">
                                                <p><b>' . $company->name . '</b>
                                                    <br>' . $lastMessage . ' 
                                                </p>
                                                <p class="text-muted">' . $time . '</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>';
        }

        return $output;
    }

    // request all trainers msgs for admin
    public function all_teachers_messages()
    {
        $auth = Auth::user();
        $teachers = Teacher::latest('id')->limit(2)->get();
        $output = '';

        foreach ($teachers as $teacher) {
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';

            $message = $auth->messages()->where('teacher_id', $teacher->id)->latest('created_at')->first();

            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';

                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }

            if($teacher->image) {
                $src = asset($teacher->image);
            } else {
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $teacher->name;
            }

            $output .= '<a href="#" style="font-weight: unset" class="chat-circle main-msg" data-slug="' . $teacher->slug . '"
                data-name="' . $teacher->name . '">
                                <div class="notification-list ' . $unread . '">
                                    <p class="open-msg">open</p>
                                    <div class="notification-list_content">
                                        <div class="notification-list_img">
                                            <img src="' . $src . '" width="60" height="60" alt="user"
                                                style="object-fit: cover; border-radius: 50%">
                                        </div>
                                        <div style="width: 100%">
                                            <div class="notification-list_detail">
                                                <p><b>' . $teacher->name . '</b>
                                                    <br>' . $lastMessage . ' 
                                                </p>
                                                <p class="text-muted">' . $time . '</p>
                                            </div>
    
    
    
    
                                        </div>
                                    </div>
                                </div>
                            </a>';
        }

        return $output;
    }

    // load more companies
    public function load_more_companies(Request $request)
    {
        $page = $request->page;
        $offset = $page * 2;
        $companies = Company::latest('id')
            ->offset($offset)
            ->take(2)
            ->get();

        return view('admin.messages.load_more_messages', compact('companies'));
    }


    // load more teachers
    public function load_more_teachers(Request $request)
    {
        $page = $request->page;
        $offset = $page * 2;
        $teachers = Teacher::latest('id')
            ->offset($offset)
            ->take(2)
            ->get();

        return view('admin.messages.load_more_messages', compact('teachers'));
    }


    // load more students
    public function load_more_students(Request $request)
    {
        $page = $request->page;
        $offset = $page * 2;
        $students = Student::latest('id')
            ->offset($offset)
            ->take(2)
            ->get();

        return view('admin.messages.load_more_messages', compact('students'));
    }
}
