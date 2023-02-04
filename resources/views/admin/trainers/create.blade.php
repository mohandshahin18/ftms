@extends('admin.master')

@section('title', 'Add New Trainer')
@section('sub-title', 'Trainers')
@section('trainers-menu-open', 'menu-open')
@section('trainers-active', 'active')
@section('add-trainer-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New trainer</h3>
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
                                    <label class="mb-2">Trainer name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Trainer name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- password  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Trainer email" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- password  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Trainer password" value="{{ old('password') }}">
                                    @error('password')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Trainer phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- company --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Company</label>
                                    <select name="company_id" class="form-control" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             {{-- Program --}}
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Program</label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option value="">Select Program</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            {{-- address  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">trainer Image</label>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add</button>
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> Return Back </button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')
 {{-- Ajax Request --}}
 {{-- <script>
    $(document).ready(function() {
        $("#company_id").on("change", function() {
            var comp_id = $(this).val();
            if (comp_id) {
                $.ajax({
                    url: "/get/category/" + comp_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#category_id").empty();
                        $.each(data, function(key, value) {
                            $("#category_id").append('<option value="' + key +
                                '">' + value + '</option>');
                        });
                    },
                });
            }
        });
    });

    </script> --}}
@stop
