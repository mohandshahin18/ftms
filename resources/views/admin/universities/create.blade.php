@extends('admin.master')

@section('title', __('admin.Add New University'))
@section('sub-title', __('admin.Universities'))
@section('universities-menu-open', 'menu-open')
@section('universities-active', 'active')
@section('add-university-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New University') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.universities.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.University Name') }}" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- email  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2"> {{ __('admin.Email') }}</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="{{ __('admin.Email') }}" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2"> {{ __('admin.Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="{{ __('admin.Phone') }}" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- address  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Location') }}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="{{ __('admin.Location') }}" value="{{ old('address') }}">
                                    @error('address')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
