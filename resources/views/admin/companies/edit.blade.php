@extends('admin.master')

@section('title', 'Edit Company')
@section('sub-title', 'Companies')
@section('companies-menu-open', 'menu-open')
@section('companies-active', 'active')
@section('index-company-active', 'active')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Company</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.companies.update', $company->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            {{-- name  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Company name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Company name" value="{{ old('name', $company->name) }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- email --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Email" value="{{ old('email', $company->email) }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- phone  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Company phone"
                                        value="{{ old('phone', $company->phone) }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- address --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="address"
                                        value="{{ old('address', $company->address) }}">
                                    @error('address')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- category --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Category</label>
                                    <select name="category_id" class="form-control" id="">
                                        @foreach ($categories as $category)
                                            <option @selected($company->category_id) value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- image --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" placeholder="Company image">
                                    @error('image')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- description --}}
                            <div class="mb-3 col-12">
                                <label for="description">Description</label>
                                <textarea name="description" class="@error('description') is-invalid @enderror" id="my-desc">{{ old('description', $company->description) }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
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

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js" referrerpolicy="no-referrer"></script>

    <script>
        tinymce.init({
            selector: '#my-desc'
        });
    </script>
@stop
