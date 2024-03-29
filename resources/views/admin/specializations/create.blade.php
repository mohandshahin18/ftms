@extends('admin.master')

@section('title' , __('admin.Add Specialization'))
@section('sub-title' , __('admin.Specializations'))
@section('specializations-menu-open' , 'menu-open')
@section('specializations-active' , 'active')
@section('add-specialization-active' , 'active')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{ __('admin.Add New Specialization') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.specializations.store') }}" method="POST" >
                @csrf
              <div class="card-body">
               <div class="row">
                 {{-- name --}}
                 <div class="col-lg-6">
                    <div class="form-group">
                        <label class="mb-2">{{ __('admin.Specialization') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="{{ __('admin.Specialization') }}" value="{{ old('name') }}">
                        @error('name')
                        <small class="invalid-feedback"> {{ $message }}</small>
                        @enderror
                    </div>
                    </div>

               </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button  class="btn btn-dark btn-flat" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                <button type="submit" class="btn btn-primary btn-flat">
                    <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop
