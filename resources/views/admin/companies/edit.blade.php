@extends('admin.master')

@section('title', 'Edit Company')
@section('sub-title', 'Companies')
@section('companies-menu-open', 'menu-open')
@section('companies-active', 'active')
@section('index-company-active', 'active')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* .select2-container--default {
        width: 100% !important;
    } */

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

                            {{-- Program --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Program</label>
                                    <select name="category_id[]" width:560px; class="form-control select2" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }} {{ in_array($category->id, $attached_categories) ? 'selected' : '' }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6" data-select2-id="31">
                                <div class="form-group" data-select2-id="30">
                                  <label>Multiple (.select2-purple)</label>
                                  <div class="select2-purple" data-select2-id="29">
                                    <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="15" tabindex="-1" aria-hidden="true">
                                      <option data-select2-id="35">Alabama</option>
                                      <option data-select2-id="36">Alaska</option>
                                      <option data-select2-id="37">California</option>
                                      <option data-select2-id="38">Delaware</option>
                                      <option data-select2-id="39">Tennessee</option>
                                      <option data-select2-id="40">Texas</option>
                                      <option data-select2-id="41">Washington</option>
                                    </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="16" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                                        <ul class="select2-selection__rendered"><li class="select2-selection__choice" title="Alaska" data-select2-id="52"><span class="select2-selection__choice__remove" role="presentation">×</span>Alaska</li><li class="select2-selection__choice" title="California" data-select2-id="53"><span class="select2-selection__choice__remove" role="presentation">×</span>California</li><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                  </div>
                                </div>
                                <!-- /.form-group -->
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        tinymce.init({
            selector: '#my-desc'
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@stop
