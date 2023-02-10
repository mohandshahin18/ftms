@extends('student.master')

@section('title', $company->name)

@section('styles')
    <style>
        iframe {
            width: 100%;
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
                    @php
                        foreach ($company->categories as $category) {
                            if ($program == $category->name) {
                                $ap = Auth::user()
                                    ->applications()
                                    ->where('category_id', $category->id)
                                    ->where('student_id', Auth::user()->id)
                                    ->where('company_id', $company->id)
                                    ->first();
                            }
                        }
                    @endphp

                    @if ($ap)
                        <p>Your application under review, we will send a message when we approved it</p>
                        <a href="{{ route('student.company_cancel', $ap->id) }}" class="btn btn-brand">Cancel Request</a>
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
        let form = $(".apply_form");
        let btn = $("#apply_btn");
        let wrapper = $("#main_content");

        form.onsubmit = (e) => {
            e.preventDefault();
        }

        btn.on("click", function() {
            let url = form.attr("action");
            $.ajax({
                url: url,
                type: "GET",
                data: form.serialize(),
                success: function(data) {
                    wrapper.empty();
                    $(".apply_form").css("display", "none");
                    let content = `<p>Your application under review, we will send a message when we approved it</p>
                        <a href="#" class="btn btn-brand">Cancel Request</a>`
                    wrapper.append(content);
                }
            })
        })
    </script>

    @if (session('msg'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if (session('type') == 'success')
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'danger')
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'warning')
                Toast.fire({
                    icon: 'warning',
                    title: '{{ session('msg') }}'
                })
            @else
                Toast.fire({
                    icon: 'info',
                    title: '{{ session('msg') }}'
                })
            @endif
        </script>
    @endif
@stop
