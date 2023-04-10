@extends('admin.master')

@section('title', __('admin.Add New Task'))
@section('sub-title', __('admin.Tasks'))
@section('tasks-menu-open', 'menu-open')
@section('tasks-active', 'active')
@section('add-task-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New Task') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            {{-- Main Title  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Main Title') }}</label>
                                    <input type="text" class="form-control @error('main_title') is-invalid @enderror"
                                    name="main_title" placeholder="{{ __('admin.Like Task 1, Task 2 ...') }}" value="{{ old('main_title') }}">
                                    @error('main_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sub Title  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Sub Title') }}</label>
                                    <input type="text" class="form-control @error('sub_title') is-invalid @enderror"
                                        name="sub_title" placeholder="{{ __('admin.Sub Title') }}" value="{{ old('sub_title') }}">
                                    @error('sub_title')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- start date --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Starts Date') }}</label>
                                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" name="start_date">
                                    @error('start_date')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- end date --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Ends Date') }}</label>
                                    <input type="datetime-local" class="datepicker form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" name="end_date">
                                    @error('end_date')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                              {{-- Program --}}

                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Program') }}</label>
                                    <input disabled type="text" name="category_id" class="form-control"
                                          value="{{ $trainers->category->name }}">
                                </div>
                            </div>

                            {{-- File  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.File') }}</label><span>({{ __('admin.Optional') }})</span>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
                                    @error('file')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>




                            {{-- description --}}
                            <div class="mb-3 col-lg-12">
                                <label for="description">{{ __('admin.Description') }}</label><span>({{ __('admin.Optional') }})</span>
                                <textarea name="description" class="@error('description') is-invalid @enderror" id="my-desc">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js" referrerpolicy="no-referrer"></script>

    <script>
        tinymce.init({
            selector: '#my-desc'
        });
    </script>

@if(Auth::user()->tasks()->count() == 0)
<script>
    Swal.fire({

            text:'{{ __('admin.The task will appear to the student on the start date specified by you') }}',
            icon: 'warning',
            confirmButtonText: '{{ __('admin.OK') }}'
            })
</script>
@endif
@stop
