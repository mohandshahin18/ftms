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

            .task_img {

                margin-right: unset !important;
                margin-left: 8px !important;
}
        </style>
    @endif

    <style>
        .msg-body h3 ,
        /* .msg-body p , */
        .chat-box-body .details p ,
        .chat-box-header p{
            font-family: Arial, Helvetica, sans-serif
        }

    .msg-body p {
    font-size: 13px !important;
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
        use App\Models\Trainer;
        $auth = Auth::user();

        $data = json_decode(File::get(storage_path('app/settings.json')), true);
    @endphp


    <div data-component="navbar">


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
                        <img src="{{ asset($data['darkLogo']) }}" class="d-inline-block mt-1" alt="AgentFire Logo">
                    </a>


                    <div class="right-links float-right mr-4">
                        {{-- <a href="{{ route('student.home') }}" class="home"><i class="fa fa-home mr-3"></i></a> --}}

                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                {{-- <i class="fas fa-globe-europe"> --}}
                                <span class="badge badge-danger navbar-badge"></span><i class="far fa-globe-europe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right rounded-0  pt-0"
                                style="min-width: unset !important; width: 110px;" aria-labelledby="messages">

                                <div class="dropdown-links text-center">

                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a rel="alternate" class="text-secondary" hreflang="{{ $localeCode }}"
                                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                             >
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
                                        @php
                                            if ($auth->unreadNotifications->count()){
                                                $myNotifications = $auth->notifications()->latest('read_at',null)->limit(5)->get();
                                            }else{
                                                $myNotifications = $auth->notifications()->limit(5)->get();

                                            }

                                        @endphp
                                        @forelse ($myNotifications as $notify)
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

                                                    <div class="d-flex" style="gap: 10px">
                                                        <div>
                                                            <img src="{{ $notifySrc }}">

                                                        </div>
                                                    <div>
                                                        <div class="main-info">
                                                            <div class="d-flex align-items-center"
                                                                style="gap:8px !important;">
                                                                <h3 class="dropdown-item-title" style="font-family: Arial, Helvetica, sans-serif">{{ $notify->data['name'] }}
                                                                </h3>
                                                            </div>

                                                        </div>
                                                        <div class="media-body mt-1">

                                                            <p class="text-sm">{{ $notify->data['msg'] }}</p>


                                                        </div>

                                                        <div>
                                                            <p class="d-flex justify-content-start align-items-center "
                                                                style="gap:4px; font-size: 12px; margin:0 ">
                                                                <i class="far fa-clock "
                                                                    style="line-height: 1; font-size: 12px; color: #464a4c !important"></i>
                                                                {{ $notify->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <p class=" mt-3 mb-5 text-center " id="no_notification">There are no
                                                Notifications yet</p>
                                        @endforelse




                                    </div> <!-- /.lg -->
                                    <div class="all-notify">
                                        <p><a href="{{ route('student.read_notify') }}" >{{ __('admin.Show All Notifications') }}</a></p>
                                    </div>
                                </div> <!-- /.list group -->
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->

                        {{-- Chats --}}
                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#"><i class="far fa-envelope"></i>
                                <span class="messages-notify"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="messages">
                                <!-- <a class="dropdown-item">There are no new messages</a> -->
                                <div class="list-group">
                                    <div class="lg" id="messages-wrapper">


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
            {{ __('admin.Distributed By') }} : {{ $data['distributed_by'] }}
        </div>
    </footer>


    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('adminAssets/dist/js/moment-with-locales.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const userId = "{{ Auth::user()->id }}";
        const pusherKey = "{{ env('PUSHER_APP_KEY') }}";
        const readAtUrl = "{{ route('student.read.message') }}";
    </script>
    <script src="{{ asset('studentAssets/js/chat.js') }}"></script>
    <script>

  
        var pusher = new Pusher(pusherKey, {
            cluster: 'ap2',
            authEndpoint: '/broadcasting/auth',
        });

        var channel = pusher.subscribe(`private-Messages.${userId}`);
        channel.bind('new-message', function(data) {
            if(userId == data.message.receiver_id) {
                appendMessage(data.message.message, data.message.id);
                getAllChats();
            }
        });
    </script>
    <script>
        let from = 'student';
        let studentId = {{ Auth::id() }};
        let time = "{{ __('admin.1 Seconds ago') }}";
        let lang = "{{ app()->getLocale() }}";
        let host = "{{ env('APP_URL') }}";
        let messagesURL = "{{ route('student.get.messages') }}";
        let allChatsUrl = "{{ route('student.all.chats') }}";
    </script>

    @vite(['resources/js/app.js'])


    @yield('scripts')
</body>

</html>
