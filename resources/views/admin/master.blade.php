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

    <!-- Sweat Alert -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" />



    @yield('styles')
    <style>
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
        .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #5d78ff;
            color: #fff;
        }

        [class*=sidebar-dark-],
        .card-primary:not(.card-outline)>.card-header {
            background-color: #1e272f;
        }

        /* .form-control {
            background: #f8f8f8;
            border: 1px solid #f8f8f8;

            border: 0;
            outline: 0;
        }
        .form-control:focus{
           border: 1px solid #ced4da;
        } */

    </style>



</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('adminAssets/dist/img/user1-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        اسماعيل النباهين

                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> منذ 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('adminAssets/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> منذ 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="{{ asset('adminAssets/dist/img/user3-128x128.jpg') }}" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> منذ 4 ساعات</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">عرض كل الرسائل</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">عرض كل الإشعارات</a>
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
                        <img width="30" height="30" style="margin-top: -5px;object-fit: contain"
                            src="{{ $src }}" class="img-circle elevation-2" alt="User Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dropdown">
                        <div class="dropdown-img mt-4" style="background-image: url('{{ $src }}')"></div>

                        <p class=" text-center my-2" style="font-size: 17px;">{{ Auth::guard()->user()->name }}</p>
                        <div class="dropdown-divider mb-3"></div>
                        <a href="{{ route('admin.profile') }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-user mr-2 text-secondary"></i> Profile
                        </a>
                        <a href="{{ route('edit-password' , $type) }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-key mr-2 text-secondary"></i> Edit Password
                        </a>

                        <a href="{{ route('admin.settings') }}" class="dropdown-item text-secondary mb-2">
                            <i class="fas fa-cog mr-2 text-secondary"></i>Stettings
                        </a>

                        @if(auth('teacher')->check())
                            <form method="GET" action="{{ route('logout','teacher') }}"></form>
                                <a href="{{ route('logout','teacher') }}" class="dropdown-item text-secondary">
                                    <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> LogOut
                                </a>
                                <input type="hidden" name="type" value="teacher" id="">

                            </form>
                        @elseif (auth('trainer')->check())
                        <form method="GET" action="{{ route('logout','trainer') }}"></form>
                            <a href="{{ route('logout','trainer') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> LogOut
                            </a>
                            <input type="hidden" name="type" value="trainer" id="">

                        </form>
                        @elseif (auth('admin')->check())
                        <form method="GET" action="{{ route('logout','admin') }}"></form>
                            <a href="{{ route('logout','admin') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> LogOut
                            </a>
                            <input type="hidden" name="type" value="admin" id="">
                        </form>
                        @elseif (auth('company')->check())
                        <form method="GET" action="{{ route('logout','company') }}"></form>
                            <a href="{{ route('logout','company') }}" class="dropdown-item text-secondary">
                                <i class="fas fa-sign-out-alt mr-2 text-secondary"></i> LogOut
                            </a>
                            <input type="hidden" name="type" value="company" id="">

                        </form>
                        @endif



                    </div>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->
        @php
        $data = json_decode(File::get(storage_path('app/settings.json')), true);
        @endphp


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link ">
                <img src="{{ asset($data['logo']) }}" style="opacity: .8 ; width: 100px;">

            </a>

            <!-- Sidebar -->
            <div class="sidebar">


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item @yield('home-menu-open') ">
                            <a href="{{ route('admin.home') }}" class="nav-link @yield('home-active')">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Home
                                </p>
                            </a>

                        </li>




                        <li class="nav-item @yield('companies-menu-open')">
                            <a href="#" class="nav-link @yield('companies-active')">
                                <i class="nav-icon fas fa-laptop-house"></i>
                                <p>
                                    Companies
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.companies.index') }}"
                                        class="nav-link @yield('index-company-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Companies</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.companies.create') }}"
                                        class="nav-link @yield('add-company-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Company</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('categories-menu-open')">
                            <a href="#" class="nav-link @yield('categories-active')">
                                <i class="nav-icon fas fa-star"></i>
                                <p>
                                    Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.index') }}"
                                        class="nav-link @yield('index-category-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="nav-link @yield('add-category-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Category</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('universities-menu-open')">
                            <a href="#" class="nav-link @yield('universities-active')">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Universities
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.universities.index') }}"
                                        class="nav-link @yield('index-university-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Universities</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.universities.create') }}"
                                        class="nav-link @yield('add-university-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add University</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item @yield('teachers-menu-open')">
                            <a href="#" class="nav-link @yield('teachers-active')">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    Teachers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.teachers.index') }}"
                                        class="nav-link @yield('index-teacher-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Teachers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.teachers.create') }}"
                                        class="nav-link @yield('add-teacher-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Teacher</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('specializations-menu-open')">
                            <a href="#" class="nav-link @yield('specializations-active')">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>
                                    Specializations
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.specializations.index') }}"
                                        class="nav-link @yield('index-specialization-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Specializations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.specializations.create') }}"
                                        class="nav-link @yield('add-specialization-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Specialization</p>
                                    </a>
                                </li>
                            </ul>
                        </li>



                        <li class="nav-item @yield('trainers-menu-open')">
                            <a href="#" class="nav-link @yield('trainers-active')">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>
                                    Trainers
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.trainers.index') }}"
                                        class="nav-link @yield('index-trainer-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Trainers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.trainers.create') }}"
                                        class="nav-link @yield('add-trainer-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Trainer</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item @yield('admins-menu-open')">
                            <a href="#" class="nav-link @yield('admins-active')">
                                <i class="fas fa-user-shield nav-icon"></i>
                                <p>
                                    Admins
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.admins.index') }}" class="nav-link @yield('index-admin-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Admins</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.admins.create') }}" class="nav-link @yield('add-admin-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Admin</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item @yield('evaluations-menu-open')">
                            <a href="#" class="nav-link @yield('evaluations-active')">
                                {{-- <i class="fas fa-file-chart-line"></i> --}}
                                <i class="fas fa-file-signature nav-icon"></i>
                                <p>
                                    Evaluations
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.index') }}"
                                        class="nav-link @yield('index-evaluations-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All evaluations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.evaluations.create') }}"
                                        class="nav-link @yield('add-evaluations-active')">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add Evaluation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>




                        <li class="nav-item @yield('students-menu-open')">
                            <a href="{{ route('admin.students.index') }}" class="nav-link @yield('students-active')">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Students
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
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                {{ config('app.name') }}
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ now()->year }} - {{ now()->year + 1 }}</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('adminAssets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminAssets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminAssets/dist/js/adminlte.min.js') }}"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>


    @yield('scripts')
</body>

</html>
