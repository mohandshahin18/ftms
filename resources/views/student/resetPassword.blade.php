@extends('student.master')

@section('title', Auth::guard()->user()->name . ' - reset password')
@section('styles')
<style>
.bg{

    height: 100%;
      background: url('{{ asset('adminAssets/dist/img/selection/bg.png') }}') no-repeat center center;
      font-family: "Barlow", sans-serif;
      background-size: cover !important;
      backdrop-filter: blur(5px);

}


.bg .overlay{
/*
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.188); */

    }
</style>
@stop
@section('content')



<div class="bg " >
<div class="overlay">
<div class="container ">
    <div class="box-all   ">
        <form action="{{ route('update-password' ) }}" method="POST">
            @csrf
        <div class="row justify-content-center ">

            <div class=" col-md-6 mt-5">
                <div class="p-3 bg-white rounded shadow  mb-5">
                    @if (session('msg'))
                    <div class="alert alert-{{ session('type') }}">
                       <li> {{ session('msg') }}</li>
                    </div>
                @endif


                    <div class="row mt-3 px-2">
                        <div class="col-md-12 mb-3">
                            <label class="labels">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Password" value="{{ old('current_password') }}">
                                @error('current_password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="labels">New Password</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Password" value="{{ old('new_password') }}">
                                @error('new_password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="labels">New Password Confirmation</label>
                            <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="Password" value="{{ old('new_password_confirmation') }}">
                                @error('new_password_confirmation')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>








                    </div>


                    <div class="mt-3 text-end">
                        <button class="btn btn-primary profile-button"  type="submit"> Save Edit </button>
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
