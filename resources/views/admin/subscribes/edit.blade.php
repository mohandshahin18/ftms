@extends('admin.master')

@section('title',  __('admin.Edit University ID') )
@section('sub-title', __('admin.University IDs'))
@section('subscribes-active', 'active')
@section('index-subscribe-active', 'active')



@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title" style="float: unset">{{ __('admin.Edit University ID') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.subscribes.update', $subsicribe->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @if (session('exisitStudent_id'))
                        <div class="alert alert-{{ session('type') }}">
                            {{ session('exisitStudent_id') }}

                        </div>
                    @endif

                        <div class="row">
                            {{-- name  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.university Name') }}" value="{{ old('name', $subsicribe->name) }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- name  --}}
                            <div class=" col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University ID') }}</label>
                                    <input type="text" class="form-control @error('university_id_st') is-invalid @enderror"
                                        name="university_id_st" placeholder="{{ __('admin.University ID') }}" value="{{ old('student_id', $subsicribe->student_id) }}">
                                    @error('university_id_st')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>




                            {{-- specializations --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.University') }}</label>
                                    <select name="university_id" class="form-control @error('university_id') is-invalid @enderror" id="university_id">
                                        @foreach ($universities as $university)

                                                <option @if($subsicribe->university_id == $university->id) selected @endif value="{{ $university->id }}">{{ $university->name }}</option>
                                            @endforeach

                                    </select>
                                    @error('university_id')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror


                                </div>
                            </div>

                            {{-- specializations --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Program') }}</label>
                                    <select name="specialization_id" class="form-control @error('specialization_id') is-invalid @enderror" id="specialization_id">
                                        @foreach ($specializations as $specialization)

                                                <option @if($subsicribe->specialization_id == $specialization->id) selected @endif value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                                            @endforeach

                                    </select>
                                    @error('specialization_id')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror


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
    {{-- Ajax Request --}}
    <script>
        $(document).ready(function() {
            $("#university_id").on("change", function() {
                var uni_id = $(this).val();
                if (uni_id) {
                    $.ajax({
                        url: "/admin/get/specialization/" + uni_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $("#specialization_id").empty();
                            $.each(data, function(key, value) {
                                $("#specialization_id").append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        },
                    });
                }
            });
        });
    </script>
@stop

