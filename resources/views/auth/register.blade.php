<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | {{ __('admin.Create a new account') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/loginAssets/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
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
        .p{
            font-size: 12px;
            font-weight: 600
        }
        .p span{
            color: #ff0000;
            font-size: 14px
        }

      </style>



</head>

<body>
    <div class="bg">
        <div class="overlay">
            <div class="signin">
                <div class="logo"><img src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}"  style="width: 115px" alt="">
                </div>
                <div class="signin-form register">
                    <div class="row">
                        <form method="POST" action="{{ route('student.register', $subsicribe->university_id ) }}">
                            @csrf
                            <h3 >{{ __('admin.Create a new account') }}</h3>
                            <div class="row">

                                        {{-- name  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <input type="name" class="form-control" value="{{ $subsicribe->name }}" disabled placeholder="{{ __('admin.Name') }}">
                                    </div>
                                </div>

                                {{-- Student ID  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <input type="text" class="form-control" value="{{ $subsicribe->university_id }}" placeholder="{{ __('admin.Student ID') }}" disabled>
                                    </div>
                                </div>

                                {{-- email  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <input type="email" class="form-control @error('email') error @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="{{ __('admin.Email') }}">
                                        @error('email')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- phone  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <input type="text" class="form-control @error('phone') error @enderror"
                                            name="phone" value="{{ old('phone') }}" placeholder="{{ __('admin.Phone') }}">
                                        @error('phone')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                @php
                                    use App\Models\University;
                                    use App\Models\Specialization;
                                    $universities = University::get();
                                    $specializations = Specialization::get();
                                @endphp

                                {{-- University  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <select name="university_id" class="form-control @error('university_id') error @enderror" id="university_id">
                                            <option value=" ">{{ __('admin.Select University') }}</option>
                                            @foreach ($universities as $university)
                                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('university_id')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Specializations  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <select name="specialization_id" class="form-control @error('specialization_id') error @enderror" id="specialization_id">
                                            <option value=" ">{{ __('admin.Select Specialization') }}</option>
                                            @foreach ($specializations as $specialization)
                                            @endforeach
                                        </select>
                                        @error('specialization_id')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                {{-- password --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group pass">
                                        <input type="password" id="password"
                                            class="form-control @error('password') error @enderror" name="password"
                                            placeholder="{{ __('admin.Password') }}">
                                        @error('password')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Confirm Password  --}}
                                <div class="col-md-6">
                                    <div class="mb-3 form-group">
                                        <input  type="password" id="confirm_password" class="form-control @error('password') error @enderror" name="password_confirmation" placeholder="{{ __('admin.Password Confirmation') }}">
                                        @error('password_confirmation')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="btn-web">
                                    <button type="submit" class="btn btn-primary bold ">{{ __('admin.Register') }}</button>

                                </div>

                        </form>
                        <p class="p m-0"><span >*</span>{{ __('admin.Make sure your data is correct, you cannot modify it later') }}</p>
                        <div class="account">

                            <p> <a href="{{ route('student.login.show') }}"> {{ __('admin.Do you have account ?') }} </a></p>
                        </div>
                    </div>



                </div>
            </div>
            <div class="bottom-bg">

            </div>
        </div>
    </div>



    <!--Header ends-->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>



    {{-- Ajax Request --}}
    <script>
        $(document).ready(function() {
            $("#university_id").on("change", function() {
                var uni_id = $(this).val();
                if (uni_id) {
                    $.ajax({
                        url: "/student/get/specialization/" + uni_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#specialization_id").empty();
                            $.each(data, function(key, value) {
                                $("#specialization_id").append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                    });
                }
            });
        });

        // Confirm Password input Check

        var password = document.querySelector("#password");
        var confirm_password = document.querySelector("#confirm_password");
        // confirm_password.addClass("");
        password.onkeyup = () => {
            if (confirm_password.value !== password.value) {
                confirm_password.classList.add("error");
                confirm_password.classList.remove("is-valid");
                confirm_password.classList.remove("border-success");
            } else {
                confirm_password.classList.remove("error");
                confirm_password.classList.add("is-valid");
                confirm_password.classList.add("border-success");
            }
        }
        confirm_password.onkeyup = () => {
            if (confirm_password.value !== password.value) {
                confirm_password.classList.add("error");
                confirm_password.classList.remove("is-valid");
                confirm_password.classList.remove("border-success");
            } else {
                confirm_password.classList.remove("error");
                confirm_password.classList.add("is-valid");
                confirm_password.classList.add("border-success");
            }
        }


    </script>


</body>

</html>
