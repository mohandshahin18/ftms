
<!DOCTYPE html>
<html >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>FTMS | Register</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/favicon.ico') }}">

    <style>
        @font-face {
            font-family: event-reg;
            src: url({{ asset('adminAssets/dist/fonts/JF-Flat-regular.ttf') }});

        }

        body {
            margin: 0;
            font-family: event-reg !important;
        }


        .header {
            position: relative;
            text-align: center;
            color: white;
            background: url({{ asset('adminAssets/dist/img/header/header.JPG') }}) no-repeat center center;
            background-size: cover;
            height: 100vh;
        }

        .overlay {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.607);
            top: 0;
            left: 0;
            height: 100%;
            width: 100%
        }



        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 750px;
            padding: 40px;
            transform: translate(-50%, -50%);
            background: rgb(0 0 0 / 80%);
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.548);
            border-radius: 10px;
            z-index: 999;
        }
        .login-box form{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .login-box h2 {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
        }

        .login-box .user-box {
            position: relative;
            margin-bottom: 20px;
            width: 45%;
        }

        .login-box .user-box input ,
        .login-box .user-box select {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            border: none;
            border: 1px solid #fff;
            outline: none;
            background: transparent;
        }
        .login-box .user-box select option{
            background-color: rgba(0, 0, 0, 0.712);
        }

        .login-box .user-box input:focus {
            border-color: #5d78ff
        }

        .login-box .user-box label {
            text-align: right;
            display: block;
            font-size: 16px;
            color: #fff;
            margin-bottom: 10px
        }

        .login-box .user-box input.error {
            border: 1px solid #dc3545;
        }

        .login-box .user-box small {
            color: #dc3545;
            text-align: right;
            display: block;
            margin: 6px 0 0 0;
        }

        .login-box a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s ease-in-out;

        }

        .login-box a:hover {
            color: #5d78ff !important;
        }

        .login-box form button {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-family: event-reg !important;

        }

        .login-box button:hover {
            background: #5d78ff;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px #5d78ff,
                0 0 25px #5d78ff,
                0 0 50px #5d78ff,
                0 0 100px #5d78ff;
        }

        .login-box button span {
            position: absolute;
            display: block;
        }

        .login-box button span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #5d78ff);
            animation: btn-anim1 1s linear infinite;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }

            50%,
            100% {
                left: 100%;
            }
        }

        .login-box button span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #5d78ff);
            animation: btn-anim2 1s linear infinite;
            animation-delay: .25s
        }

        @keyframes btn-anim2 {
            0% {
                top: -100%;
            }

            50%,
            100% {
                top: 100%;
            }
        }

        .login-box button span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #5d78ff);
            animation: btn-anim3 1s linear infinite;
            animation-delay: .5s
        }

        @keyframes btn-anim3 {
            0% {
                right: -100%;
            }

            50%,
            100% {
                right: 100%;
            }
        }

        .login-box button span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #5d78ff);
            animation: btn-anim4 1s linear infinite;
            animation-delay: .75s
        }

        @keyframes btn-anim4 {
            0% {
                bottom: -100%;
            }

            50%,
            100% {
                bottom: 100%;
            }
        }
    </style>


    @if (app()->getLocale() == 'en')
        <style>
            .login-box .user-box label {
                text-align: left
            }
            .login-box .user-box small{
                text-align: left !important;
            }
        </style>
    @endif
</head>

<body>

    <!--Hey! This is the original version
of Simple CSS Waves-->
    <div class="header">
        <div class="overlay">
            <!--Content before waves-->
            <div class="inner-header flex">
                <div class="all">
                    <div class="login-box">
                      <div class="img-logo">
                            <img src="{{ asset('adminAssets/dist/img/logo/S2.png') }}" alt="">
                        </div>
                        <form method="POST" action="{{ route('register') }}" >
                            @csrf
                            {{-- name --}}
                            <div class="user-box">
                                <label>Name</label>
                                <input type="name" class="@error('name') error @enderror" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- email --}}
                            <div class="user-box">
                                <label>Email</label>
                                <input type="email" class="@error('email') error @enderror" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- phone --}}
                            <div class="user-box">
                                <label>Phone</label>
                                <input type="text" class="@error('phone') error @enderror" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- email --}}
                            <div class="user-box">
                                <label>Student ID</label>
                                <input type="text" class="@error('student_id') error @enderror" name="student_id"
                                    value="{{ old('student_id') }}">
                                @error('student_id')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>



                            <?php
                                use App\Models\University;
                                use App\Models\Specialization;

                                $universities = University::get();
                                $specializations = Specialization::get();
                            ?>
                             {{-- University --}}
                             <div class="user-box">
                                <label class="mb-2">University</label>
                                    <select name="university_id" class="form-control" id="university_id">
                                        <option data-display="Select University">Select University</option>
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                             {{-- Specializations --}}
                             <div class="user-box">
                                <label class="mb-2">Specialization</label>
                                    <select name="specialization_id" class="form-control" id="specialization_id">
                                        <option data-display="Select Specialization">Select Specialization</option>
                                        @foreach ($specializations as $specialization)
                                            
                                        @endforeach
                                    </select>
                            </div>




                            <div class="user-box">
                                <label>Password</label>
                                <input type="password" class="@error('password') error @enderror" name="password"
                                    autocomplete="new-password">
                                @error('password')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="user-box">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password">

                            </div>




                            <button class="btn-login">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Register
                            </button>
                            <br>
                            <br>

                        </form>
                        <div style="display: flex; align-items: center; justify-content: flex-end;">

                            @if (Route::has('password.request'))
                                <a href="{{ route('login') }}">
                                   You have account ?
                                </a>
                            @endif


                        </div>

                    </div>


                </div>


            </div>


        </div>
    </div>
    <!--Header ends-->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    {{-- Ajax Request --}}
    <script>
            $(document).ready(function() {
                $("#university_id").on("change", function() {
                    var uni_id = $(this).val();
                    if(uni_id) {
                        $.ajax({
                            url: "admin/getSpecialization/"+ uni_id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $("#specialization_id").empty();
                                $.each(data, function(key, value) {
                                    $("#specialization_id").append('<option value="'+ key+ '">'+ value+ '</option>');
                                });
                            },
                        });
                    }
                });
            });
    </script>
</body>

</html>

