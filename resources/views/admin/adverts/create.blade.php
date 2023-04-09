@extends('admin.master')

@section('title',__('admin.Add New ADvert'))
@section('sub-title', __('admin.Adverts'))
@section('adverts-menu-open', 'menu-open')
@section('adverts-active', 'active')
@section('add-advert-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New Advert') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.adverts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                             {{-- name  --}}
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Main Title') }}</label>
                                    <input type="text" class="form-control @error('main_title') is-invalid @enderror"
                                        name="main_title" placeholder="{{ __('admin.Main Title') }}" value="{{ old('main_title') }}">
                                    @error('main_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Sub Title') }}</label>
                                    <textarea name="sub_title" class="form-control @error('sub_title') is-invalid @enderror" placeholder="{{ __('admin.Sub Title') }}" id=""  rows="5">{{ old('sub_title') }}</textarea>
                                    @error('sub_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                             {{-- name  --}}
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Image') }} ({{ __('admin.Optional') }})</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" placeholder="{{ __('admin.Image') }}" value="{{ old('image') }}">
                                    @error('image')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>





                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark btn-flat" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    {{-- Ajax Request --}}
    <script>
        $(document).ready(function() {
            $("#university_id").on("change", function() {
                var uni_id = $(this).val();
                if (uni_id) {
                    $.ajax({
                        url: "/admin/get/specialization/" + uni_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#specialization_id").empty();
                            $.each(data, function(key, value) {
                                $("#specialization_id").append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>
@stop
