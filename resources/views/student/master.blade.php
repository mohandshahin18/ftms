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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <!-- Sweat Alert -->
   <link rel="stylesheet"
   href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">

    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('studentAssets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <style>
        a{
            font-weight: unset !important;
        }
        .list-group-item.active{
            color: #000 !important;
            background: #ededed  !important;
            border: 1px solid #e2e0e0
        }
        a.list-group-item.list-group-item-action.active .dropdown-item-title{
            color: #000
        }
        .dropdown-menu.dropdown-menu-right{
            padding-bottom: 0
        }
        .all-notify{
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
        .all-notify p{
            margin: 3px ;
            font-size: 14px;
        }
        .all-notify p a{
           display: inline-block;
           width: 100%
        }
        .all-notify p a:hover{
           text-decoration: none
        }

        .all-notify:hover{
            background: #d3d3d3;

        }
         .media:last-child{
            /* background: #000; */
            margin-bottom: 35px;
        }
    </style>

    @yield('styles')


    <title> {{ config('app.name') }} | @yield('title') </title>

</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">

    @php
    use App\Models\Company;
    use App\Models\Trainer;
    $auth =Auth::user();

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


                    <div class="right-links float-right mr-4 d-flex justify-content-center align-items-center" style="gap:10px ">
                        {{-- <a href="{{ route('student.home') }}" class="home"><i class="fa fa-home mr-3"></i></a> --}}



                        <div class="d-inline dropdown ml-3 mr-3">

                                @if($auth->unreadNotifications->count() > 0)
                                <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <span class="badge badge-danger navbar-badge"></span>

                                <span>{{ $auth->unreadNotifications->count()  }}</span><i class="fa fa-bell"></i>
                                    </a>
                                @else

                                <a class="dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="fa fa-bell"></i>

                                    </a>
                                @endif

                            <div class="dropdown-menu dropdown-menu-right rounded-0 pt-0 notify-msg-drop"
                                aria-labelledby="notifications">
                                <div class="list-group">
                                    <div class="lg">

                                        @foreach ($auth->notifications as $notify)
                                        @php
                                        if ($notify->data['from'] == 'apply') {
                                            $company = Company::where('id',$notify->data['company_id'])->first();
                                            $company = $company->image;

                                            $name = $notify->data['name'] ?? '';
                                            $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                            if($company) {
                                                $img = $company;
                                                $notifySrc = asset($img);
                                            }
                                            }elseif ($notify->data['from'] == 'task') {
                                                $trainer = Trainer::where('id',$notify->data['trainer_id'])->first();
                                                $trainer = $trainer->image;

                                                $name = $notify->data['name'] ?? '';
                                                $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                                if($trainer) {
                                                    $img = $trainer;
                                                    $notifySrc = asset($img);
                                                }
                                            }
                                        @endphp

                                        <div class="media">
                                            <a href="{{ route('student.mark_read' ,$notify->id) }}" class="list-group-item list-group-item-action {{ $notify->read_at ? '' : 'active' }}" style="font-weight: unset">

                                                <img src="{{ $notifySrc }}">

                                                <div class="media-body">
                                                    <h3 class="dropdown-item-title">{{ $notify->data['name'] }}</h3>
                                                    <p class="text-sm">{{ $notify->data['msg'] }}</p>

                                                    <p class="d-flex justify-content-start align-items-center" style="gap:4px ">
                                                        <i class="far fa-clock " style="line-height: 1; font-size: 12px; color: #464a4c !important"></i>
                                                        {{ $notify->created_at->diffForHumans() }}
                                                    </p>
                                                </div>

                                            </a>
                                        </div>
                                        @endforeach




                                    </div> <!-- /.lg -->
                                    <div class="all-notify">
                                        <p><a href="{{ route('student.read_notify') }}">Show All Notifications</a></p>
                                    </div>
                                </div> <!-- /.list group -->
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->

                        <div class="d-inline dropdown mr-3">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#"><i class="fa fa-envelope"></i></a>
                            <div class="dropdown-menu dropdown-menu-right rounded-0 pt-0 notify-msg-drop" aria-labelledby="messages">
                                <!-- <a class="dropdown-item">There are no new messages</a> -->
                                <div class="list-group">
                                    <div class="lg">

                                        <div class="media">

                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <img
                                                    src="http://1.gravatar.com/avatar/47db31bd2e0b161008607d84c74305b5?s=96&d=mm&r=g">

                                                <div class="media-body">
                                                    <h3 class="dropdown-item-title">Shift Company</h3>
                                                    <p class="text-sm">Call me whenever you can...</p>
                                                    <p>
                                                        4 hours ago
                                                    </p>
                                                </div>

                                            </a>
                                        </div>

                                    </div> <!-- /.lg -->
                                </div> <!-- /.list group -->
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->




                        <div class="d-inline dropdown">
                            <a class="dropdown-toggle" id="messages" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <img src="{{ $src }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right rounded-0 profile" style="width: 240px;"
                                aria-labelledby="messages">
                                <img src="{{ $src }}">
                                <p class=" text-center my-2" style="font-size: 17px;">{{ auth()->user()->name }}</p>

                                <div class="dropdown-divider mb-1"></div>
                                <div class="dropdown-links">
                                    <a href="{{ route('student.profile', Auth::user()->slug) }}">Profile</a>
                                    <a href="{{ route('edit-password', 'student') }}"> Edit password</a>
                                    <a href="{{ route('logout', 'student') }}"> Logout</a>
                                </div>
                            </div> <!-- /.dropdown-menu -->
                        </div> <!-- /.dropdown -->

                    </div> <!-- /.right-links -->

                </div>


                @php
                    $company_id = Auth::user()->company_id;
                    $company = Company::with('categories')
                        ->where('id', $company_id)
                        ->first();
                    if ($company_id) {
                        foreach ($company->categories as $category) {
                            $category = $category->name;
                        }
                    }
                @endphp

                <div class="megamenu w-100">
                    <div class="collapse navbar-collapse" id="megamenu-dropdown">
                        <div class="megamenu-links">
                            <div class="row">
                                <div class="col-md-2 px-0">
                                    @if (Auth::user()->company_id)
                                        <a class="btn rounded-0 border-0 d-flex w-100 justify-content-between p-3 pl-5"
                                            href="{{ route('student.company', [$company->slug, $category]) }}">
                                            Company
                                        </a>
                                    @else
                                        <a class="btn rounded-0 border-0 d-flex w-100 justify-content-between p-3 pl-5"
                                            href="{{ route('student.allCompany') }}">
                                            Companies
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
        <div class="footer-top text-center footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img class="mb-4" src="{{ asset($data['logo']) }}">
                        <p>{{ $data['footer_text'] }}</p>

                        {{-- <div class="col-auto conditions-section">
                            <a href="#">privacy</a>
                            <a href="#">terms</a>
                            <a href="mailto:{{ $data['email'] }}">Technical support</i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right'] }}</p>
            Distributed By {{ $data['distributed_by'] }}
        </div>
    </footer>


    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/bootstrap.min.js') }}"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>

    @yield('scripts')
</body>

</html>
