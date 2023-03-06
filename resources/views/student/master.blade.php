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

    <style>
        #toast-container>.toast-success {
            background-image: unset !important;
        }

        #toast-container>div {
            padding: 15px !important;
            background: #fff !important;
            opacity: 1;
        }

        #toast-container>div {
            color: #000 !important;
            width: unset !important;
            min-width: 230px !important;
        }

        a {
            font-weight: unset !important;
        }

        .list-group-item.active {
            color: #000 !important;
            background: #ededed !important;
            border: 1px solid #e2e0e0
        }

        .message {
            color: #7f7f7f;
        }
        .list-group-item.active .message{
            font-weight: 350;
        }

        a.list-group-item.list-group-item-action.active .dropdown-item-title {
            color: #000
        }

        .dropdown-menu.dropdown-menu-right {
            padding-bottom: 0
        }

        .all-notify {
            text-align: center;
            background: #dedede;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 3px;
            z-index: 999;
            transition: all .2s ease-in-out;
        }

        .all-notify p {
            margin: 3px;
            font-size: 14px;
        }

        .all-notify p a {
            display: inline-block;
            width: 100%
        }

        .all-notify p a:hover {
            text-decoration: none
        }

        .all-notify:hover {
            background: #d3d3d3;

        }

        .media:last-child {
            /* background: #000; */
            margin-bottom: 35px;
        }

        .dropdown.show .dropdown-links a>i {

            line-height: 2 !important;
        }

        img.image-lang {
            width: 30px !important;
            height: auto !important;
            border-radius: unset !important;
            object-fit: unset !important
        }

        .img-lang-defult {
            width: 30px !important;
            height: auto !important;
            border-radius: unset !important;
            object-fit: unset !important
        }
        .mydrop-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 20%);
            padding: 12px 16px;
            z-index: 1;
            text-align: center;
            right: -10px;
            top: 30px;
        }

        .mydrop-content a {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;

        }

        .mydrop:hover .mydrop-content {
            /* display: block; */
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        .chat-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 13px;
        }
        

        .msg-body {
            padding-left: 15px;
        }

        .msg-body .message {
            margin: unset;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dropdown-menu {
            border-radius: 5px;
        }

        [data-component=navbar] .list-group .lg {
            border-radius: 5px;
        }

        .active-dot {
            display: none;
        }

        .list-group-item.active .active-dot {
            display: block;
        }
    </style>


    @if (app()->getLocale() == 'ar')
        <style>
            body,
            html {
                font-family: event-reg;
            }

            #toast-container>div {
                font-family: event-reg !important;
            }

            @font-face {
                font-family: event-reg;
                src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
            }

            body {
                direction: rtl
            }

            .btn,
            input {
                font-family: event-reg !important;

            }

            .navbar-toggler-left {
                left: unset;
                right: 1rem;
            }

            .float-right {
                float: left !important;
            }

            .mr-4 {
                margin-right: unset !important;
                margin-left: 1.5rem !important;
            }

            .mr-3 {
                margin-right: unset !important;
                margin-left: 1rem !important;
            }

            .px-1 {
                padding-right: 75PX !important;
                padding-left: 5px !important;
            }

            .pl-5 {
                padding-left: unset !important;
                padding-right: 3rem !important;
            }

            @media (min-width: 1200px) {
                .row {
                    margin-left: -15px;
                    margin-right: -15px;
                }
            }

            [data-component=navbar] .navbar-collapse {
                background-color: #292a2c;
                margin-left: unset;
                margin-right: 75px;
            }

            .dropdown-menu-right {
                left: 0;
                right: auto;
            }

            .dropdown.show .dropdown-links a>i {
                color: #6c757d !important;
                font-size: 1rem;
                transition: all 0.1s linear;
                margin-right: unset !important;
                margin-left: 0.5rem !important;

            }

            .page-todo .task.high {
                border-left: unset !important;
                border-right: 2px solid #f86c6b;
            }

            .page-todo .task .time {
                right: unset !important;
                left: 0;
                text-align: left !important;
                padding: unset !important;

                padding: 10px 0 10px 10px !important;
            }

            @media only screen and (max-width: 767px) {
                .page-todo .task .desc {

                    margin-right: unset !important;
                    margin-left: -20px !important;
                }
            }

            .text-start {
                text-align: right !important;
            }

            .text-end {
                text-align: left !important;
            }

            .notification-list .notification-list_content .notification-list_img img {

                margin-right: unset !important;
                margin-left: 20px;
            }

            .heading-line:after {

                left: unset !important;
                right: 0;
            }

            .modal-header .close,
            .modal-header .mailbox-attachment-close {
                margin: -1rem -1rem -1rem !important;
            }

            .mr-1,
            .mx-1 {
                margin-right: unset !important;
                margin-left: 0.25rem !important;
            }

            .notification-list--unread {
                border-left: unset !important;
                border-right: 2px solid #29B6F6;
            }


            table th {
                text-align: start !important;

            }

            .form-control.is-invalid,
            .was-validated .form-control:invalid {
                padding-right: 0.75rem !important;
                padding-left: 2.25rem !important;
                background-position: left calc(0.375em + 0.1875rem) center;
            }

            [data-component=navbar] .dropdown span {
                right: 9px;
                top: -7px;
            }

            .chat-body {
                padding: unset;
                padding-right: 13px;
            }

            .list-group-item .main-info {
                /* flex-direction: row-reverse; */
            }
        </style>
    @endif

@endif


<style>

.mydrop {
position: relative;
display: inline-block;
/* top: 0;
left: 0; */

}


.mydrop-content {
display: none;
position: absolute;
    background-color: #f9f9f9;
    min-width: 220px;
    box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 20%);
    padding: 12px 16px;
    z-index: 1;
    text-align: center;
    right: -10px;
    top: 30px;
}

.mydrop-content a{
display: flex;
justify-content: center;
align-items: center;
gap: 5px;

}

.mydrop:hover .mydrop-content {
/* display: block; */
display: flex;
flex-direction: column;
gap:10px
}

</style>
    @yield('styles')


    <title> {{ config('app.name') }} | @yield('title') </title>

</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    {{-- oncontextmenu="return false;" --}}

    @php
        use App\Models\Company;
        use App\Models\Category;
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

                                $teacherLastMessage = $auth->messages()
                                ->where('teacher_id', $teacher->id)
                                ->latest('id')
                                ->first();

                                $trainerLastMessage = $auth->messages()
                                ->where('trainer_id', $trainer->id)
                                ->latest('id')
                                ->first();

                                $activeTrainerMessage = $auth->messages()
                                ->where('trainer_id', $trainer->id)
                                ->where('sender_id', $trainer->id)
                                ->latest('id')
                                ->first();

                                $activeTeacherMessage = $auth->messages()
                                ->where('teacher_id', $teacher->id)
                                ->where('sender_id', $teacher->id)
                                ->latest('id')
                                ->first();
                                
                            @endphp
                        @endif
                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#"><i class="far fa-envelope"></i>
                                @if ($activeTrainerMessage->read_at == null)
                                    <span class="notify-number">1</span>
                                {{-- @elseif ($trainerLastMessage->read_at == null && $teacherLastMessage->read_at == null) --}}
                                    {{-- <span class="notify-number">2</span> --}}
                                @endif</a>
                            <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="messages">
                                <!-- <a class="dropdown-item">There are no new messages</a> -->
                                <div class="list-group">
                                    <div class="lg">

                                        @if ($trainerLastMessage || $teacherLastMessage)
                                            @if ($trainerLastMessage)
                                                <div class="media">

                                                    <a href="{{ route('student.chats', $trainer->slug) }}" class="list-group-item list-group-item-action @if($activeTrainerMessage)
                                                        @if ($activeTrainerMessage->read_at == null)
                                                             {{ 'active' }}
                                                        @endif
                                                    @endif ">
                                                        <div class="main-info">
                                                            <div class="msg-img">
                                                                <img src="{{ asset('http://127.0.0.1:8000/'.$trainer->image) }}">
                                                            </div>
                                                            <div class="msg-body" style="width: 100%;">
                                                                <h3 class="dropdown-item-title">{{ $trainer->name }}</h3>
                                                                <p class="text-sm message">{{ $trainerLastMessage ? Str::words($trainerLastMessage->message, 4, '...') : 'No messages yet' }}
                                                                    
                                                                        <i class="fas fa-circle active-dot" style="color: #003e83ad !important; font-size: 8px; "></i>
                                                                    
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
                                                    <a href="{{ route('student.chats', $teacher->slug) }}" class="list-group-item list-group-item-action @if ($activeTeacherMessage)
                                                        {{ $activeTeacherMessage->read_at == null ? 'active' : '' }}
                                                    @endif">
                                                        <div class="main-info">
                                                            <div class="msg-img">
                                                                <img src="{{ asset('http://127.0.0.1:8000/'.$teacher->image) }}">
                                                                
                                                            </div>
                                                            <div class="msg-body" style="width: 100%;">
                                                                <h3 class="dropdown-item-title">{{ $teacher->name }}</h3>
                                                                <p class="text-sm message">{{ $teacherLastMessage ? Str::words($teacherLastMessage->message, 4, '...') : 'No messages yet' }}
                                                                    <i class="fas fa-circle  active-dot" style="color: #003e83ad !important; font-size: 8px; "></i>
                                                                </p>
                                                                
                                                                <p class="d-flex justify-content-start align-items-center float-right"
                                                                style="gap:4px; font-size: 12px; margin:0 ">
                                                                    <i class="far fa-clock " style="line-height: 1; font-size: 12px; color: #464a4c !important; {{ $teacherLastMessage ? 'display: block;' : 'display: none;' }}"></i>
                                                                    {{ $teacherLastMessage ? $teacherLastMessage->created_at->diffForHumans() : '' }}
                                                                </p>
                                                                

                                                            </div>
                                                            
                                                        </div>

                                                    </a>
                                                </div>
                                            @endif                                            
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




    @yield('content')
    <footer>

        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right'] }}</p>
            Distributed By {{ $data['distributed_by'] }}
        </div>
    </footer>


    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('adminAssets/dist/js/moment-with-locales.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let from = 'student';
        let studentId = {{ Auth::id() }};
        let time = "{{ __('admin.1 Seconds ago') }}";
        let lang = "{{ app()->getLocale() }}";
        let host = "{{ env('APP_URL') }}";
    </script>
    @vite(['resources/js/app.js'])


    @yield('scripts')
</body>

</html>
