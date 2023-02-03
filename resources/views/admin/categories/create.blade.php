@extends('admin.master')

@section('title' , 'Add New Program')
@section('sub-title' , 'Progrmas')
@section('categories-menu-open' , 'menu-open')
@section('categories-active' , 'active')
@section('add-category-active' , 'active')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New Program</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
              <div class="card-body">
                <div class="form-group">
                    <label class="mb-2">Program name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="Program name" value="{{ old('name') }}">
                    @error('name')
                    <small class="invalid-feedback"> {{ $message }}</small>
                    @enderror
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add</button>
                <button  class="btn btn-dark" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> Return Back </button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop
