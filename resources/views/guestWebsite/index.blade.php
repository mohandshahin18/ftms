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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    <!-- Sweat Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

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
                <img src="{{ asset($data['darkLogo']) }}" class="nav-brand" style="width: 130px">
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
                        <h6 class="text-white text-uppercase">{{ __('admin.University training programme') }}</h6>
                        <h1 class="display-5 my-4">{{ __('admin.You can login') }}<br />{{ __('admin.or create a new account') }}</h1>
                        <a href="{{ route('student.login.show') }}" class="btn btn-brand">{{ __('admin.Login') }}</a>
                        <a href="{{ route('student.subsicribeId') }}" class="btn btn-outline-light ms-3">{{ __('admin.Register') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section id="services" class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro"  data-aos="fade-up" data-aos-duration="1500"  data-aos-once="true">
                        <h6>{{ __('admin.Our Services') }}</h6>
                        <h1>What We Do?</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>
            <div class="row g-4" >
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100" data-aos-once="true">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon1.png') }}" alt="">
                        <h5>Digital Marketing</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200" data-aos-once="true">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon2.png') }}" alt="">
                        <h5>Logo Designing</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300" data-aos-once="true">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon3.png') }}" alt="">
                        <h5>Buisness consulting</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="400" data-aos-once="true">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon4.png') }}" alt="">
                        <h5>Videography</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="500" data-aos-once="true">
                    <div class="service">
                        <img src="{{ asset('websiteAssets/img/icon5.png') }}" alt="">
                        <h5>Brand Identity</h5>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="600" data-aos-once="true">
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
    <!-- MILESTONE -->
    <section id="milestone" >
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





    <section id="team"  >
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro" data-aos="fade-up" data-aos-duration="1500"  data-aos-once="true">
                        <h6>{{ __('admin.Team') }}</h6>
                        <h1>{{ __('admin.Team Members') }}</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" >

               @foreach ($members as $member )

               <div class="col-lg-4 col-md-8" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="{{ $member->id * 100 }}" data-aos-once="true">
                <div class="team-member">
                    <div class="image">
                        <img src="{{ asset($member->image) }}" style="height: 400px; object-fit: cover;" alt="">
                        <div class="social-icons">
                            <a href="{{ $member->facebook }}" target="__blank"><i class='bx bxl-facebook'></i></a>
                            <a href="{{ $member->github }}"><i class='bx bxl-github'></i></a>
                            <a href="{{ $member->linkedin }}"><i class='bx bxl-linkedin'></i></a>
                        </div>
                        <div class="overlay"></div>
                    </div>

                    <h5>{{ $member->name }}</h5>
                    <p>{{ $member->specialization }}</p>
                </div>
            </div>
               @endforeach

            </div>
        </div>
    </section>

    <section class="bg-light" id="reviews" >

        <div class="owl-theme owl-carousel reviews-slider container">

           @forelse ($comments as $comment )
                @php
                        if($comment->student){
                            $name = $comment->student->name ?? '';
                            $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                            if ($comment->student->image) {
                                    $img = $comment->student->image;
                                    $src = asset($img);
                            }
                        }else{
                            $name = __('admin.Deleted account');
                            $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;

                        }



                @endphp
                <div class="review">
                    <div class="person">
                        <img src="{{ $src }}" style="object-fit: cover;" alt="">
                        <h5>{{ $name }}</h5>
                    </div>
                    <h3>{{ $comment->body }}</h3>
                    <div class="stars">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class="bx bxs-star-half"></i>
                    </div>
                    <i class='bx bxs-quote-alt-left'></i>
                </div>
           @empty

           @endforelse
        </div>
    </section>

    <section id="contact-us">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="intro"  data-aos="fade-up" data-aos-duration="1500"  data-aos-once="true">
                        <h1>{{ __('admin.Contact Us') }}</h1>
                        <p class="mx-auto">{{ __('admin.You can contact us via email') }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center"  data-aos="fade-up" data-aos-duration="1500"  data-aos-delay="100" data-aos-once="true">
                <div class="col-lg-8">
                    <form class="p-lg-5 col-12 row g-3 contact-form" method="POST" action="{{ route('website.contact_us') }}">
                        @csrf

                        <div class="col-lg-6">
                            <label for="firstName" class="form-label">{{ __('admin.First name') }}</label>
                            <input type="text" class="form-control" name="firstname" id="firstName"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-lg-6">
                            <label for="lastName" class="form-label">{{ __('admin.Last name') }}</label>
                            <input type="text" class="form-control" name="lastname"  id="lastName"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">{{ __('admin.Email') }}</label>
                            <input type="email" class="form-control"
                                id="email" name="email" aria-describedby="emailHelp">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">{{ __('admin.Message') }}</label>
                            <textarea name="message"
                                class="form-control" id="" rows="4"></textarea>
                        </div>

                        <div class="col-12 text-end">

                            <button type="button" class="btn btn-brand btn-contact">{{ __('admin.Send Message') }}</button>
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
                        <img src="{{ asset($data['logo']) }}" class="navbar-brand-footer mb-4" alt="">
                        <p>{{ $data['footer_text'] }}</p>

                        <div class="col-auto conditions-section">
                            <a href="mailto:{{ $data['email'] }}">Techincle Support</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <p class="mb-0">{{ $data['copy_right']}}</p> {{ __('admin.Distributed By') }} : {{ $data['distributed_by'] }}</a>
        </div>
    </footer>


    <script>
    let lang = "{{ app()->getLocale() }}" ;

    </script>
    <script src="{{ asset('websiteAssets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('websiteAssets/js/app.js') }}"></script>
    <!-- Sweat Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

    <script>
          let btn = $('.btn-contact');
          let form = $(".contact-form");


            form.onsubmit = (e)=> {
                    e.preventDefault();

            }

            let formData = form.serialize();
            let url = form.attr("action");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            btn.on("click", function() {
                btn.attr("disabled", true)

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    beforeSend: function(data) {
                    btn.html('<i class="fa fa-spin fa-spinner "></i>');
                         $('.invalid-feedback').remove();
                        $('input').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                    } ,
                    success: function(data) {
                        setTimeout(() => {

                        btn.html('<i class="fas fa-check"></i>');

                        $('input').val('');
                        $('textarea').val('');

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            customClass: {
                                popup: 'colored-toast'
                            },
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: '{{ __('admin.Message has been send') }}'
                            })
                            }, 1500);

                    setTimeout(() => {
                        btn.html('{{ __('admin.Send Message') }}');
                        btn.removeAttr("disabled");
                    }, 2000);


                    } ,
                    error: function(data) {
                        btn.attr("disabled", false)
                        btn.html('{{ __('admin.Send Message') }}');
                        $('.invalid-feedback').remove();
                        $.each(data.responseJSON.errors, function (field, error) {
                            if(field == 'message') {
                        $("textarea").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                       } else {
                        $("input[name='" + field + "']").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                       }
                        });
                    } ,
                })

            });


    </script>
</body>

</html>
