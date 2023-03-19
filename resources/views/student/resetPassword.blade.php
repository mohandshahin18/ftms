@extends('student.master')

@section('title', __('admin.Edit Password'))
@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>

.bg{

    height: 100%;
      background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
      background-size: cover !important;
      backdrop-filter: blur(5px);

}


.bg .overlay{
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0);
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
        }

    </style>
@stop

@section('content')


<section class="bg-light" id="reviews">
    <div class="container">
        <h2 class="text-white">{{ __('admin.Edit Password') }}</h2>
    </div>
</section>

<div class="bg " >
<div class="overlay">
<div class="container ">
    <div class="box-all   ">
        <form action="{{ route('update-password' ) }}" class="reset-form" method="POST">
            @csrf
        <div class="row justify-content-center ">


            <div class=" col-md-6 mt-5 ">
                <div class="p-3 bg-white rounded shadow  mb-5">

                    <div class="alert  d-none" >
                        <ul>
                            <li>

                            </li>

                        </ul>
                    </div>

                    <div class="row mt-3 px-2">
                        <div class="col-md-12 mb-3">
                            <label class="labels">{{ __('admin.Current Password') }}</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="{{ __('admin.Current Password') }}" value="{{ old('current_password') }}">
                                @error('current_password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="labels">{{ __('admin.New Password') }}</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="{{ __('admin.New Password') }}" value="{{ old('new_password') }}">
                                @error('new_password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="labels">{{ __('admin.New Password Confirmation') }}</label>
                            <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="{{ __('admin.New Password Confirmation') }}" value="{{ old('new_password_confirmation') }}">
                                @error('new_password_confirmation')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>








                    </div>


                    <div class="mt-3 text-end">
                        <button class="btn btn-brand profile-button" type="button" > {{ __('admin.Save Edit') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('scripts')

    <script>
        let resetForm = $(".reset-form");
        let btn = $(".profile-button");



        resetForm.on('submit' , function(e) {
            e.preventDefault();
        })

        btn.on("click", function() {
            btn.attr('disabled', true);
            let url = resetForm.attr('action');
            let data = resetForm.serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: url,
                data: data,
                beforeSend: function(data) {
                    btn.addClass("btn-circle");
                    btn.html('<i class="fa fa-spin fa-spinner "></i>');
                } ,
                success: function(data) {
                    $('.invalid-feedback').remove();
                    $('input').removeClass('is-invalid');
                    setTimeout(() => {
                        btn.html('<i class="fas fa-check"></i>');
                        $('input').val('');
                        $('.alert ul li').html('');
                        $('.alert').removeClass('d-none').removeClass('alert-danger').addClass('alert-success');
                        $('.alert ul li').append('{{ __('admin.Password changed successfully') }}')
                    }, 1000);

                    setTimeout(() => {
                        btn.removeAttr("disabled");
                        btn.html('{{ __('admin.Save Edit') }}');

                    }, 2000);

                    setTimeout(() => {
                        $('.alert').addClass('d-none');
                    }, 10000);


                },
                error: function(data) {
                    btn.attr("disabled", false)
                    btn.removeClass('btn-circle')
                    btn.html('{{ __('admin.Save Edit') }}');

                    $('.invalid-feedback').remove();

                    if(data.responseJSON.title){
                        $('.alert ul li').val('')
                        $('input').val('')
                        $('.alert ul li').html('');
                        $('.alert').removeClass('d-none').removeClass('alert-success').addClass('alert-danger')
                        $('.alert ul li').append(data.responseJSON.title)
                    }else{
                        $.each(data.responseJSON.errors, function(field, error) {
                            $("input[name='" + field + "']").addClass('is-invalid').after(
                                '<small class="invalid-feedback">' + error + '</small>');
                        });
                    }

                },
            })
        })
    </script>

@stop
