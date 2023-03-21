<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ config('app.name')}} | @yield('title') </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminAssets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminAssets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/dist/css/mystyle.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
    @yield('styles')
    @if(app()->getLocale()=='ar')
    <link rel="stylesheet" href="{{ asset('adminAssets/dist/css/myStyle-ar.css') }}">

    @endif
    <!-- Sweat Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <style>
    .alert-warning {
        color: #7d5a29;
        background-color: #fcefdc;
        border-color: #fbe8cd;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 2px;
    }
         #center-text {
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;

    }

    .btn#my-btn {
        background: white;
        padding-top: 13px;
        padding-bottom: 12px;
        border-radius: 45px;
        padding-right: 40px;
        padding-left: 40px;
        color: #5865C3;
    }

    #chat-overlay {
        background: rgba(255, 255, 255, 0.1);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: none;
    }



    .chat-box {
        display: none;
        background: #efefef;
        position: fixed;
        right: 30px;
        bottom: 0;
        width: 350px;
        max-width: 85vw;
        max-height: 100vh;
        border-radius: 5px;
        /* box-shadow: 0px 5px 35px 9px #ccc; */
        z-index: 2250;
    }

    .chat-box-toggle {
        float: right;
        cursor: pointer;
    }


    .chat-box-min,
    .chat-box-max {
        cursor: pointer;
    }

    .chat-box-header {
        background: #1a2e44;
        height: 40px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        color: #fff;
        font-size: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 10px;
    }

    .chat-box-header p {
        margin: 0 !important;
        font-size: 14px;
        font-weight: 900;
    }

    .chat-box-body {
        position: relative;
        height: 370px;
        border: 1px solid #ccc;
        overflow: hidden;
    }

    .chat-box-body:after {
        content: "";
        background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
        opacity: 0.1;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        height: 100%;
        position: absolute;
        z-index: -1;
    }

    .icons-chat {
        display: flex;
        flex-direction: row-reverse;
        gap: 10px;
    }

    #chat-input {
        background: #f4f7f9;
        width: 100%;
        position: relative;
        height: 47px;
        padding-top: 10px;
        padding-right: 50px;
        padding-bottom: 10px;
        padding-left: 15px;
        border: none;
        resize: none;
        outline: none;
        border: 1px solid #ccc;
        color: #888;
        border-top: none;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        overflow: hidden;
    }

    .chat-input>form {
        margin-bottom: 0;
    }

    #chat-input::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
        color: #ccc;
    }

    #chat-input::-moz-placeholder {
        /* Firefox 19+ */
        color: #ccc;
    }

    #chat-input:-ms-input-placeholder {
        /* IE 10+ */
        color: #ccc;
    }

    #chat-input:-moz-placeholder {
        /* Firefox 18- */
        color: #ccc;
    }

    .chat-submit {
        position: absolute;
        bottom: 3px;
        right: 10px;
        background: transparent;
        box-shadow: none;
        border: none;
        border-radius: 50%;
        color: #5A5EB9;
        width: 35px;
        height: 35px;
    }

    .chat-logs {
        padding: 15px;
        height: 370px;
        overflow-y: scroll;
    }

    .chat-logs .outgoing .details {
        text-align: right;
    }

    /* .chat-logs .outgoing .details {
text-align: left;
} */
    .chat-logs .incoming .details {
        text-align: left;
    }

    .chat-logs .outgoing .details p {
        word-wrap: break-word;
        background-color: #333;
        color: #fff;
        border-radius: 18px 18px 0 18px;
        margin-bottom: -3px;
        font-size: 15px;
    }

    .chat-logs .chat p {
        padding: 6px 11px;
        box-shadow: 0 0 32px rgb(0 0 0 / 8%), 0 16px 16px -16px rgb(0 0 0 / 10%);
    }

    .details {
        margin-bottom: 15px;
    }

    .details p {
        display: inline-block;
    }

    .incoming .details p {
        color: #333;
        background: #fff;
        border-radius: 18px 18px 18px 0;
        font-size: 15px;

    }

    .chat-logs::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .chat-logs::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .chat-logs::-webkit-scrollbar-thumb {
        background-color: #5A5EB9;
    }

    .messages-notify{
        display: none;
    }

    .chat-msg.user>.msg-avatar img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        float: left;
        width: 15%;
    }

    .chat-msg.self>.msg-avatar img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        float: right;
        width: 15%;
    }

    .cm-msg-text {
        background: white;
        padding: 10px 15px 10px 15px;
        color: #666;
        max-width: 75%;
        float: left;
        margin-left: 10px;
        position: relative;
        margin-bottom: 20px;
        border-radius: 30px;
    }

    .chat-msg {
        clear: both;
    }

    .chat-msg.self>.cm-msg-text {
        float: right;
        margin-right: 10px;
        background: #5A5EB9;
        color: white;
    }

    .cm-msg-button>ul>li {
        list-style: none;
        float: left;
        width: 50%;
    }

    .cm-msg-button {
        clear: both;
        margin-bottom: 70px;
    }

</style>

@if(app()->getLocale()=='ar')
<style>
body ,
html {
    font-family: event-reg;
}


@font-face {
    font-family: event-reg;
    src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
}



</style>
@endif
@yield('style')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link icon-nav" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center justify-content-center "  data-toggle="dropdown" href="#">
            @if( app()->getLocale() == 'ar')
            <img src="{{ asset('adminAssets/dist/img/lang/ar.png') }}" width="30" >
            @else
            <img src="{{ asset('adminAssets/dist/img/lang/en.png') }}" width="30" >

            @endif
        </a>
        <div class="dropdown-menu dropdown-menu dropdown-menu-right" style="min-width: unset !important; width: 115px !important; ">
                    {{-- <div class="media-body"> --}}
                        <ul class="p-0 text-center ">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li style="list-style-type: none" class="lang {{ app()->getLocale() == $localeCode ? 'active' : ' ' }}">
                                    <a rel="alternate" class="text-secondary" style="display: flex;
                                    align-items: center;
                                    justify-content: space-around;" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                        <img src="{{ asset('adminAssets/dist/img/lang/'.$properties['flag']) }}" width="25" alt="" class="ml-2">

                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    {{-- </div> --}}


        </div>
    </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge" id="messages-num"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right chat" id="messages-wrapper">
                        
                        

                    </div>
                </li>
                @php
                    use App\Models\Student;
                    $auth =Auth::user();
                @endphp

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link notify" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>

                        @if($auth->unreadNotifications->count() > 0)
                        <span class="badge badge-danger navbar-badge notify-number">{{ $auth->unreadNotifications->count()  }}</span>
                        @else
                        <span ></span>

                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " id="dropNotification">

                        @php
                        if ($auth->unreadNotifications->count()){
                            $myNotifications = $auth->notifications()->latest('read_at',null)->limit(5)->get();
                        }else{
                            $myNotifications = $auth->notifications()->limit(5)->get();

                        }

                    @endphp
                        @foreach ($myNotifications as $notify )
                        <a href="{{ route('admin.mark_read',$notify->id) }}"   class="dropdown-item {{ $notify->read_at ? '' : 'unread' }}">
                            <!-- Message Start -->
                            <div class="media">
                                     @php
                                     $student = Student::where('id',$notify->data['student_id'])->first();
                                     $student = $student->image;

                                    $name = $notify->data['name'] ?? '';
                                    $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                    if($student) {
                                        $img = $student;
                                        $src = asset($img);
                                    }

                                    @endphp
                                    <img src="{{ $src }}" alt="User Avatar" class="img-size-50 mr-3 img-circle image-avatar">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $notify->data['name'] }}
                                    </h3>
                                    <p class="text-sm">{{ $notify->data['msg']  }}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{$notify->created_at->diffForHumans()  }}</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <div class="all">
                        <a href="{{ route('admin.read_notify') }}" class="dropdown-item dropdown-footer text-center">{{ __('admin.Show All Notifications') }}</a>

                        </div>
                    </div>

                </li>

                <!-- Sidebar user panel (optional) -->
                <li class="nav-item dropdown">
                    @php
                        $name = Auth::guard()->user()->name ?? '';
                        $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;

                        if(Auth::guard()->user()->image) {
                          $img = Auth::guard()->user()->image;
                          $src = asset($img);
                        }
                        if (auth('admin')->check()) {
                            $type = 'admin';
                        }elseif (auth('teacher')->check()) {
                            $type = 'teacher';
                        }elseif (auth('company')->check()) {
                            $type = 'company';
                        }elseif (auth('trainer')->check()) {
                            $type = 'trainer';
                        }


                    @endphp
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img width="30" height="30" style="margin-top: -5px;object-fit: cover"
                            src="{{ $src }}" class="img-circle elevation-2" id="nav_img" alt="User Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown">
                        <div class="dropdown-img mt-4" id="dropdown_image" style="background-image: url('{{ $src }}')"></div>

                        <p class=" text-center my-2" id="dropdown_name" style="font-size: 17px;">{{ Auth::guard()->user()->name }}</p>
                        <div class="dropdown-divider mb-3"></div>
                        <a href="{{ route('admin.profile') }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-user mr-2 text-secondary"></i> {{ __('admin.Profile') }}
                        </a>
                        <a href="{{ route('edit-password' , $type) }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-key mr-2 text-secondary"></i> {{ __('admin.Edit Password') }}
                        </a>

                        <a href="{{ route('admin.settings') }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-cog mr-2 text-secondary"></i>{{ __('admin.Settings') }}
                        </a>

                        @if(auth('teacher')->check())
                            <form method="GET" action="{{ route('logout','teacher') }}"></form>
                                <a href="{{ route('logout','teacher') }}" class="dropdown-item text-secondary">
                                    <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> {{ __('admin.LogOut') }}
                                </a>
                                <input type="hidden" name="type" value="teacher" id="">

                            </form>
                        @elseif (auth('trainer')->check())
                        <form method="GET" action="{{ route('logout','trainer') }}"></form>
                            <a href="{{ route('logout','trainer') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> {{ __('admin.LogOut') }}
                            </a>
                            <input type="hidden" name="type" value="trainer" id="">

                        </form>
                        @elseif (auth('admin')->check())
                        <form method="GET" action="{{ route('logout','admin') }}"></form>
                            <a href="{{ route('logout','admin') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> {{ __('admin.LogOut') }}
                            </a>
                            <input type="hidden" name="type" value="admin" id="">
                        </form>
                        @elseif (auth('company')->check())
                        <form method="GET" action="{{ route('logout','company') }}"></form>
                            <a href="{{ route('logout','company') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> {{ __('admin.LogOut') }}
                            </a>
                            <input type="hidden" name="type" value="company" id="">

                        </form>
                        @endif



                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->


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

                      </div><!--chat-log -->
                </div>
                <!--chat-log -->
            </div>
            <div class="chat-input">
                <form action="{{ route('admin.send.message') }}" method="POST" id="messages_send_form">
                    @csrf
                    <input type="text" name="message" id="chat-input" placeholder="Send a message..."
                        autocomplete="off" />
                    <input type="hidden" name="slug" value="" id="slug_input">
                    <button type="submit" class="chat-submit" id="chat-submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>




      {{-- </div> --}}

        @php
        $data = json_decode(File::get(storage_path('app/settings.json')), true);
        @endphp


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.home') }}" class="brand-link text-center">
                <img id="logo" src="{{ asset($data['logo']) }}" style="opacity: .8 ; width: 100px;">

            </a>

            <!-- Sidebar -->
            <div class="sidebar">


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item @yield('home-menu-open') ">
                            <a href="{{ route('admin.home') }}" class="nav-link @yield('home-active')">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    {{ __('admin.Home') }}
                                </p>
                            </a>

                        </li>


                        <li class="nav-item @yield('admins-menu-open')">
                            <a href="#" class="nav-link @yield('admins-active')">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>
                                    {{ __('admin.Admins') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.admins.index') }}" class="nav-link @yield('index-admin-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Admins') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.admins.create') }}" class="nav-link @yield('add-admin-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Admin') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item @yield('universities-menu-open')">
                            <a href="#" class="nav-link @yield('universities-active')">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    {{ __('admin.Universities') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.universities.index') }}"
                                        class="nav-link @yield('index-university-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Universities') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.universities.create') }}"
                                        class="nav-link @yield('add-university-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add University') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('specializations-menu-open')">
                            <a href="#" class="nav-link @yield('specializations-active')">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>
                                    {{ __('admin.Specializations') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.specializations.index') }}"
                                        class="nav-link @yield('index-specialization-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Specializations') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.specializations.create') }}"
                                        class="nav-link @yield('add-specialization-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Specialization') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('teachers-menu-open')">
                            <a href="#" class="nav-link @yield('teachers-active')">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    {{ __('admin.Teachers') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.teachers.index') }}"
                                        class="nav-link @yield('index-teacher-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Teachers') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.teachers.create') }}"
                                        class="nav-link @yield('add-teacher-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Teacher') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('categories-menu-open')">
                            <a href="#" class="nav-link @yield('categories-active')">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    {{ __('admin.Programs') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="nav-link @yield('index-category-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Programs') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="nav-link @yield('add-category-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Program') }} </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item @yield('companies-menu-open')">
                            <a href="#" class="nav-link @yield('companies-active')">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    {{ __('admin.Companies') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.companies.index') }}"
                                        class="nav-link @yield('index-company-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Companies') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.companies.create') }}"
                                        class="nav-link @yield('add-company-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Company') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('trainers-menu-open')">
                            <a href="#" class="nav-link @yield('trainers-active')">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>
                                    {{ __('admin.Trainers') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.trainers.index') }}"
                                        class="nav-link @yield('index-trainer-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Trainers') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.trainers.create') }}"
                                        class="nav-link @yield('add-trainer-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Trainer') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @if (Auth::guard('trainer')->check())
                        <li class="nav-item @yield('tasks-menu-open')">
                            <a href="#" class="nav-link @yield('tasks-active')">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>
                                    {{ __('admin.Tasks') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.tasks.index') }}" class="nav-link @yield('index-task-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Tasks') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.tasks.create') }}" class="nav-link @yield('add-task-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Task') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif


                        <li class="nav-item @yield('evaluations-menu-open')">
                            <a href="#" class="nav-link @yield('evaluations-active')">
                                {{-- <i class="fas fa-file-chart-line"></i> --}}
                                <i class="fas fa-file-signature nav-icon"></i>
                                <p>
                                    {{ __('admin.Evaluations') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.index') }}"
                                        class="nav-link @yield('index-evaluations-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Evaluations') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.create') }}"
                                        class="nav-link @yield('add-evaluations-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Evaluation') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('subscribes-menu-open')">
                            <a href="#" class="nav-link @yield('subscribes-active')">
                                <i class="fas fa-file-signature nav-icon"></i>
                                <p>
                                    {{ __('admin.University IDs') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.subscribes.index') }}"
                                        class="nav-link @yield('index-subscribes-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All University IDs') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.subscribes.create') }}"
                                        class="nav-link @yield('add-subscribe-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add University ID') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('adverts-menu-open')">
                            <a href="#" class="nav-link @yield('adverts-active')">
                                <i class="fas fa-ad nav-icon"></i>
                                <p>
                                    {{ __('admin.Adverts') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.adverts.index') }}"
                                        class="nav-link @yield('index-adverts-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.All Adverts') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.adverts.create') }}"
                                        class="nav-link @yield('add-subscribe-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('admin.Add Advert') }}</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('students-menu-open')">
                            <a href="{{ route('admin.students.index') }}" class="nav-link @yield('students-active')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    {{ __('admin.Students') }}
                                </p>
                            </a>
                        </li>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="font-weight: 500; font-size: 38px"> @yield('sub-title')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    {{-- @dump(Auth::guard()) --}}
                    @yield('content')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        <footer class="main-footer">
            {{-- {{ now()->diffForHumans() }} --}}
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                {{ config('app.name') }}
            </div>
            <!-- Default to the left -->
            <strong>{{ __('admin.Copyright') }} &copy; {{ now()->year }} - {{ now()->year + 1 }}</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    {{-- Loader --}}
    <div class="loader">
        <div class="b b1"></div>
        <div class="b b2"></div>
        <div class="b b3"></div>
        <div class="b b4"></div>
        <div class="ftms">FTMS</div>
    </div>

    <!-- REQUIRED SCRIPTS -->

    @if (Auth::guard('company')->check())
        <script>
            const user = 'company';
        </script>
    @elseif (Auth::guard('trainer')->check())
        <script>
            const user = 'trainer';
        </script>
    @elseif (Auth::guard('teacher')->check())
        <script>
            const user = 'teacher';
        </script>
    @else
        <script>
            const user = 'admin';
        </script>
    @endif

    <script>
        const slug = "{{ Auth::user()->slug }}";
        const urlOnLoad = "{{ route('admin.students.messages') }}";
        const studentMessagesUrl = "{{ route('admin.messages') }}";
        const readAtUrl = "{{ route('admin.message.read.at') }}";
        const host = "{{ env('APP_URL') }}";
        const userId = "{{ Auth::user()->id }}";
        const pusherKey = "{{ env('PUSHER_APP_KEY') }}";
    </script>
    <!-- Pusher -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- jQuery -->
    <script src="{{ asset('adminAssets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminAssets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminAssets/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('adminAssets/dist/js/custom.js') }}"></script>
    <script src="{{ asset('adminAssets/dist/js/chat.js') }}"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@if(Auth::guard('company')->check())

<script>
    let from = 'admin';
    let companyId = {{ Auth::id() }};
    let time = "{{ __('admin.1 Seconds ago') }}";
    let lang = "{{ app()->getLocale() }}" ;
</script>
@vite(['resources/js/app.js'])
@endif

@if(Auth::guard('trainer')->check())
<script>
    let from = 'trainer';
    let trainerId = {{ Auth::id() }};
</script>

@vite(['resources/js/app.js'])
@endif


    <script>
        let text =  '{{ __('admin.It will be deleted') }}';
        let title =  '{{ __("admin.Are you sure?") }}';
        let confirmButtonText =  '{{ __('admin.Yes, delete it!') }}';
        let cancel =  '{{ __('admin.Cancel') }}';
        let deleteCompalete =  '{{ __('admin.Delete Completed') }}';
        let text2 =  '{{ __('admin.It will be Restored') }}';
        let restoreComplete =  '{{ __('admin.Restored Successfully') }}';
        let confirmButtonText2 =  '{{ __('admin.Yes, restore it!') }}';


    </script>
    <!-- Loader -->
    <script>
        window.onload = ()=> {
            document.querySelector(".loader").style.display = 'none';
        }
    </script>

@if (session('msg'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    @if (session('type') == 'success')
        Toast.fire({
            icon: 'success',
            title: '{{ session('msg') }}'
        })
    @elseif (session('type') == 'danger')
        Toast.fire({
            icon: 'error',
            title: '{{ session('msg') }}'
        })
    @else
        Toast.fire({
            icon: 'info',
            title: '{{ session('msg') }}'
        })
    @endif
</script>
@endif

@yield('scripts')
</body>

</html>
