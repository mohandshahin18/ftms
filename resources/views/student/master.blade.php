<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('studentAssets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- Sweat Alert -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('studentAssets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    @if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('studentAssets/css/style-ar.css') }}">
        <style>
               body {
                direction: rtl
            }
            body,
            html {
                font-family: event-reg;
            }
            .btn,
            input {
                font-family: event-reg !important;
            }
            #toast-container>div {
                font-family: event-reg !important;
            }

            @font-face {
                font-family: event-reg;
                src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
            }
        </style>
    @endif

    @yield('styles')


    <title> {{ config('app.name') }} | @yield('title') </title>

</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    {{-- oncontextmenu="return false;" --}}

    @php
        use App\Models\Company;
        use App\Models\Category;
        use App\Models\Trainer;
        $auth = Auth::user();

        $data = json_decode(File::get(storage_path('app/settings.json')), true);
    @endphp


    <div data-component="navbar">
        <div class="container-fluid">

            @php
                $name = Auth::guard()->user()->name ?? '';
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;

                if (Auth::guard()->user()->image) {
                    $img = Auth::guard()->user()->image;
                    $src = asset($img);
                }

            @endphp
            <nav class="navbar p-0 ">
                <button class="navbar-toggler navbar-toggler-left rounded-0 border-0" type="button"
                    data-toggle="collapse" data-target="#megamenu-dropdown" aria-controls="megamenu-dropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="w-100 d-felx justify-content-between">
                    <a class="navbar-brand px-1" href="{{ route('student.home') }}">
                        <img src="{{ asset($data['logo']) }}" class="d-inline-block mt-1" alt="AgentFire Logo">
                    </a>


                    <div class="right-links float-right mr-4">
                        {{-- <a href="{{ route('student.home') }}" class="home"><i class="fa fa-home mr-3"></i></a> --}}

                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                {{-- <i class="fas fa-globe-europe"> --}}
                                <span class="badge badge-danger navbar-badge"></span><i class="far fa-globe-europe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right rounded-0 "
                                style="min-width: unset !important; width: 120px;" aria-labelledby="messages">

                                <div class="dropdown-links pl-3">

                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a rel="alternate" class="text-secondary" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                            style="width:110px !important">
                                            {{ $properties['native'] }}
                                            ({{ $properties['regional'] }})
                                        </a>
                                    @endforeach



                                </div>
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->



                        <div class="d-inline dropdown  mr-3">

                            <a class="dropdown-toggle notify" id="notifications" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" href="#">
                                <span class="badge badge-danger navbar-badge"></span><i class="far fa-bell"></i>
                                @if ($auth->unreadNotifications->count() > 0)
                                    <span class="notify-number">{{ $auth->unreadNotifications->count() }}</span>
                                @endif
                            </a>


                            <div class="dropdown-menu dropdown-menu-right rounded-0 pt-0"
                                aria-labelledby="notifications">
                                <div class="list-group">
                                    <div class="lg" id="dropNotification">

                                        @forelse ($auth->notifications as $notify)
                                            @php
                                                if ($notify->data['from'] == 'apply') {
                                                    $company = Company::where('id', $notify->data['company_id'])->first();
                                                    $company = $company->image;

                                                    $name = $notify->data['name'] ?? '';
                                                    $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                                    if ($company) {
                                                        $img = $company;
                                                        $notifySrc = asset($img);
                                                    }
                                                } elseif ($notify->data['from'] == 'task') {
                                                    $trainer = Trainer::where('id', $notify->data['trainer_id'])->first();
                                                    $trainer = $trainer->image;

                                                    $name = $notify->data['name'] ?? '';
                                                    $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                                    if ($trainer) {
                                                        $img = $trainer;
                                                        $notifySrc = asset($img);
                                                    }
                                                }

                                            @endphp

                                            <div class="media">
                                                <a href="{{ route('student.mark_read', $notify->id) }}"
                                                    class="list-group-item list-group-item-action {{ $notify->read_at ? '' : 'active' }}"
                                                    style="font-weight: unset">

                                                    <div class="main-info">
                                                        <div class="d-flex align-items-center"
                                                            style="gap:8px !important;">
                                                            <img src="{{ $notifySrc }}">
                                                            <h3 class="dropdown-item-title">{{ $notify->data['name'] }}
                                                            </h3>
                                                        </div>
                                                        <div>
                                                            <p class="d-flex justify-content-start align-items-center float-right"
                                                                style="gap:4px; font-size: 12px; margin:0 ">
                                                                <i class="far fa-clock "
                                                                    style="line-height: 1; font-size: 12px; color: #464a4c !important"></i>
                                                                {{ $notify->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="media-body mt-2">

                                                        <p class="text-sm">{{ $notify->data['msg'] }}</p>


                                                    </div>

                                                </a>
                                            </div>
                                        @empty
                                            <p class=" mt-3 mb-5 text-center " id="no_notification">There are no
                                                Notifications yet</p>
                                        @endforelse




                                    </div> <!-- /.lg -->
                                    <div class="all-notify">
                                        <p><a href="{{ route('student.read_notify') }}">Show All Notifications</a></p>
                                    </div>
                                </div> <!-- /.list group -->
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->

                        {{-- Chats --}}

                        @if ($auth->teacher_id && $auth->trainer_id)
                            @php
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

                            @endphp
                        @elseif ($auth->trainer_id)
                            @php

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
                            @endphp
                        @elseif ($auth->teacher_id)
                            @php
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
                            @endphp
                        @else
                            @php
                                // teacher = null
                                $teacherLastMessage = null;
                                $activeTeacherMessage = null;
                                // trainer = null
                                $activeTrainerMessage = null;
                                $trainerLastMessage = null;
                            @endphp
                        @endif
                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#"><i class="far fa-envelope"></i>
                                @if ($auth->trainer_id && $auth->teacher_id)
                                    @if ($activeTrainerMessage)
                                        @if ($activeTrainerMessage->read_at == null)
                                            <span class="notify-number">1</span>
                                        @endif
                                    @endif
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="messages">
                                <!-- <a class="dropdown-item">There are no new messages</a> -->
                                <div class="list-group">
                                    <div class="lg">
                                        @if ($auth->trainer_id && $auth->teacher_id)
                                            @if ($trainerLastMessage || $teacherLastMessage)
                                                @if ($trainerLastMessage)
                                                    <div class="media">
                                                        <a href="#" data-type="trainer"
                                                            data-slug="{{ $trainer->slug }}"
                                                            data-name="{{ $trainer->name }}"
                                                            class="list-group-item list-group-item-action chat-circle @if ($activeTrainerMessage) @if ($activeTrainerMessage->read_at == null)
                                                                {{ 'active' }} @endif
                                                        @endif ">
                                                            <div class="main-info">
                                                                <div class="msg-img">
                                                                    <img
                                                                        src="{{ asset('http://127.0.0.1:8000/' . $trainer->image) }}">
                                                                </div>
                                                                <div class="msg-body" style="width: 100%;">
                                                                    <h3 class="dropdown-item-title">
                                                                        {{ $trainer->name }}
                                                                    </h3>
                                                                    <p class="text-sm message">
                                                                        {{ $trainerLastMessage ? Str::words($trainerLastMessage->message, 4, '...') : 'No messages yet' }}

                                                                        <i class="fas fa-circle active-dot"
                                                                            style="color: #003e83ad !important; font-size: 8px; "></i>

                                                                    </p>
                                                                    <p class="d-flex justify-content-start align-items-center float-right"
                                                                        style="gap:4px; font-size: 12px; margin:0 ">
                                                                        <i class="far fa-clock "
                                                                            style="line-height: 1; font-size: 12px; color: #464a4c !important; {{ $trainerLastMessage ? 'display: block;' : 'display: none;' }}"></i>
                                                                        {{ $trainerLastMessage ? $trainerLastMessage->created_at->diffForHumans() : '' }}
                                                                    </p>

                                                                </div>


                                                            </div>

                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($teacherLastMessage)
                                                    <div class="media">
                                                        <a href="#" data-type="teacher"
                                                            data-slug="{{ $teacher->slug }}"
                                                            data-name="{{ $teacher->name }}"
                                                            class="list-group-item list-group-item-action chat-circle @if ($activeTeacherMessage) {{ $activeTeacherMessage->read_at == null ? 'active' : '' }} @endif">
                                                            <div class="main-info">
                                                                <div class="msg-img">
                                                                    <img
                                                                        src="{{ asset('http://127.0.0.1:8000/' . $teacher->image) }}">

                                                                </div>
                                                                <div class="msg-body" style="width: 100%;">
                                                                    <h3 class="dropdown-item-title">
                                                                        {{ $teacher->name }}
                                                                    </h3>
                                                                    <p class="text-sm message">
                                                                        {{ $teacherLastMessage ? Str::words($teacherLastMessage->message, 4, '...') : 'No messages yet' }}
                                                                        <i class="fas fa-circle  active-dot"
                                                                            style="color: #003e83ad !important; font-size: 8px; "></i>
                                                                    </p>

                                                                    <p class="d-flex justify-content-start align-items-center float-right"
                                                                        style="gap:4px; font-size: 12px; margin:0 ">
                                                                        <i class="far fa-clock "
                                                                            style="line-height: 1; font-size: 12px; color: #464a4c !important; {{ $teacherLastMessage ? 'display: block;' : 'display: none;' }}"></i>
                                                                        {{ $teacherLastMessage ? $teacherLastMessage->created_at->diffForHumans() : '' }}
                                                                    </p>


                                                                </div>

                                                            </div>

                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div class="media mb-0">

                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <div class="main-info" style="justify-content: center;">

                                                        {{-- <div class="msg-body" style="width: 100%;"> --}}
                                                        <p class="text-sm message"
                                                            style="margin: 8px 0; color: #292b2c;">You have no messages
                                                            yet</p>

                                                        {{-- </div> --}}


                                                    </div>

                                                </a>
                                            </div>
                                        @endif


                                    </div> <!-- /.lg -->
                                </div> <!-- /.list group -->
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->


                        <div class="d-inline dropdown">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <img src="{{ $src }}" style="margin-top: -6px;" id="student_img">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right rounded-0 profile" style="width: 220px;"
                                aria-labelledby="messages">
                                <img src="{{ $src }}" id="dropdown_img">

                                <p class=" text-center mb-2" id="dropdown_name" style="font-size: 17px;">
                                    {{ auth()->user()->name }}</p>

                                <div class="dropdown-divider mb-1"></div>
                                <div class="dropdown-links pl-3">

                                    <a href="{{ route('student.profile', Auth::user()->slug) }}"><i
                                            class="fas fa-user mr-2"></i>{{ __('admin.Profile') }}</a>
                                    <a href="{{ route('edit-password', 'student') }}"><i class="fas fa-key mr-2"></i>
                                        {{ __('admin.Edit Password') }}</a>
                                    <a href="{{ route('logout', 'student') }}"><i
                                            class="fas fa-sign-out-alt mr-2"></i> {{ __('admin.LogOut') }}</a>
                                    <ul class="p-0 text-center ">

                                </div>
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->



                    </div> <!-- /.right-links -->

                </div>


                @php
                    $company_id = Auth::user()->company_id;
                    $category_id = Auth::user()->category_id;
                    $company2 = Company::with('categories')
                        ->where('id', $company_id)
                        ->first();
                    $category_id = Auth::user()->category_id;
                    $category = Category::where('id', $category_id)->first();
                @endphp

                <div class="megamenu w-100">
                    <div class="collapse navbar-collapse" id="megamenu-dropdown">
                        <div class="megamenu-links">
                            <div class="row">
                                <div class="col-md-2 px-0">
                                    @if (Auth::user()->company_id)
                                        <a class="btn rounded-0 border-0 d-flex w-100 justify-content-between p-3 pl-5"
                                            href="{{ route('student.company', [$company2->slug, $category->name]) }}">
                                            {{ __('admin.Company') }}
                                        </a>
                                    @else
                                        <a class="btn rounded-0 border-0 d-flex w-100 justify-content-between p-3 pl-5"
                                            href="{{ route('student.allCompanies') }}">
                                            {{ __('admin.Avilable Companies') }}
                                        </a>
                                    @endif
                                </div> <!-- /.col-md-3 -->



                            </div> <!-- /.row -->

                        </div> <!-- /.megamenu-links -->

            </nav>
        </div>
    </div> <!-- END TOP NAVBAR -->

    {{-- <div id="body"> --}}

        <div class="chat-box">
            <div class="chat-box-header">
                <p id="user_name_msg"></p>
                <div class="icons-chat">
                    <span class="chat-box-toggle" style="line-height: 0"><i class="fas fa-times"></i></span>
                    <span class="chat-box-min" style="line-height: 0"><i class="fas fa-minus"></i></span>

                </div>
            </div>
            <div class="box">
                <div class="chat-box-body">
                    <div class="chat-box-overlay">
                    </div>
                    <div class="chat-logs">

                    </div>
                </div>
                <!--chat-log -->
            </div>
            <div class="chat-input">
                <form action="{{ route('student.send.message') }}" method="POST" id="messages_send_form">
                    @csrf
                    <input type="text" name="message" id="chat-input" placeholder="Send a message..."
                        autocomplete="off" />
                    <input type="hidden" name="slug" value="" id="slug_input">
                    <input type="hidden" name="type" value="" id="type_input">
                    <button type="submit" class="chat-submit" id="chat-submit"><i class="fas fa-send"></i></button>
                </form>
            </div>
        </div>
    </div>




    </div>


    @yield('content')
    <footer>

        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right'] }}</p>
            Distributed By {{ $data['distributed_by'] }}
        </div>
    </footer>


    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('adminAssets/dist/js/moment-with-locales.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('studentAssets/js/chat.js') }}"></script>
    <script>
        const userId = "{{ Auth::user()->id }}";
        const pusherKey = "{{ env('PUSHER_APP_KEY') }}";
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher(pusherKey, {
            cluster: 'ap2',
            authEndpoint: '/broadcasting/auth',
        });

        var channel = pusher.subscribe(`private-Messages.${userId}`);
        channel.bind('new-message', function(data) {
            appendMessage(data.message.message, data.message.id);
            // readAt(data.message.id);
        });
    </script>
    <script>
        let from = 'student';
        let studentId = {{ Auth::id() }};
        let time = "{{ __('admin.1 Seconds ago') }}";
        let lang = "{{ app()->getLocale() }}";
        let host = "{{ env('APP_URL') }}";
        let messagesURL = "{{ route('student.get.messages') }}";
    </script>
    <script src="{{ asset('adminAssets/dist/js/chat.js') }}"></script>

    @vite(['resources/js/app.js'])


    @yield('scripts')
</body>

</html>
