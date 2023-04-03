@extends('admin.master')

@section('title', __('admin.Import new university Ids'))
@section('sub-title', __('admin.University IDs'))
{{-- @section('subscribes-menu-open', 'menu-open') --}}
@section('subscribes-active', 'active')
@section('index-subscribes-active', 'active')
@section('styles')
<style>
    .alert-danger {
    color: #721c24 !important;
    background-color: #f8d7da !important;
    border-color: #f5c6cb !important;
}
</style>
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Import new university Ids') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.subscribes.importExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if (session('error'))
                        <div class="alert alert-{{ session('type') }}">
                            {{ session('error') }}
                        </div>
                         @endif
                        <div class="row">



                             {{-- name  --}}
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Excel File') }}</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    name="file" placeholder="{{ __('admin.Student Name') }}">
                                    @error('file')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                    <p style="font-size: 12px; font-weight: 600"><span class="text-danger">*</span> {{ __("admin.Only an Excel file must be selected, containing the student's name and their university id") }}</p>
                                </div>
                            </div>


                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-import"></i> {{ __('admin.Import') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
