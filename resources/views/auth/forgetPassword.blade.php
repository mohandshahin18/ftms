<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> {{ config('app.name') }} | Forget Password </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/style.css') }}">
    <style>
        input.error {
            border: 1px solid #dc3545;
        }

        small {
            color: #dc3545;
            text-align: right;
            display: block;
            margin: 6px 0 0 0;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid;
            border-color: #f5c2c7;
            color: #842029;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;

        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid;
            border-color: #c3e6cb;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid;
            border-color: #ffeeba;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <div class="signin">
        <div class="logo"><img src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}"  style="width: 115px" alt=""></div>
        <div class="signin-form">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route('forget.password.post') }}">
                        @csrf
                        <h3>Forget Password</h3>


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
                                placeholder="Email">


                        </div>

                        <button class="btn btn-primary bold w-100 py-2">Send Password Reset Link</button>


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
</body>

</html>
