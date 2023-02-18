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


@else
<section id="services" class="text-center bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="intro">
                    <h6>Need This?</h6>
                    <h1>Apply To Our Company</h1>
                </div>
            </div>
            <div class="col-md-8" id="main_content">

                    @if ($ap)
                        <p>Your application under review, we will send a message when we approved it</p>
                        {{-- <form action="{{ route('student.company_cancel', $ap->id) }}" id="cancel_form" method="POST"> --}}
                            {{-- @csrf --}}
                            {{-- @method('delete') --}}

                            <a href="{{ route('student.company_cancel', $ap->id) }}" class="btn btn-brand" id="cancle_btn">Cancel Request</a>
                        {{-- </form> --}}
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
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-6">
                                    <div class="mb-3">
                                        <label for="">Email</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-12">
                                    <div class="mb-3">
                                        <label for="">Reason</label>
                                        <textarea name="reason" required class="form-control @error('reason') is-invalid @enderror" rows="5"></textarea>
                                        @error('reason')
                                            <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="text-end apply-div">
                                <button type="button" class="btn px-5 btn-brand" id="apply_btn">Apply</button>

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
            let url = applay_form.attr("action");
            $.ajax({
                url: url,
                type: "GET",
                data: applay_form.serialize(),
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data.content);


                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        iconColor: '#90da98',
                        customClass: {
                            popup: 'colored-toast'
                        },
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })
                        Toast.fire({
                        icon: 'success',
                        title: '<p style="color: #000; margin:0">Your edit has been saved</p>'
                        })
                },
                error: function(data) {
                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {
                        $("textarea").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })
        })

        // sending another ajax for cancel the request
        // $(wrapper).on("click", '#cancle_btn', function() {
        //     // console.log('test');
        //     let cancel_form = $("#cancel_form");
        //     let url = cancel_form.attr('action');
        //     cancel_form.onsubmit = (e)=> {
        //         e.preventDefault();
        //     }
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Your Request to join this course will be deleted",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#d33',
        //         cancelButtonColor: '#000',
        //         confirmButtonText: 'Yes, cancel it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: 'delete',
        //                 data: cancel_form.serialize(),
        //                 url: url,
        //                 success: function(res) {
        //                     console.log(applay_form);
        //                     // wrapper.empty();
        //                     wrapper.append(applay_form);
        //                 }

        //             })

        //             const Toast = Swal.mixin({
        //                 toast: true,
        //                 position: 'top',
        //                 showConfirmButton: false,
        //                 timer: 2000,
        //                 timerProgressBar: false,
        //                 didOpen: (toast) => {
        //                     toast.addEventListener('mouseenter', Swal.stopTimer)
        //                     toast.addEventListener('mouseleave', Swal.resumeTimer)
        //                 }
        //             })

        //             Toast.fire({
        //                 icon: 'warning',
        //                 title: 'Request Canceld Successfully'
        //             })
        //         }
        //     })
        // })






    </script>


@stop
