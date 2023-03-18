@extends('admin.master')

@section('title',  __('admin.Edit Advert') )
@section('sub-title', __('admin.Adverts'))
@section('adverts-active', 'active')
@section('index-advert-active', 'active')



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="float: unset">{{ __('admin.Edit Advert') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.adverts.update', $advert->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class=" col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Main Title') }}</label>
                                    <input type="text" class="form-control @error('main_title') is-invalid @enderror"
                                        name="main_title" placeholder="{{ __('admin.Main Title') }}" value="{{ old('main_title', $advert->main_title) }}">
                                    @error('main_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- name  --}}
                            <div class=" col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Sub Title') }}</label>
                                    <textarea name="sub_title" class="form-control @error('sub_title') is-invalid @enderror" placeholder="{{ __('admin.Sub Title') }}" id=""  rows="5">{{ old('sub_title', $advert->sub_title) }}</textarea>

                                    @error('sub_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                             {{-- name  --}}
                             <div class=" col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Image') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image"  >
                                    @error('image')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                    <img src="{{ asset($advert->image) }}" width="120" alt="">
                                </div>
                            </div>







                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-pen"></i> {{ __('admin.Update') }}</button>

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

