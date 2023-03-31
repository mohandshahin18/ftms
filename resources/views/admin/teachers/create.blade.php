@extends('admin.master')

@section('title', __('admin.Add New Teacher'))
@section('sub-title', __('admin.Teachers'))
@section('teachers-menu-open', 'menu-open')
@section('teachers-active', 'active')
@section('add-teacher-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New Teacher') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Teacher Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.Teacher Name') }}" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- Email  --}}
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

                            {{-- University --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University Name') }}</label>
                                    <select name="university_id" id="university_id" class="form-control @error('university_id') is-invalid @enderror" id="">
                                        <option value="">{{ __('admin.Select University') }}</option>
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('university_id')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- specialization --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Specialization') }}</label>
                                    <select name="specialization_id" id="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror" id="">
                                        <option value="">{{ __('admin.Select Specialization') }}</option>
                                        @foreach ($specializations as $specialization)
                                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('specialization_id')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                             {{-- role --}}
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Role') }}</label>
                                    <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" id="">
                                        <option value="">{{ __('admin.Select Role') }}</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- image  --}}
                            <div class="col-lg-6">
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop
@section('scripts')
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
                                $("#specialization_id").append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>
@stop
