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
@stop
{{-- @dump(app()->getLocale()) --}}

@section('scripts')

        <script>
            
        </script>
    @stop
