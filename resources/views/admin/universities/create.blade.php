@extends('admin.master')

@section('title', 'Add New University')
@section('sub-title', 'Universities')
@section('universities-menu-open', 'menu-open')
@section('universities-active', 'active')
@section('add-university-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New University</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.universities.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">University name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="University name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- email  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">University email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="University email" value="{{ old('email') }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- phone --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">University phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="University phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- address  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">University address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="University address" value="{{ old('address') }}">
                                    @error('address')
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
