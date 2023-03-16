<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('websiteAssets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAssets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAssets/css/owl.theme.default.min.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('websiteAssets/css/style.css') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <title>{{ env('APP_NAME') }}</title>

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

            .ms-auto {
                margin-left: unset !important;
                margin-right: auto!important;
            }
            @font-face {
                font-family: event-reg;
                src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
            }

            @media (min-width: 992px){
                .ms-lg-3 {
                margin-left: unset!important;
                margin-right: 1rem!important;
            }
            }

            .navbar-brand {

                margin-right: unset !important;
                margin-left: 1rem !important;

            }

            .ms-4 {
                margin-left: unset!important;
                margin-right: 1.5rem!important;
            }
        </style>
    @endif
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
    @php
        $data = json_decode(File::get(storage_path('app/settings.json')), true);

    @endphp



    <!-- BOTTOM NAV -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('website.home') }}">
                <img src="{{ asset($data['logo']) }}" class="nav-brand" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">{{ __('admin.Home') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#services">{{ __('admin.Our Services') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#team">{{ __('admin.Our Team') }}</a>
                    </li>
                                        <li class="nav-item">
                        <a class="nav-link" href="#reviews">{{ __('admin.Ratings') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">{{ __('admin.Contact Us') }}</a>
                    </li>
                    <li class="nav-item dropdown d-flex">
                        @if( app()->getLocale() == 'ar')
                        <button class=" dropdown-toggle" type="button" style="border: unset; background: unset" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('adminAssets/dist/img/lang/ar.png') }}" style="width: 25px !important" width="30" >
                        </button>
                        @else
                        <button class="dropdown-toggle" type="button" style="border: unset; background: unset" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('adminAssets/dist/img/lang/en.png') }}"style="width: 25px !important"  width="30" >
                        </button>

                        @endif


                        <ul class="dropdown-menu">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                            <li class="{{ app()->getLocale() == $localeCode ? 'active' : ' ' }}">
                                <a class="dropdown-item "hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                    <img src="{{ asset('adminAssets/dist/img/lang/'.$properties['flag']) }}" style="width: 25px !important" width="25" alt="" class="ml-2">
                                </a>
                            </li>


                            @endforeach


                          </ul>                    </li>
                </ul>
                <a href="{{ route('student.login.show') }}"
                    class="btn btn-brand ms-lg-3">{{ __('admin.Login') }}</a>
            </div>
        </div>
    </nav>
    <!-- SLIDER -->
    <div id="home" >

        <div class="slide slide2">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-10 offset-lg-1 text-white">
                        <h6 class="text-white text-uppercase">We craft digital experiances</h6>
                        <h1 class="display-3 my-4">Design Driven For <br />Professionals</h1>
                        <a href="{{ route('student.login.show') }}" class="btn btn-brand">{{ __('admin.Login') }}</a>
                        <a href="{{ route('student.subsicribeId') }}" class="btn btn-outline-light ms-3">{{ __('admin.Register') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MILESTONE -->
    <section id="milestone">
        <div class="container">
            <div class="row text-center justify-content-center gy-4">
                <div class="col-lg-2 col-sm-6">
                    <div class="counter">
                        <h1 class="display-4" data-goal="{{ $student->count() }}">0 </h1>
                    </div>
                    <p class="mb-0">{{ __('admin.Students Number') }}</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="counter">
                        <h1 class="display-4" data-goal="{{ $company->count() }}">0</h1>
                    </div>
                    <p class="mb-0">{{ __('admin.Companies Number') }}</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h1 class="display-4" data-goal="{{ $trainer->count() }}">0</h1>
                    <p class="mb-0">{{ __('admin.Trainers Number') }}</p>
                </div>

            </div>
        </div>
    </section>



    <section id="services" class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro">
                        <h6>{{ __('admin.Our Services') }}</h6>
                        <h1>What We Do?</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon1.png') }}" alt="">
                        <h5>Digital Marketing</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon2.png') }}" alt="">
                        <h5>Logo Designing</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon3.png') }}" alt="">
                        <h5>Buisness consulting</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon4.png') }}" alt="">
                        <h5>Videography</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon5.png') }}" alt="">
                        <h5>Brand Identity</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon6.png') }}" alt="">
                        <h5>Ethical Hacking</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="team">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro">
                        <h6>{{ __('admin.Team') }}</h6>
                        <h1>{{ __('admin.Team Members') }}</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8">
                    <div class="team-member">
                        <div class="image">
                            <img src="{{ asset('websiteAssets/img/team_1.jpg') }}" alt="">
                            <div class="social-icons">
                                <a href="#"><i class='bx bxl-facebook'></i></a>
                                <a href="#"><i class='bx bxl-twitter'></i></a>
                                <a href="#"><i class='bx bxl-instagram'></i></a>
                                <a href="#"><i class='bx bxl-pinterest'></i></a>
                            </div>
                            <div class="overlay"></div>
                        </div>

                        <h5>Marvin McKinney</h5>
                        <p>Marketing Coordinator</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="team-member">
                        <div class="image">
                            <img src="{{ asset('websiteAssets/img/team_2.jpg') }}" alt="">
                            <div class="social-icons">
                                <a href="#"><i class='bx bxl-facebook'></i></a>
                                <a href="#"><i class='bx bxl-twitter'></i></a>
                                <a href="#"><i class='bx bxl-instagram'></i></a>
                                <a href="#"><i class='bx bxl-pinterest'></i></a>
                            </div>
                            <div class="overlay"></div>
                        </div>

                        <h5>Kathryn Murphy</h5>
                        <p>Ethical Hacker</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="team-member">
                        <div class="image">
                            <img src="{{ asset('websiteAssets/img/team_3.jpg') }}" alt="">
                            <div class="social-icons">
                                <a href="#"><i class='bx bxl-facebook'></i></a>
                                <a href="#"><i class='bx bxl-twitter'></i></a>
                                <a href="#"><i class='bx bxl-instagram'></i></a>
                                <a href="#"><i class='bx bxl-pinterest'></i></a>
                            </div>
                            <div class="overlay"></div>
                        </div>

                        <h5>Darrell Steward</h5>
                        <p>Software Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light" id="reviews">

        <div class="owl-theme owl-carousel reviews-slider container">
            <div class="review">
                <div class="person">
                    <img src="{{ asset('websiteAssets/img/team_1.jpg') }}" alt="">
                    <h5>Ralph Edwards</h5>
                    <small>Market Development Manager</small>
                </div>
                <h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aut quis, rem culpa labore voluptate
                    ullam! In, nostrum. Dicta, vero nihil. Delectus minus vitae rerum voluptatum, excepturi incidunt ut,
                    enim nam exercitationem optio ducimus!</h3>
                <div class="stars">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class="bx bxs-star-half"></i>
                </div>
                <i class='bx bxs-quote-alt-left'></i>
            </div>
            <div class="review">
                <div class="person">
                    <img src="{{ asset('websiteAssets/img/team_2.jpg') }}" alt="">
                    <h5>Ralph Edwards</h5>
                    <small>Market Development Manager</small>
                </div>
                <h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aut quis, rem culpa labore voluptate
                    ullam! In, nostrum. Dicta, vero nihil. Delectus minus vitae rerum voluptatum, excepturi incidunt ut,
                    enim nam exercitationem optio ducimus!</h3>
                <div class="stars">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class="bx bxs-star-half"></i>
                </div>
                <i class='bx bxs-quote-alt-left'></i>
            </div>
            <div class="review">
                <div class="person">
                    <img src="{{ asset('websiteAssets/img/team_3.jpg') }}" alt="">
                    <h5>Ralph Edwards</h5>
                    <small>Market Development Manager</small>
                </div>
                <h3>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aut quis, rem culpa labore voluptate
                    ullam! In, nostrum. Dicta, vero nihil. Delectus minus vitae rerum voluptatum, excepturi incidunt ut,
                    enim nam exercitationem optio ducimus!</h3>
                <div class="stars">
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class="bx bxs-star-half"></i>
                </div>
                <i class='bx bxs-quote-alt-left'></i>
            </div>
        </div>
    </section>

    <section id="contact-us">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="intro">
                        <h1>{{ __('admin.Contact Us') }}</h1>
                        <p class="mx-auto">Fell free to contact us and we will get back to you as soon as possible</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form class="p-lg-5 col-12 row g-3">

                        <div class="col-lg-6">
                            <label for="firstName" class="form-label">{{ __('admin.First name') }}</label>
                            <input type="text" class="form-control" id="firstName"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-lg-6">
                            <label for="lastName" class="form-label">{{ __('admin.Last name') }}</label>
                            <input type="text" class="form-control"  id="lastName"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">{{ __('admin.Email') }}</label>
                            <input type="email" class="form-control"
                                id="email" aria-describedby="emailHelp">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">{{ __('admin.Message') }}</label>
                            <textarea name=""
                                class="form-control" id="" rows="4"></textarea>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-brand">{{ __('admin.Send Message') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>


    <footer>
        <div class="footer-top text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset($data['logo']) }}" class="navbar-brand-footer mb-5" alt="">
                        <p>{{ $data['footer_text'] }}</p>

                        <div class="col-auto conditions-section">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact Us </a>
                            <a href="mailto:{{ $data['email'] }}">Techincle Support</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right']}}</p> Distributed By : {{ $data['distributed_by'] }}</a>
        </div>
    </footer>


    <script>
    let lang = "{{ app()->getLocale() }}" ;

    </script>
    <script src="{{ asset('websiteAssets/js/milestone.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/app.js') }}"></script>
</body>

</html>
