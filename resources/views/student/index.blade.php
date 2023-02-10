@extends('student.master')

@section('title' , 'Home')

@section('styles')

<style>
    .header {
        background: url({{ asset('studentAssets/img/bg_banner2.jpg') }}) ;
        }

</style>

@stop
@section('content')
{{-- @dump(Auth::guard()) --}}
    <!-- SLIDER -->
    <div class="header">
    <div class="overlay">
        <div class="slide ">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center text-white">
                        <h6 class="text-white text-uppercase">design Driven for professional</h6>
                        <h1 class="display-3 my-4">We craft digital<br />experiances</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- ABOUT -->
    <section id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 py-5">
                    <div class="row">

                        <div class="col-12">
                            <div class="info-box">
                                <img src="{{ asset('studentAssets/img/icon6.png') }}" alt="">
                                <div class="ms-4">
                                    <h5>Digital Marketing</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="info-box">
                                <img src="{{ asset('studentAssets/img/icon4.png') }}" alt="">
                                <div class="ms-4">
                                    <h5>E-mail Marketing</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="info-box">
                                <img src="{{ asset('studentAssets/img/icon5.png') }}" alt="">
                                <div class="ms-4">
                                    <h5>Buisness Marketing</h5>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <img src="{{ asset('studentAssets/img/about.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- MILESTONE -->
    <section id="milestone">
        <div class="container">
            <div class="row text-center justify-content-center gy-4">
                <div class="col-lg-2 col-sm-6">
                    <div class="counter">
                        <h1 class="display-4" data-goal="{{ $students->count() }}">0 </h1>
                    </div>
                    <p class="mb-0">Student Number</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="counter">
                        <h1 class="display-4" data-goal="{{ $company->count() }}">0</h1>
                    </div>
                    <p class="mb-0">Company Number</p>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <h1 class="display-4" data-goal="{{ $trainers->count() }}">0</h1>
                    <p class="mb-0">trainer Number</p>
                </div>

            </div>
        </div>
    </section>


    @if(Auth::user()->company_id)

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro">
                        {{-- <h6>Company</h6> --}}
                        <h1>Tasks</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @else

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="intro">
                        <h6>Company</h6>
                        <h1>Avilable Company</h1>
                        <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                            roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($companies as $company )
                    @foreach ( $company->categories as $category )
                            <div class="col-md-4">
                                <article class="blog-post">
                                    <img src="{{ asset($company->image) }}" alt="">

                                    <span>{{ $category->name  }}</span>


                                    <div class="content">
                                        <h5>{{ $company->name }}</h5>
                                        <p class="mb-4">{{ Str::words(strip_tags($company->description), 10, '...') }}</p>

                                        <a href="{{ route('student.company' ,[$company->slug , $category->name]) }}" class="btn-brand">Learn More</a>


                                    </div>
                                </article>
                            </div>
                    @endforeach
                @endforeach
                <div class="text-center mt-4">
                    <a href="{{ route('student.allCompany') }}" class="btn-brand">Show More</a>
                </div>

            </div>
        </div>
    </section>

    @endif

@stop

@section('scripts')
<script src="{{ asset('studentAssets/js/scroll-js.js') }}"></script>

@stop
