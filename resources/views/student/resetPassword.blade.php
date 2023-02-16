@extends('student.master')

@section('title', Auth::guard()->user()->name . ' - reset password')
@section('styles')
    <style>
        .bg {
            background-size: cover;
            height: 93vh;
        }

        .bg .overlay {

            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0);
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
        }
    </style>
@stop
@section('content')



    <div class="bg"
        style="background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
">
        <div class="overlay">
            <div class="container ">
                <div class="box-all">
                    <form action="{{ route('update-password') }}" method="POST" id="password_form">
                        @csrf
                        <div class="row justify-content-center align-items-center">

                            <div class="col-md-5 mt-5">
                                <div class="p-3 bg-white rounded shadow  mb-5">
                                    @if (session('msg'))
                                        <div class="alert alert-{{ session('type') }}">
                                            <li> {{ session('msg') }}</li>
                                        </div>
                                    @endif


                                    <div class="row mt-3">
                                        <div class="col-md-12 mb-3">
                                            <label class="labels">Current Password</label>
                                            <input type="password" name="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                placeholder="Password" value="{{ old('current_password') }}">
                                            @error('current_password')
                                                <small class="invalid-feedback"> {{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="labels">New Password</label>
                                            <input type="password" name="new_password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                placeholder="Password" value="{{ old('new_password') }}">
                                            @error('new_password')
                                                <small class="invalid-feedback"> {{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="labels">New Password Confirmation</label>
                                            <input type="password" name="new_password_confirmation"
                                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                placeholder="Password" value="{{ old('new_password_confirmation') }}">
                                            @error('new_password_confirmation')
                                                <small class="invalid-feedback"> {{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="mt-3 ">
                                        <button class="btn btn-brand profile-button" type="submit"> Save Edit </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    {{-- <script>
        $("#password_form").on("submit", function(e) {
            e.preventDefault();

            var url = $(this).attr("action");
            $.ajax({
                type: "post",
                url: url,
                data: $(this).serialize(),
                success:function(data) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        iconColor: 'white',
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
                        title: "<p style='color:#fff; margin: 0 !important ; z-index:999'>" + 'Password updated successfully' + "</p>",
                        })

                },
                error: function(data) {
                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {
                        $("input[name='" + field + "']").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })
        })
    </script> --}}
@endsection