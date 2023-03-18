@extends('student.master')

@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('studentAssets/css/owl.carousel.min.css') }}">

    <style>
        .page-todo .tasks {
            background: #fff;
            padding: 0;
            margin: -30px 15px -30px -15px
        }

        .page-todo .task-list {
            padding: 30px 15px;
            height: 100%
        }

        .page-todo .graph {
            height: 100%
        }

        .page-todo .priority.high {
            background: #fffdfd;
            margin-bottom: 1px
        }

        .page-todo .priority.high span {
            background: #f86c6b;
            padding: 2px 10px;
            color: #fff;
            display: inline-block;
            font-size: 12px
        }

        .page-todo .task {
            border-bottom: 1px solid #e4e5e6;
            margin-bottom: 1px;
            position: relative
        }

        .page-todo .task .desc {
            display: inline-block;
            width: 75%;
            padding: 10px 10px;
            font-size: 12px
        }

        .page-todo .task .desc .title {
            font-size: 18px;
            margin-bottom: 5px
        }

        .page-todo .task .time {
            display: inline-block;
            width: 20%;
            padding: 10px 10px 10px 0;
            font-size: 12px;
            text-align: right;
            position: absolute;
            top: 0;
            right: 0
        }

        .page-todo .task .time .date {
            font-size: 18px;
            margin-bottom: 5px
        }

        .page-todo .task.last {
            border-bottom: 1px solid transparent
        }

        .page-todo .task.high {
            border-left: 2px solid #f86c6b;
            box-shadow: 0 3px 10px rgb(0 0 0 / 6%);
        }


        .page-todo .timeline {
            width: auto;
            height: 100%;
            margin: 20px auto;
            position: relative
        }

        .page-todo .timeline:before {
            position: absolute;
            content: '';
            height: 100%;
            width: 4px;
            background: #d1d4d7;
            left: 50%;
            margin-left: -2px
        }

        .page-todo .timeslot {
            display: inline-block;
            position: relative;
            width: 100%;
            margin: 5px 0
        }

        .page-todo .timeslot .task {
            position: relative;
            width: 44%;
            display: block;
            border: none;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box
        }

        .page-todo .timeslot .task span {
            border: 2px solid #63c2de;
            background: #e1f3f9;
            padding: 5px;
            display: block;
            font-size: 11px
        }

        .page-todo .timeslot .task span span.details {
            font-size: 16px;
            margin-bottom: 10px
        }

        .page-todo .timeslot .task span span.remaining {
            font-size: 14px
        }

        .page-todo .timeslot .task span span {
            border: 0;
            background: 0 0;
            padding: 0
        }

        .page-todo .timeslot .task .arrow {
            position: absolute;
            top: 6px;
            right: 0;
            height: 20px;
            width: 20px;
            border-left: 12px solid #63c2de;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            margin-right: -18px
        }

        .page-todo .timeslot .task .arrow:after {
            position: absolute;
            content: '';
            top: -12px;
            right: 3px;
            height: 20px;
            width: 20px;
            border-left: 12px solid #e1f3f9;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent
        }

        .page-todo .timeslot .icon {
            position: absolute;
            border: 2px solid #d1d4d7;
            background: #2a2c36;
            -webkit-border-radius: 50em;
            -moz-border-radius: 50em;
            border-radius: 50em;
            height: 30px;
            width: 30px;
            top: 0;
            left: 50%;
            margin-left: -17px;
            color: #fff;
            font-size: 14px;
            line-height: 30px;
            text-align: center;
            text-shadow: none;
            z-index: 2;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box
        }

        .page-todo .timeslot .time {
            background: #d1d4d7;
            position: absolute;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            top: 1px;
            left: 50%;
            padding: 5px 10px 5px 40px;
            z-index: 1;
            margin-top: 1px
        }

        .page-todo .timeslot.alt .task {
            margin-left: 56%;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box
        }

        .page-todo .timeslot.alt .task .arrow {
            position: absolute;
            top: 6px;
            left: 0;
            height: 20px;
            width: 20px;
            border-left: none;
            border-right: 12px solid #63c2de;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            margin-left: -18px
        }

        .page-todo .timeslot.alt .task .arrow:after {
            top: -12px;
            left: 3px;
            height: 20px;
            width: 20px;
            border-left: none;
            border-right: 12px solid #e1f3f9;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent
        }

        .page-todo .timeslot.alt .time {
            top: 1px;
            left: auto;
            right: 50%;
            padding: 5px 40px 5px 10px
        }

        @media only screen and (min-width:992px) and (max-width:1199px) {
            .page-todo task .desc {
                display: inline-block;
                width: 70%;
                padding: 10px 10px;
                font-size: 12px
            }

            .page-todo task .desc .title {
                font-size: 16px;
                margin-bottom: 5px
            }

            .page-todo task .time {
                display: inline-block;
                float: right;
                width: 20%;
                padding: 10px 10px;
                font-size: 12px;
                text-align: right
            }

            .page-todo task .time .date {
                font-size: 16px;
                margin-bottom: 5px
            }
        }

        @media only screen and (min-width:768px) and (max-width:991px) {
            .page-todo .task {
                margin-bottom: 1px
            }

            .page-todo .task .desc {
                display: inline-block;
                width: 65%;
                padding: 10px 10px;
                font-size: 10px;
                margin-right: -20px
            }

            .page-todo .task .desc .title {
                font-size: 14px;
                margin-bottom: 5px
            }

            .page-todo .task .time {
                display: inline-block;
                float: right;
                width: 25%;
                padding: 10px 10px;
                font-size: 10px;
                text-align: right
            }

            .page-todo .task .time .date {
                font-size: 14px;
                margin-bottom: 5px
            }

            .page-todo .timeslot .task span {
                padding: 5px;
                display: block;
                font-size: 10px
            }

            .page-todo .timeslot .task span span {
                border: 0;
                background: 0 0;
                padding: 0
            }

            .page-todo .timeslot .task span span.details {
                font-size: 14px;
                margin-bottom: 0
            }

            .page-todo .timeslot .task span span.remaining {
                font-size: 12px
            }
        }

        @media only screen and (max-width:767px) {
            .page-todo .tasks {
                position: relative;
                margin: 0 !important
            }

            .page-todo .graph {
                position: relative;
                margin: 0 !important
            }

            .page-todo .task {
                margin-bottom: 1px
            }

            .page-todo .task .desc {
                display: inline-block;
                width: 65%;
                padding: 10px 10px;
                font-size: 10px;
                margin-right: -20px
            }

            .page-todo .task .desc .title {
                font-size: 14px;
                margin-bottom: 5px
            }

            .page-todo .task .time {
                display: inline-block;
                float: right;
                width: 25%;
                padding: 10px 10px;
                font-size: 10px;
                text-align: right
            }

            .page-todo .task .time .date {
                font-size: 14px;
                margin-bottom: 5px
            }

            .page-todo .timeslot .task span {
                padding: 5px;
                display: block;
                font-size: 10px
            }

            .page-todo .timeslot .task span span {
                border: 0;
                background: 0 0;
                padding: 0
            }

            .page-todo .timeslot .task span span.details {
                font-size: 14px;
                margin-bottom: 0
            }

            .page-todo .timeslot .task span span.remaining {
                font-size: 12px
            }
        }
    </style>

@stop
@section('content')
    {{-- @dump(Auth::guard()) --}}
    <!-- SLIDER -->
    <div class="owl-carousel owl-theme hero-slider">
        @forelse ($adverts as $advert)
            <div class="slide slide1" style="background:linear-gradient(-90deg, rgba(8, 32, 50, 0.8), rgba(8, 32, 50, 0.8)), url({{ asset($advert->image) }}), #082032;  background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center text-white">
                            <h6 class="text-white text-uppercase" style="font-size: 28px !important; width: 75%; margin: auto;">{{ $advert->main_title }}</h6>
                            <h1 class="display-3 my-4 sub-title" style="font-size: 17px !important; line-height: 2 ;width: 80%; margin: auto;">{{ $advert->sub_title }}</h1>
                            <a href="#" class="btn btn-slider">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            
        @endforelse

    </div>


    @if (Auth::user()->company_id)
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="intro">
                            {{-- <h6>Company</h6> --}}
                            <h1>{{ __('admin.Tasks') }}</h1>

                        </div>

                        <div class="container page-todo bootstrap snippets bootdeys">
                            <div class="col-sm-12 tasks row">
                                <div class="task-list">

                                    @foreach ($tasks as $task)
                                        @if (now() >= $task->start_date && now() <= $task->end_date)
                                            <a href="{{ route('student.task', [$task->slug]) }}" style="font-weight: unset" class="task-box">
                                                <div class="task high">
                                                    <div class="desc">
                                                        <div class="title"><b>{{ $task->main_title }}</b></div>
                                                        <div>
                                                            <p>{{ $task->sub_title }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="time">
                                                        <div class="date">
                                                            {{-- @if ($task->applied_tasks->count() > 0)
                                                              <p class="done_btn">Done <i class="fas fa-check text-success"></i></p>
                                                          @else --}}
                                                            Due
                                                            {{ Carbon::parse($task->end_date)->locale(config('app.locale'))->format('j F') }}
                                                            {{-- @endif --}}
                                                        </div>
                                                        <div> {{ $task->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach


                                </div>
                            </div>
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
                            <h6>{{ __('admin.Companies') }}</h6>
                            <h1>{{ __('admin.Avilable Companies') }}</h1>
                            <p class="mx-auto">Contrary to popular belief, Lorem Ipsum is not simply random text. It has
                                roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($companies as $company)
                        @php
                            $category = $company->categories->first();
                        @endphp
                        <div class="col-md-4">
                            <article class="blog-post">
                                <img src="{{ asset($company->image) }}" alt="">

                                <span>{{ $category->name }}</span>


                                <div class="content">
                                    <h5>{{ $company->name }}</h5>
                                    <p class="mb-4">
                                        {{ Str::words(strip_tags(html_entity_decode($company->description)), 6, '...') }}
                                    </p>

                                    <a href="{{ route('student.company', [$company->slug, $category->name]) }}"
                                        class="btn-brand">{{ __('admin.Learn More') }}</a>


                                </div>
                            </article>
                        </div>
                    @endforeach
                    <div class="text-center mt-4">
                        <a href="{{ route('student.allCompanies') }}" class="btn-brand">{{ __('admin.Show More') }}</a>
                    </div>

                </div>
            </div>
        </section>

    @endif

@stop

@section('scripts')
    <script src="{{ asset('studentAssets/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('studentAssets/js/app.js') }}"></script>

@stop
