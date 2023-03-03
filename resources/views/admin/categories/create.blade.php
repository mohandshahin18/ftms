@extends('admin.master')

@section('title' , __('admin.Add New Program'))
@section('sub-title' , __('admin.Programs'))
@section('categories-menu-open' , 'menu-open')
@section('categories-active' , 'active')
@section('add-category-active' , 'active')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{ __('admin.Add New Program') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label class="mb-2">{{ __('admin.Program Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="{{ __('admin.Program Name') }}" value="{{ old('name') }}">
                    @error('name')
                    <small class="invalid-feedback"> {{ $message }}</small>
                    @enderror
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button  class="btn btn-dark" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop
