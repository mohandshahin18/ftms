@extends('admin.master')

@section('title',__('admin.Add New University ID'))
@section('sub-title', __('admin.University IDs'))
@section('subscribes-menu-open', 'menu-open')
@section('subscribes-active', 'active')
@section('add-subscribe-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New University ID') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.subscribes.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University ID') }}</label>
                                    <input type="text" class="form-control @error('university_id_st') is-invalid @enderror"
                                        name="university_id_st" placeholder="{{ __('admin.University ID') }}" value="{{ old('name') }}">
                                    @error('university_id_st')
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
