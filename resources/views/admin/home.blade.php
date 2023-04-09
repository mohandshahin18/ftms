@extends('admin.master')

@section('title', __('admin.Home'))
@section('home-menu-open', 'menu-open')
@section('home-active', 'active')

@section('styles')
    @if (app()->getLocale() == 'ar')
        <style>
            .card-title {
                display: inline-block !important
            }
        </style>
    @endif
    <style>
      @media (min-width: 991px) {
        .no-adverts-vector {
          width: 350px;
        }
      }
    </style>
@stop

@section('content')
    @if (session('login'))
        <div class="alert alert-{{ session('login_type') }}">
            {{ session('login') }}
            @if (app()->getLocale() == 'ar')
                <img src="{{ asset('adminAssets/dist/img/header/wave-ar.png') }}" width="20" alt="">
            @else
                <img src="{{ asset('adminAssets/dist/img/header/wave.png') }}" width="20" alt="">
            @endif
        </div>
    @endif

    @if (session('verify'))
        <div class="alert alert-{{ session('verify_type') }}">
            {{ session('verify') }}

        </div>
    @endif

      <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $students }}</h3>

                    <p>{{ __('admin.Students Number') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.students.index') }}" class="small-box-footer">
                    {{ __('admin.More info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @if(Auth::guard('admin')->check())
            <div class="col-lg-3 col-6">
                <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $companies }}</h3>

                    <p>{{ __('admin.Companies Number') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('admin.companies.index') }}" class="small-box-footer">{{ __('admin.More info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $specializations }}</h3>

                    <p>{{ __('admin.Specializations Number') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="{{ route('admin.specializations.index') }}" class="small-box-footer"> {{ __('admin.More info') }}
                    <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $categories }}</h3>

                    <p>{{ __('admin.Categories Number') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="small-box-footer">{{ __('admin.More info') }} <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            @else
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $adverts }}</h3>

                    <p>{{ __('admin.Adverts Number') }}</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-ad"></i>
                  </div>
                  <a href="{{ route('admin.adverts.index') }}" class="small-box-footer">{{ __('admin.More info') }} <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endif
      </div>

      @if(!Auth::guard('admin')->check())
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title" @if(app()->getLocale()=='en') style="float: left !important"  @endif @if(app()->getLocale()=='ar') style="display: inline-block !important" @endif >{{ __('admin.Last Advert') }}</h3>

                        <div class="card-tools" @if(app()->getLocale()=='ar') style="float: left !important;" @endif>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>

                        </div>
                        </div>
                        @if ($lastAdvert)
                        <div class="card-body" style="display: block;">
                                 {{$lastAdvert->sub_title }}
                        </div>
                        @else
                        <div class="text-center card-body" style="display: block;">
                            <img src="{{ asset('adminAssets/dist/img/no-adverts.webp') }}" class="img-responsive no-adverts-vector" alt="">
                            <h6 class="text-center">{{ __('admin.There is no adverts yet') }}</h6>
                        </div>
                      @endif
                        <!-- /.card-body -->

                    </div>
                </div>
        </div>

      @endif

@stop

@section('scripts')

    <script></script>
@stop
