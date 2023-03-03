@extends('admin.master')

@section('title', 'Home')
@section('home-menu-open', 'menu-open')
@section('home-active', 'active')

@section('styles')
<style>
    .alert-warning {
        color: #7d5a29;
        background-color: #fcefdc;
        border-color: #fbe8cd;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 2px;
    }


    </style>
@stop

@section('content')
        @if (session('login'))
        <div class="alert alert-{{ session('login_type') }}">
            {{ session('login') }}
            @if( app()->getLocale() == 'ar')
            <img src="{{ asset('adminAssets/dist/img/header/wave-ar.png') }}"  width="20" alt="">
            @else
            <img src="{{ asset('adminAssets/dist/img/header/wave.png') }}"  width="20" alt="">
            @endif
        </div>
        @endif

        {{-- <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> --}}
@stop
{{-- @dump(app()->getLocale()) --}}

@section('scripts')


    @stop
