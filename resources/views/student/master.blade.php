
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('studentAssets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studentAssets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('studentAssets/css/owl.theme.default.min.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="{{ asset('studentAssets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    @yield('styles')


    <title> {{ config('app.name')}} | @yield('title') </title>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">

@php
    $data = json_decode(File::get(storage_path('app/settings.json')), true);
@endphp


    <!-- BOTTOM NAV -->
    <nav class="navbar navbar-expand-lg navbar-light  sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.home') }}">
                <img src="{{ asset($data['logo']) }}" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reviews">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#blog">Blog</a>
                    </li>
                    @php
                    $name = Auth::guard()->user()->name ?? '';
                    $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;

                    if(Auth::guard()->user()->image) {
                    $img = Auth::guard()->user()->image;
                    $src = asset($img);
                    }

                    @endphp

                    <li style="display: flex; justify-content: center; align-items: center;">
                        <div class='header-right'>
                        <div class='avatar-wrapper' id='avatarWrapper'>
                          <div class="img-student-logo" style="background-image: url('{{  $src }}')"></div>


                          <svg class='avatar-dropdown-arrow' height='24' id='dropdownWrapperArrow' viewbox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'>
                            <title>Dropdown Arrow</title>
                            <path d='M12 14.5c-.2 0-.3-.1-.5-.2l-3.8-3.6c-.2-.2-.2-.4-.2-.5 0-.1 0-.3.2-.5.3-.3.7-.3 1 0l3.3 3.1 3.3-3.1c.2-.2.5-.2.8-.1.3.1.4.4.4.6 0 .2-.1.4-.2.5l-3.8 3.6c-.1.1-.3.2-.5.2z'></path>
                          </svg>
                        </div>
                        <div class='dropdown-wrapper' id='dropdownWrapper' style='width: 256px'>
                          <div class='dropdown-profile-details'>


                            <div class="img-student" style="background-image: url('{{ $src }}')"></div>



                            <span class='dropdown-profile-details--name mt-2'>{{ auth()->user()->name }}</span>


                            <span class='dropdown-profile-details--email'>{{ Auth::user()->email  }}</span>

                          </div>
                          <div class='dropdown-links'>
                            <a href="{{ route('student.profile' ,Auth::user()->slug ) }}">Profile</a>
                            <a href="{{ route('edit-password' , 'student') }}"> Edit password</a>
                            <a href="{{ route('logout' , 'student') }}"> Logout</a>
                          </div>
                        </div>
                      </div>
                      </li>

                </ul>

            </div>
        </div>
    </nav>


    @yield('content')
    <footer>
        <div class="footer-top text-center footer">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img class="mb-4" src="{{ asset($data['logo']) }}" >
                        <p>{{ $data['footer_text'] }}</p>

                        <div class="col-auto conditions-section">
                            <a href="#">privacy</a>
                            <a href="#">terms</a>
                            <a href="mailto:{{ $data['email'] }}">Technical support</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right'] }}</p>
            Distributed By {{ $data['distributed_by'] }}
        </div>
    </footer>


    <script src="{{ asset('studentAssets/js/milestone.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('studentAssets/js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
