@extends('student.master')

@section('title', $company->name)

@section('styles')
    <style>
        iframe {
            width: 100%;
        }

        .block {
            display: none;
        }
    </style>
@stop


@section('content')

    <section class="bg-light" id="reviews">
        <div class="container">
            <h1 class="text-white">{{ $company->name }} - {{ $program }}</h1>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="bg-light">
        <div class="container">
            <div class="row ">
                <div class="col-lg-7 ">
                    {!! $company->description !!}
                </div>
                <div class="col-lg-4">
                    <img src="{{ asset($company->image) }}" style="border-radius: 20px;" alt="">
                </div>
            </div>
        </div>
    </section>



    <section class="text-center  location">
        {!! $company->address !!}
    </section>


@if(Auth::user()->company_id)
    @if (!$evaluated)

        <section id="services" class="text-center bg-light">
            <a href="{{ route('student.evaluate.company', $company->slug) }}" class="btn btn-brand">Rate {{ $company->name }}</a>
        </section>
    @endif

@else
<section id="services" class="text-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="intro">
                    <h6>{{ __('admin.NEED THIS?') }}</h6>
                    <h1>{{ __('admin.Apply To Our Company') }}</h1>
                </div>
            </div>
            <div class="col-md-8" id="main_content">

                    @if ($ap)
                        <p>{{ __('admin.Your application under review, we will send a notification when we approved it') }}</p>

                        <a href="{{ route('student.company_cancel', $ap->id) }}" class="btn btn-brand" id="cancle_btn">{{ __('admin.Cancel Request') }}</a>

                    @else
                        <form action="{{ route('student.company_apply', $company->id) }}" class="apply_form">
                            @csrf
                            <input type="hidden" name="company_id" class="form-control" value="{{ $company->id }}"
                                readonly>

                            @foreach ($company->categories as $category)
                                @if ($program == $category->name)
                                    <input type="hidden" name="category_id" class="form-control"
                                        value="{{ $category->id }}" readonly>
                                @endif
                            @endforeach


                            <div class="row text-start wrapper-apply">

                                <div class=" col-md-6">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Name') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-6">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Email') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-12">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Reason') }}</label>
                                        <textarea name="reason" required class="form-control @error('reason') is-invalid @enderror" rows="5"></textarea>
                                        @error('reason')
                                            <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="text-end apply-div">
                                <button type="button" class="btn px-5 btn-brand" id="apply_btn">{{ __('admin.Apply') }}</button>
                            </div>


                        </form>
                    @endif
            </div>
        </div>
    </div>
</section>

@endif
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>

    <script>
        let applay_form = $("form.apply_form");
        let wrapper = $("#main_content");

        applay_form.onsubmit = (e) => {
            e.preventDefault();
        }

        $(wrapper).on("click", '#apply_btn', function() {
            $(this).attr("disabled", true)
            let url = applay_form.attr("action");
            $.ajax({
                url: url,
                type: "GET",
                data: applay_form.serialize(),
                beforeSend: function() {
                    $('.apply-div').empty();
                    $('.apply-div').html('<i class="fa fa-spin fa-spinner reload-apply"></i> {{ __("admin.Loading...") }}');
                },
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data.content);
                },
                error: function(data) {
                    // $('#apply_btn').attr("disabled", false)
                    $('.apply-div ').empty();
                    $('.apply-div ').html('<button type="button" class="btn px-5 btn-brand" id="apply_btn">{{ __('admin.Apply') }}</button>');




                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {
                        $("textarea").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })
        })

    </script>


@stop
