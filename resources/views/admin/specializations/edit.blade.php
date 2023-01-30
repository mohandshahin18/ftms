@extends('admin.master')

@section('title', 'Edit Specializations')
@section('sub-title', 'Specializations')
@section('specializations-menu-open', 'menu-open')
@section('specializations-active', 'active')
@section('index-company-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Specialization</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.specializations.update', $specialization) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Specialization name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Specialization name" value="{{ old('name', $specialization->name) }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>



                            {{-- University --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">University</label>
                                    <select name="university_id" class="form-control" id="">
                                        @foreach ($universities as $university)
                                            <option @selected($specialization->university_id == $university->id) value="{{ $university->id }}">
                                                {{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-pen"></i> Update</button>
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> Return Back </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

@stop