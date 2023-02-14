@extends('student.master')

@section('title', $company->name)

@section('styles')
    <style>
        iframe {
            width: 100%;
        }

        .colored-toast.swal2-icon-success {
            background-color: #3fcf57 !important;
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
                        <form action="{{ route('student.company_cancel', $ap->id) }}" id="cancel_form" method="POST">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-brand" id="cancle_btn">Cancel Request</button>
                        </form>
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

@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>

    <script>
        let applay_form = $(".apply_form");
        let applay_btn = $("#apply_btn");
        let wrapper = $("#main_content");

        applay_form.onsubmit = (e) => {
            e.preventDefault();
        }

        applay_btn.on("click", function() {
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
                        iconColor: 'white',
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
                        title: '<span style="color: #fff !important">Applied to Course successfully</span>',
                        })
                }
            })
        })

        let cancel_form = $("#cancel_form");
        let cancel_btn = $("#cancle_btn");

        cancel_form.onsubmit = (e)=> {
            e.preventDefault();
        }

        cancel_btn.on("click", function() {
            let url = cancel_form.attr('action');
            Swal.fire({
                title: 'Are you sure?',
                text: "Your Request to join this course will be deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#000',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // send ajax request and delete post
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: cancel_form.serialize(),
                        success: function(res) {
                            wrapper.empty();
                            wrapper.append(applay_form);
                        }

                    })

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'warning',
                        title: 'Request Canceld Successfully'
                    })
                }
            })
        })
    </script>


@stop
