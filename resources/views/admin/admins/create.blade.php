@extends('admin.master')

@section('title', 'Add New Admin')
@section('sub-title', 'Admins')
@section('admins-menu-open', 'menu-open')
@section('admins-active', 'active')
@section('add-admin-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.admins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Admin name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Admin name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- Email  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Admin email" value="{{ old('email') }}" autocomplete="new-email">
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
                                        name="password" placeholder="Admin password" value="{{ old('password') }}">
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
                                        name="phone" placeholder="Admin phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- image  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">Admin Image</label>
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
