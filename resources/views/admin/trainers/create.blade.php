@extends('admin.master')

@section('title', __('admin.Add Trainer'))
@section('sub-title', __('admin.Trainers'))
@section('trainers-menu-open', 'menu-open')
@section('trainers-active', 'active')
@section('add-trainer-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New Trainer') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.trainers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Trainer Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.Trainer Name') }}" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- password  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="{{ __('admin.Email') }}" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- password  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="{{ __('admin.Password') }}" value="{{ old('password') }}">
                                    @error('password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="{{ __('admin.Phone') }}" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- company --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Company Name') }}</label>
                                    <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror" id="company_id">
                                        <option value=" ">{{ __('admin.Select Company') }}</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                             {{-- Program --}}
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Program') }}</label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id">
                                        <option value=" ">{{ __('admin.Select Program') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>



                            {{-- address  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Image') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                    @error('image')
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
<<<<<<< HEAD
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>
=======
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#company_id").on("change", function() {
                var comp_id = $(this).val();
                if (comp_id) {
                    $.ajax({
                        url: "/admin/get/category/" + comp_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#category_id").empty();
                            $.each(data, function(key, value) {
                                // console.log(key);
                                // console.log(value);
                                $("#category_id").append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>
@stop
