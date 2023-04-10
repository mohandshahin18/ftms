<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} | {{ __('admin.Selection Page') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap');

        body {
            height: 100vh;
            background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
            font-family: 'Cairo', sans-serif;
            background-size: cover !important;
            backdrop-filter: blur(5px);
            padding-bottom: 40px;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        a:hover {
            color: #000;
        }

        .logo,
        .title {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .title {
            gap: 5px;
        }

        .boxes .box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
        }

        .boxes .box img {
            transition: all 0.3s ease;
        }

        .boxes .box h6 {
            font-size: 1.2rem;
        }

        .boxes .box:hover img {
            filter: drop-shadow(2px 8px 8px #585858);
            animation: card_movment 1.5s ease-in-out infinite;

        }

        .boxes .box img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            object-fit: cover;
        }


        @keyframes card_movment {
            0% {
                transform: translateZ(0px);
                transform: translateY(0px);
            }

            50% {
                transform: translateZ(10px);
                transform: translateY(-8px);
            }
        }




        .wrapper {
            display: grid;
            place-items: center;
        }

        .typing-demo {
            width: 12ch;
            animation: typing 2.5s steps(22, end) forwards, blink .5s step-end infinite alternate;
            white-space: nowrap;
            overflow: hidden;
            border-right: 3px solid;
            font-size: 2.4em;
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 12ch;
            }

        }


        @keyframes blink {
            50% {
                border-color: transparent
            }
        }

        .typing-demo:nth-of-type(2n) {
            animation-delay: 5s;
        }

        .dropdown {
            position: absolute;
            display: inline-block;
            top: 40px;
            left: 40px
        }

        .dropdown span {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 115px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;
            text-align: center;
            right: 0;
        }

        .dropdown-content a {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;

        }

        .dropdown:hover .dropdown-content {
            /* display: block; */
            display: flex;
            flex-direction: column;
            gap: 10px
        }

        img.image-lang {
            width: 25px
        }
    </style>

    @if (app()->getLocale() == 'ar')
        <style>
            body,
            html {
                direction: rtl;
                font-family: event-reg;
            }

            @font-face {
                font-family: event-reg;
                src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
            }


            .dropdown {
                left: unset !important;
                right: 40px;
            }

            .dropdown-content {
                left: 0 !important;
            }

            .typing-demo {
                    width: 12ch;
                    animation: typing 2.5s steps(22, end) forwards, blink .5s step-end infinite alternate;
                    white-space: nowrap;
                    overflow: hidden;
                    border-right: unset !important;
                    border-left: 3px solid;
                    font-size: 2.4em;
                }
        </style>
    @endif


</head>

<body>
    <div class="dropdown">
        @if (app()->getLocale() == 'ar')
            <span>العربية <img src="{{ asset('adminAssets/dist/img/lang/ar.png') }}" width="25"></span>
        @else
            <span> Enghish <img src="{{ asset('adminAssets/dist/img/lang/en.png') }}" width="25"> </span>
        @endif
        <div class="dropdown-content">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a rel="alternate" class="text-secondary "
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $properties['native'] }}
                    <img src="{{ asset('adminAssets/dist/img/lang/' . $properties['flag']) }}" alt=""
                        class="mr-2 image-lang">

                </a>
            @endforeach
        </div>
    </div>
    @php
    $data = json_decode(File::get(storage_path('app/settings.json')), true);
    @endphp
    <div class="container">
        <div class="row boxes">
            <div class="logo mt-5">
                <a href="{{ route('website.home') }}"><img src="{{ asset($data['darkLogo']) }}" class="img-responsive" style="width: 170px" alt=""></a>
            </div>
            <div class="wrapper mt-5">
                <div class="typing-demo">
                    {{ __('admin.Selection Page') }} </div>
            </div>
            <div class="col-lg-3 col-sm-6 mt-5">
                <a href="{{ route('login.show', 'admin') }}">
                    <div class="box">
                        <img src="{{ asset('adminAssets/dist/img/selection/admin.png') }}" alt="">
                        <h6>{{ __('admin.Admin s') }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 mt-5">
                <a href="{{ route('login.show', 'company') }}">
                    <div class="box">
                        <img src="{{ asset('adminAssets/dist/img/selection/company.png') }}" alt="">
                        <h6>{{ __('admin.Company s') }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 mt-5">
                <a href="{{ route('login.show', 'teacher') }}">
                    <div class="box">
                        <img src="{{ asset('adminAssets/dist/img/selection/teacher.png') }}" alt="">
                        <h6>{{ __('admin.Teacher s') }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 mt-5">
                <a href="{{ route('login.show', 'trainer') }}">
                    <div class="box">
                        <img src="{{ asset('adminAssets/dist/img/selection/trainer.png') }}" alt="">
                        <h6>{{ __('admin.Trainer s') }}</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

</body>

</html>
