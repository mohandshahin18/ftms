

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> {{ config('app.name') }} | {{ __('admin.University ID check') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('adminAssets/dist/img/selection/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                <div class="logo"><img src="{{ asset('adminAssets/dist/img/logo/logo-11.png') }}"  style="width: 115px" alt=""></div>
                <div class="signin-form">
                    <div class="row">
                        <div class="col-md-6 ">
                            <form  action="{{route('student.subsicribeId')}}" method="POST" class="check_form" >
                                @csrf

                                @if (session('msg'))
                                    <div class=" alert-{{ session('type') }}">
                                        <li>{{ session('msg') }}</li>
                                    </div>
                                @endif

                                <div class="alert alert-danger d-none" >
                                    <ul>
                                        <li>
                                        </li>

                                    </ul>
                                </div>
                                <h3>{{ __('admin.University ID check') }}</h3>
                                <p class="m-0">{{ __('admin.Enter your university id to confirm that you are registered for a field training course') }}</p>

                                <div class="mb-3 form-group mt-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                        <g id="Icon_" data-name="Icon " transform="translate(0.176 0.486)">
                                          <rect id="Area_ICON:feather_x_SIZE:MEDIUM_STATE:DEFAULT_STYLE:STYLE2_" data-name="Area [ICON:feather/x][SIZE:MEDIUM][STATE:DEFAULT][STYLE:STYLE2]" width="22" height="22" transform="translate(-0.176 -0.486)" fill="#222" opacity="0"/>
                                          <g id="Icon" transform="translate(1.999 3.536)">
                                            <path id="Path" d="M10.318,17H24.864a1.824,1.824,0,0,1,1.818,1.818v10.91a1.824,1.824,0,0,1-1.818,1.818H10.318A1.824,1.824,0,0,1,8.5,29.728V18.818A1.824,1.824,0,0,1,10.318,17Z" transform="translate(-8.5 -17)" fill="none" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                            <path id="Path-2" data-name="Path" d="M26.683,25.5l-9.091,6.364L8.5,25.5" transform="translate(-8.5 -23.682)" fill="none" stroke="#3d3d3d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"/>
                                          </g>
                                        </g>
                                    </svg>

                                    <input type="text" class="university_id form-control" name="university_id_st"  placeholder="{{ __('admin.University ID') }}">


                                </div>



                                <div class="btn-web mb-5">
                                    <button type="button" class="btn btn-primary bold check-button  w-100">{{ __('admin.Check') }}</button>

                                </div>

                            </form>
                                <p class="p"><span >*</span>  {{ __('admin.This registration is allowed for students registered for field training course only.') }} </p>

                        </div>
                        <div class="col-md-6 text-center signin_img">
                            <img src="{{ asset('adminAssets/loginAssets/assets/images/signin.png') }}" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
                <div class="bottom-bg">

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('studentAssets/js/jquery.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        let form = $(".check_form");
        let btn = $(".check-button");

        form.on('submit' , function(e) {
            e.preventDefault();
        })


        btn.on("click", function() {
            let url = form.attr('action');
            let data = form.serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data) {
                    window.location.href = data  ;

                },
                error: function(data) {
                    if(data.responseJSON.title){
                        $('.alert ul li').html('');
                        $('.alert ul li').append(data.responseJSON.title)
                        $('.alert').removeClass('d-none')
                    }else{
                        $('.alert ul li').html('');
                        $('.alert ul li').append(data.responseJSON.message)
                        $('.alert').removeClass('d-none')
                    }

                },
            })
        })
    </script>
</body>
</html>

