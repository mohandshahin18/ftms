<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> {{ config('app.name') }} | {{ __('admin.Forget Password') }} </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/style.css') }}">
    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/style-ar.css') }}">
        <style>
                    @font-face {
                        font-family: event-reg;
                        src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});
                    }
            </style>

    @endif

    <style>
        .bg{
            position: absolute;
            height: 100%;
            width: 100%;
            background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
            background-size: cover !important;

        }
    </style>
</head>

<body>
    <div class="bg">
        <div class="overlay">
            <div class="signin">
                <div class="logo"><img src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}"  style="width: 115px" alt=""></div>
                <div class="signin-form">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('forget.password.post') }}">
                                @csrf
                                <h3>{{ __('admin.Forget Password') }}</h3>


                                @if ($errors->any())
                                    <div class=" alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif

                                @if (session('msg'))
                                    <div class=" alert-{{ session('type') }}">
                                        <li>{{ session('msg') }}</li>
                                    </div>
                                @endif

                                    {{-- @dump( Carbon::now()->subMinutes(60)) --}}
                                <input type="hidden" value="{{ $type }}" name="type">

                                <div class="mb-3 form-group ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                        <g id="Icon_" data-name="Icon " transform="translate(0.176 0.486)">
                                            <rect id="Area_ICON:feather_x_SIZE:MEDIUM_STATE:DEFAULT_STYLE:STYLE2_"
                                                data-name="Area [ICON:feather/x][SIZE:MEDIUM][STATE:DEFAULT][STYLE:STYLE2]"
                                                width="22" height="22" transform="translate(-0.176 -0.486)"
                                                fill="#222" opacity="0" />
                                            <g id="Icon" transform="translate(1.999 3.536)">
                                                <path id="Path"
                                                    d="M10.318,17H24.864a1.824,1.824,0,0,1,1.818,1.818v10.91a1.824,1.824,0,0,1-1.818,1.818H10.318A1.824,1.824,0,0,1,8.5,29.728V18.818A1.824,1.824,0,0,1,10.318,17Z"
                                                    transform="translate(-8.5 -17)" fill="none" stroke="#3d3d3d"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                                <path id="Path-2" data-name="Path" d="M26.683,25.5l-9.091,6.364L8.5,25.5"
                                                    transform="translate(-8.5 -23.682)" fill="none" stroke="#3d3d3d"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                            </g>
                                        </g>
                                    </svg>

                                    <input type="email" class=" form-control " name="email" value="{{ old('email') }} "
                                    placeholder="{{ __('admin.Email') }}">


                                </div>

                                <div class="btn-web">
                                    <button class="btn btn-primary bold w-100">{{ __('admin.Send Password Reset Link') }}</button>

                                </div>

                            </form>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('adminAssets/loginAssets/assets/images/signin.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="bottom-bg">

                </div>
            </div>
        </div>
    </div>
</body>

</html>
