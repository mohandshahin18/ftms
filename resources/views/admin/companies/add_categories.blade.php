@extends('admin.master')

@section('title', 'Add New Company')
@section('sub-title', 'Companies')
@section('companies-menu-open', 'menu-open')
@section('companies-active', 'active')
@section('add-company-active', 'active')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .wide {
        width: 100% !important;
    }

    .select2-container--default 
    .select2-selection--multiple 
    .select2-selection__choice {
        color: #333;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Categories</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.add.categories') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        {{-- name  --}}
                        <div class="row">
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Company name</label>
                                    <input type="text" class="form-control" name="name" disabled value="{{ $company->name }}">
                                  </div>
                            </div>

                            {{-- category --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Category</label>
                                    <select name="category_id[]" class="js-example-basic-multiple wide" multiple="multiple">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    // In your Javascript (external.js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection
