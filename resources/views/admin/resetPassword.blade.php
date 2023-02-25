@extends('admin.master')

@section('title', Auth::guard()->user()->name . ' -'.  __('admin.Edit Password'))
@section('sub-title', __('admin.Edit Password'))

@section('content')

    <div class="box-all   ">
        <form action="{{ route('update-password' ) }}" method="POST">
            @csrf
        <div class="row ">

            <div class="   col-md-12 ">
                <div class="p-3 bg-white rounded shadow  mb-5">

                    <div class="row mt-3">
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


                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary profile-button"  type="submit"> {{ __('admin.Save Edit') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

@stop

@section('scripts')
{{-- Messages Script --}}
@if (session('msg'))
  <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: false,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

    @if (session('type') == 'success')
      Toast.fire({
      icon: 'success',
      title: '{{ session('msg') }}'
      })
    @elseif (session('type') == 'danger')
      Toast.fire({
      icon: 'error',
      title: '{{ session('msg') }}'
      })
    @else
      Toast.fire({
        icon: 'info',
        title: '{{ session('msg') }}'
        })
    @endif
  </script>
@endif
@stop
