@extends('student.master')

@section('title' , 'company')


@section('content')

<section id="services" class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="intro">
                    <h6>Our Services</h6>
                    <h1>What We Do?</h1>
                    <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                        roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon1.png') }}" alt="">
                    <h5>Digital Marketing</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon2.png') }}" alt="">
                    <h5>Logo Designing</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon3.png') }}" alt="">
                    <h5>Buisness consulting</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon4.png') }}" alt="">
                    <h5>Videography</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon5.png') }}" alt="">
                    <h5>Brand Identity</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service">
                    <img src="{{ asset('studentAssets/img/icon6.png') }}" alt="">
                    <h5>Ethical Hacking</h5>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                        classical Latin literature from</p>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
