@extends('admin.master')

@section('title',  __('admin.Edit University') )
@section('sub-title', __('admin.Universities'))
@section('universities-active', 'active')
@section('index-university-active', 'active')

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
                    <h3 class="card-title" style="float: unset">{{ __('admin.Edit University') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.universities.update', $university->slug) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="card-body">
                        @if (session('customError'))
                        <div class="alert alert-{{ session('type') }}">
                            {{ session('customError') }}

                        </div>
                    @endif
                        <div class="row">
                            {{-- name  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.university Name') }}" value="{{ old('name', $university->name) }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- email --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Email') }}</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="{{ __('admin.Email') }}" value="{{ old('email', $university->email) }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- phone  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="{{ __('admin.Phone') }}"
                                        value="{{ old('phone', $university->phone) }}">
                                    @error('phone')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- address --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Location') }}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="{{ __('admin.Location') }}"
                                        value="{{ old('address', $university->address) }}">
                                    @error('address')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- specializations --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Program') }}</label>
                                    <select name="specialization_id[]" width:560px; class="form-control select2" multiple>
                                        @foreach ($specializations as $specialization)

                                                <option value="{{ $specialization->id }}" @foreach ($attached_specializations as $key => $value)
                                                    {{ ($specialization->id == $value) ? 'selected' : '' }}
                                                @endforeach>
                                                {{ $specialization->name }}</option>
                                            @endforeach

                                    </select>



                                </div>
                            </div>



                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark btn-flat" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fas fa-pen"></i> {{ __('admin.Update') }}</button>

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
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@stop
