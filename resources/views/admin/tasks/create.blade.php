@extends('admin.master')

@section('title', 'Add New Tasks')
@section('sub-title', 'Tasks')
@section('tasks-menu-open', 'menu-open')
@section('tasks-active', 'active')
@section('add-university-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Task</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.tasks.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- Main Title  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Main Title</label>
                                    <input type="text" class="form-control @error('main_title') is-invalid @enderror"
                                    name="main_title" placeholder="Like Task 1, Task 2 ..." value="{{ old('main_title') }}">
                                    @error('main_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sub Title  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Sub Title</label>
                                    <input type="text" class="form-control @error('sub_title') is-invalid @enderror"
                                        name="sub_title" placeholder="University sub_title" value="{{ old('sub_title') }}">
                                    @error('sub_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- start date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Start Date</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date">
                                    @error('start_date')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- end date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date">
                                    @error('end_date')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- File  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">File</label><span>(Optional)</span>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
                                    @error('file')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- description --}}
                            <div class="mb-3 col-12">
                                <label for="description">Description</label>
                                <textarea name="description" class="@error('description') is-invalid @enderror" id="my-desc">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js" referrerpolicy="no-referrer"></script>

    <script>
        tinymce.init({
            selector: '#my-desc'
        });
    </script>
@stop