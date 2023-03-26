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
                $message = Message::where([
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

                $activelastMessage = Message::where([
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

                $studentMessage = Message::where([
                        ['receiver_type', $type],
                        ['receiver_id', $auth->id],
                        ['sender_id', $student->id]
                    ])
                    ->first();

                if ($studentMessage) {

                    $activelastMessage = Message::where([
                            ['receiver_id', $auth->id],
                            ['receiver_type', $type],
                        ])
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

                $output .= '<a href="#" class="dropdown-item chat-circle ' . $active . '" data-slug="' . $student->slug . '" data-name="' . $student->name . '" data-name="' . $student->name . '" data-id="'.$student->id.'" data-type="student">
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

    // get messages in chat box
    public function student_messages(Request $request)
    {
        $auth = Auth::user();
        if (!Auth::guard('admin')->check()) {
            $student = Student::whereSlug($request->slug)->first();
            $admin = Admin::whereSlug($request->slug)->first();

            if (Auth::guard('trainer')->check()) {
                $type = 'trainer';
            } elseif (Auth::guard('teacher')->check()) {
                $type = 'teacher';
            } else {
                $type = 'company';
            }  

            if ($student) {
                $messages = Message::where([
                        ['receiver_type', $type],
                        ['receiver_id', $auth->id],
                        ['sender_type', 'student'],
                        ['sender_id', $student->id],
                    ])

                    ->orWhere([
                        ['sender_type', $type],
                        ['sender_id', $auth->id],
                        ['receiver_type', 'student'],
                        ['receiver_id', $student->id],
                    ])
                    ->latest('id')
                    ->limit(10)
                    ->get()
                    ->reverse();
            } else {
                $messages = Message::where([
                        ['receiver_type', $type],
                        ['receiver_id', $auth->id],
                        ['sender_type', 'admin'],
                        ['sender_id', $admin->id],   
                    ])
                    ->orWhere([
                        ['sender_type', $type],
                        ['sender_id', $auth->id],
                        ['receiver_type', 'admin'],
                        ['receiver_id', $admin->id], 
                    ])
                    ->latest('id')
                    ->limit(10)
                    ->get()
                    ->reverse();
            }

            $sender_type = 'teacher';
            if (Auth::guard('trainer')->check()) {
                $sender_type = 'trainer';
            } elseif(Auth::guard('company')->check()) {
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
            $teacher = Teacher::whereSlug($request->slug)->first();


            if($company) {
                $messages = Message::where([
                        ['sender_id', $auth->id],
                        ['sender_type', 'admin'],
                        ['receiver_id', $company->id],
                        ['receiver_type', 'company'],
                    ])
                    ->orWhere([
                        ['sender_id', $company->id],
                        ['sender_type', 'company'],
                        ['receiver_id', $auth->id],
                        ['receiver_type', 'admin'],
                    ])
                    ->latest('created_at')
                    ->limit(10)
                    ->get()
                    ->reverse();
            } elseif($trainer) {
                $messages = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', 'admin'],
                    ['receiver_id', $trainer->id],
                    ['receiver_type', 'trainer'],
                ])
                ->orWhere([
                    ['sender_id', $trainer->id],
                    ['sender_type', 'trainer'],
                    ['receiver_id', $auth->id],
                    ['receiver_type', 'admin'],
                ])
                ->latest('created_at')
                ->limit(10)
                ->get()
                ->reverse();
            } else {
                $messages = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', 'admin'],
                    ['receiver_id', $teacher->id],
                    ['receiver_type', 'teacher'],
                ])
                ->orWhere([
                    ['sender_id', $teacher->id],
                    ['sender_type', 'teacher'],
                    ['receiver_id', $auth->id],
                    ['receiver_type', 'admin'],
                ])
                ->latest('created_at')
                ->limit(10)
                ->get()
                ->reverse();
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
        $trainer = Trainer::whereSlug($request->slug)->first();
        $company = Company::whereSlug($request->slug)->first();
        $admin = Admin::whereSlug($request->slug)->first();
        $teacher = Teacher::whereSlug($request->slug)->first();

        if (Auth::guard('trainer')->check()) {
            if($student) {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $student->id,
                    'sender_type' => 'trainer',
                    'receiver_type' => 'student'
                ]);
            } else {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $admin->id,
                    'sender_type' => 'trainer',
                    'receiver_type' => 'admin'
                ]);
            }
        } elseif(Auth::guard('teacher')->check()) {
            if($student) {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $student->id,
                    'sender_type' => 'teacher',
                    'receiver_type' => 'student'
                ]);
            } else {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $admin->id,
                    'sender_type' => 'teacher',
                    'receiver_type' => 'admin'
                ]);
            }
        } elseif(Auth::guard('company')->check()) {
            if($student) {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $student->id,
                    'sender_type' => 'company',
                    'receiver_type' => 'student'
                ]);

            } else {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $admin->id,
                    'sender_type' => 'company',
                    'receiver_type' => 'admin'
                ]);
            }

        } else {
            if($company) {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $company->id,
                    'sender_type' => 'admin',
                    'receiver_type' => 'company'
                ]);
            } elseif($trainer) {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $trainer->id,
                    'sender_type' => 'admin',
                    'receiver_type' => 'trainer'
                ]);
            } else {
                $message = Message::create([
                    'message' => $request->message,
                    'sender_id' => $auth->id,
                    'receiver_id' => $teacher->id,
                    'sender_type' => 'admin',
                    'receiver_type' => 'teacher'
                ]);
            }
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
            $teacher = Teacher::whereSlug($slug)->first();

            if($company) {
                $message = Message::where([
                        ['sender_type', 'company'],
                        ['receiver_type', 'admin'],
                        ['sender_id', $company->id],
                        ['receiver_id', $auth->id],
                    ])  
                    ->latest('created_at')
                    ->first();
            } elseif($trainer) {
                $message = Message::where([
                        ['sender_type', 'trainer'],
                        ['receiver_type', 'admin'],
                        ['sender_id', $trainer->id],
                        ['receiver_id', $auth->id],
                    ])
                    ->latest('created_at')
                    ->first();
            } else {
                $message = Message::where([
                    ['sender_type', 'teacher'],
                    ['receiver_type', 'admin'],
                    ['sender_id', $teacher->id],
                    ['receiver_id', $auth->id],
                ])
                    ->latest('created_at')
                    ->first();
            }

            if($message) {
                $message->read_at = now();
                $message->save();
            }

        } else {
            $student = Student::whereSlug($slug)->first();
            $admin = Admin::whereSlug($slug)->first();

            if(Auth::guard('trainer')->check()) {
                $role = 'trainer';
            } elseif(Auth::guard('teacher')->check()) {
                $role = 'teacher';
            
            } else {
                $role = 'company';
            }
            if($student) {
                $message = Message::where([
                    ['sender_type', $role],
                    ['receiver_type', 'admin'],
                    ['sender_id', $student->id],
                    ['receiver_id', $auth->id],
                ])
                ->latest('created_at')
                ->first();
            } else {
                $message = Message::where([
                    ['sender_type', $role],
                    ['receiver_type', 'admin'],
                    ['sender_id', $student->id],
                    ['receiver_id', $auth->id],
                ])
                ->latest('created_at')
                ->first();
            }

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
                if(Auth::guard('trainer')->check()) {
                    $role = 'trainer';
                } elseif(Auth::guard('company')->check()) {
                    $role = 'company';
                } else {
                    $role = 'teacher';
                }
                foreach ($auth->students as $student) {
                    $message = Message::where([
                            ['sender_type', 'student'],
                            ['receiver_type', $role],
                            ['sender_id', $student->id],
                            ['receiver_id', $auth->id],
                        ])
                        ->orWhere([
                            ['sender_type', $role],
                            ['receiver_type', 'student'],
                            ['sender_id', $auth->id],
                            ['receiver_id', $student->id],
                        ])
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
                    data-name="' . $student->name . '"
                    data-type="student"
                    data-id="' . $student->id . '">
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
        $auth = Auth::user();

        if (Auth::guard('admin')->check()) {
        } elseif(Auth::guard('company')->check() || Auth::guard('teacher')->check()) {
            foreach ($admins as $admin) {
                if(Auth::guard('company')->check()) {
                    $role = 'company';
                } else {
                    $role = 'teacher';
                }
                $message = Message::where([
                        ['sender_id', $auth->id],
                        ['sender_type', $role],
                        ['receiver_id', $admin->id],
                        ['receiver_type', 'admin']
                    ])
                    ->orWhere([
                        ['sender_id', $admin->id],
                        ['sender_type', 'admin'],
                        ['receiver_id', $auth->id],
                        ['receiver_type', $role]
                    ])
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
                data-name="' . $admin->name . '"
                data-type="admin"
                data-id="' . $admin->id . '">
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

            $message = Message::where([
                    ['sender_type', 'admin'],
                    ['sender_id', $auth->id],
                    ['receiver_type', 'company'],
                    ['receiver_id', $company->id],
                ])
                ->orWhere([
                    ['sender_type', 'company'],
                    ['sender_id', $company->id],
                    ['receiver_type', 'admin'],
                    ['receiver_id', $auth->id],
                ])
                ->latest('created_at')
                ->first();

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

            $message = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', 'admin'],
                    ['receiver_id', $teacher->id],
                    ['receiver_type', 'teacher'],
                ])
                ->orWhere([
                    ['sender_id', $teacher->id],
                    ['sender_type', 'teacher'],
                    ['receiver_id', $auth->id],
                    ['receiver_type', 'admin'],
                ])
                ->latest('created_at')
                ->first();

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
