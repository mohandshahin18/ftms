@extends('admin.master')

@section('title', Auth::guard()->user()->name)
@section('sub-title', __('admin.Profile'))

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #333;
        }

        .info-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #ccc;
            border-radius: 50%;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            line-height: 16px;
            cursor: pointer;
            margin-left: 5px;
        }

        .status-main {
            position: relative;
        }

        .tooltip {
            display: block;
            /* display: none; */
            position: absolute;
            z-index: 1;
            background-color: #000;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px;
            font-size: 14px;
            width: 300px;
            text-align: left;
        }

        .tooltip::after {
            content: "";
            position: absolute;
            bottom: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent #fff transparent;
        }
    </style>
@endsection

@section('content')
    <div class="box-all  ">
        <form action="{{ route('admin.profile_edit', Auth::guard()->user()->id) }}" method="POST"
            enctype="multipart/form-data" class="update_form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="info bg-white shadow  mr-3">
                        <div class="d-flex flex-column align-items-center text-center p-2 py-2">


                            @php

                                if (Auth::guard()->user()->image) {
                                    $img = Auth::guard()->user()->image;
                                    $src = asset($img);
                                } else {
                                    $src = asset('adminAssets/dist/img/no-image.png');
                                }

                            @endphp


                            {{-- <label for="img">Image</label>
                            <input type="file" name="image" id="img"> --}}

                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_user_avatar_3">
                                <div class="kt-avatar__holder" style="background-image: url({{ $src }})"></div>
                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="Change avatar">
                                    <i class="fas fa-pen"></i>
                                    <input type="file" class="img" name="image" id="image">
                                </label>
                            </div>



                            <span class="font-weight-bold mt-3" id="name">{{ Auth::guard()->user()->name }}</span>
                            <span class="text-black-50 mb-3" id="email">{{ Auth::guard()->user()->email }}</span><span>
                            </span>

                            @if (Auth::guard('company')->check())
                                <span class="text-black-50 mb-3">{{ __('admin.Students Number') }}: <b
                                        class="text-dark">{{ $company->students->count() }}</b></span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class=" col-md-8  ">
                    <div class="p-3 bg-white shadow  mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <label class="labels">{{ __('admin.Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ __('admin.Name') }}" value="{{ Auth::guard()->user()->name }}">
                                @error('name')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="labels">{{ __('admin.Email') }}</label>
                                <input type="text" name="email"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ Auth::guard()->user()->email }}" placeholder="{{ __('admin.Email') }}">
                                @error('name')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="labels">{{ __('admin.Phone') }}</label>
                                <input type="text" name="phone"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ __('admin.Phone') }}" value="{{ Auth::guard()->user()->phone }}">
                                @error('name')
                                    <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                            </div>


                            @if (Auth::guard('teacher')->check())

                                <div class="col-md-6 mb-3">
                                    <label class="labels">{{ __('admin.University') }}</label>
                                    <input type="text" name="" class="form-control " disabled
                                        value="{{ $university }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="labels">{{ __('admin.Specialization') }}</label>
                                    <select name="specialization_id" class="form-control" id="specialization_id">
                                        @foreach ($specializations as $specialization)
                                            <option @selected(Auth::user()->specialization_id == $specialization->id) value="{{ $specialization->id }}">
                                                {{ $specialization->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            @endif
                            @if (Auth::guard('trainer')->check())
                                <div class="col-md-6 mb-3">
                                    <label class="labels">{{ __('admin.Company') }}Company</label>
                                    <input type="text" name="" class="form-control " disabled name=""
                                        value="{{ $company }}">
                                </div>

                                {{-- Program --}}
                                <div class="col-md-6 mb-3">
                                    <label class="labels">{{ __('admin.Program') }}</label>
                                    <select name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option @selected(Auth::user()->category_id == $category->id) value="{{ $category->id }}">
                                                {{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                            @endif

                            @if (Auth::guard('company')->check())

                                <div class="col-md-6 mb-3">
                                    <label class="labels">{{ __('admin.Location') }}</label>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="{{ __('admin.Location') }}"
                                        value="{{ Auth::guard()->user()->address }}">
                                    @error('address')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label class="mb-2">{{ __('admin.Programs') }}</label>
                                    <select name="category_id[]" class="form-control select2" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @foreach ($attached_categories as $key => $value)
                                                {{ $category->id == $value ? 'selected' : '' }} @endforeach>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-6 mb-3 status-main">
                                    <label class="labels">{{ __('admin.Status') }}</label>
                                    <i class="fas fa-info info-icon" data-toggle="tooltip" data-placement="top"
                                        title="Tooltip on top"></i>
                                    <select name="status" class="form-control">
                                        <option @selected(Auth::guard()->user()->status == 1) value="1"> {{ __('admin.Avilable') }}
                                        </option>
                                        <option @selected(Auth::guard()->user()->status == 0) value="0"> {{ __('admin.Unavilable') }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description"> {{ __('admin.Description') }}</label>
                                    <textarea name="description" class="@error('description') is-invalid @enderror" id="content">{{ old('description', Auth::guard()->user()->description) }}</textarea>
                                    @error('description')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                </div>



                            @endif

                        </div>


<<<<<<< HEAD
                    <div class="mt-2 wrapper-btn d-flex justify-content-end">
                        <button class="btn btn-primary btn-flat profile-button" type="button">{{ __('admin.Save Edit') }}  </button>
=======
                        <div class="mt-2 wrapper-btn d-flex justify-content-end">
                            <button class="btn btn-primary profile-button" type="submit">{{ __('admin.Save Edit') }}
                            </button>
                        </div>
>>>>>>> ffba2a3f73de12563e2ba2050e91dfb92cf0c246
                    </div>
                </div>
            </div>
        </form>
    </div>

@stop



@section('scripts')

    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>tinymce.init({selector:'textarea'});</script> --}}

    @if (Auth::guard('company')->check())
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


        <script>
            $(document).ready(function() {
                $('.select2').select2();
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            });

            var infoIcon = document.querySelector('.info-icon');
            var tooltip = document.querySelector('.tooltip');

            infoIcon.addEventListener('mouseenter', function() {
                tooltip.style.display = 'block';
            });

            infoIcon.addEventListener('mouseleave', function() {
                tooltip.style.display = 'none';
            });
        </script>
    @endif


    {{-- AJAX Reauest --}}
    <script>
        let authEmail = '{{ Auth::user()->email }}';
        let form = $(".update_form")[0];

        let btn = $(".profile-button");
        let wrapper = $(".wrapper-btn");
        let image;
        form.onsubmit = (e) => {
            e.preventDefault();
        }

        $(".img").on("change", function(e) {
            image = e.target.files[0];
        });


        @if (Auth::guard('company')->check())
            tinymce.init({
                selector: '#content',
                init_instance_callback: function(editor) {
                    var content = editor.getContent();
                    window.myEditorInstance = editor;
                }

            });
        @endif
        btn.on("click", function() {
            btn.attr('disabled', true);

            let formData = new FormData(form);
            formData.append('image', image);

            @if (Auth::guard('company')->check())
                var content = window.myEditorInstance.getContent();
                formData.append('description', content);
            @endif

            let url = form.getAttribute("action");
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function(data) {
                    btn.html('<i class="fa fa-spin fa-spinner "></i>');
                    $('.invalid-feedback').remove();
                    $('input').removeClass('is-invalid');

                },
                success: function(data) {

                    if (data.email != authEmail) {

                        btn.html('<i class="fas fa-check"></i>');
                        toastr.warning('{{ __('admin.Email must be confirmed') }}');


                        setTimeout(() => {

                            Swal.fire({
                                text: '{{ __('admin.We have sent you an activation code to your email, please check your email.') }}',
                                icon: 'warning',
                                confirmButtonText: '{{ __('admin.OK') }}'
                            });
                        }, 2000);

                        setTimeout(() => {
                            btn.removeAttr("disabled");
                            btn.html('{{ __('admin.Save Edit') }}');
                        }, 2000);

                    } else {

                        setTimeout(() => {
                            btn.html('<i class="fas fa-check"></i>');
                            toastr.success('{{ __('admin.Profile Updated successfully') }}');

                        }, 2000);

                        setTimeout(() => {
                            btn.removeAttr("disabled");
                            btn.html('{{ __('admin.Save Edit') }}');
                        }, 3500);

                        $("#name").empty();
                        $("#name").append(data.name);
                        $("#dropdown_name").empty();
                        $("#dropdown_name").append(data.name);
                        $("#email").empty();
                        $("#email").append(data.email);
                        if (data.image) {
                            $("#nav_img").attr("src", host + "/" + data.image);
                            $("#dropdown_image").css({
                                'background-image': 'url(' + host + '/' + data.image + ')'
                            });

                        }
                        Toast.fire({
                            icon: 'success',
                            title: '{{ __('admin.Profile Updated successfully') }}'
                        })

                    }
                },
                error: function(data) {
                    btn.attr("disabled", false)
                    btn.html('{{ __('admin.Save Edit') }}');
                    $('.invalid-feedback').remove();

                    $.each(data.responseJSON.errors, function(field, error) {
                        if (field == 'description') {
                            $("textarea").addClass('is-invalid').after(
                                '<small class="invalid-feedback">' + error + '</small>');
                        } else {
                            $("input[name='" + field + "']").addClass('is-invalid').after(
                                '<small class="invalid-feedback">' + error + '</small>');
                        }
                        //
                    });

                    $.each(data.responseJSON, function(field, error) {
                    $("input[name='" + field + "']").addClass('is-invalid').after(
                        '<small class="invalid-feedback">' + error + '</small>');
                });
                },
            })
        })
    </script>


    <script src="{{ asset('studentAssets/js/profile.js') }}"></script>

@stop
