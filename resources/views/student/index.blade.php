@extends('student.master')

@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('studentAssets/css/owl.carousel.min.css') }}">


@stop
@section('content')
    {{-- @dump(Auth::guard()) --}}
    <!-- SLIDER -->
    <div class="owl-carousel owl-theme hero-slider">
        @forelse ($adverts as $advert)
            <div class="slide slide1"
                style="background:linear-gradient(-90deg, rgb(8 32 50 / 60%), rgba(8, 32, 50, 0.642)), url({{ asset($advert->image) }}), #082032;  background-size: cover;
                background-position: center;
                background-repeat: no-repeat;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mx-auto text-center text-white advert-box">
                            <h6 class="text-white text-uppercase"
                                style="font-size: 28px !important; width: 75%; margin: auto;">{{ $advert->main_title }}</h6>
                            <h1 class="display-3 my-4 sub-title"
                                style="font-size: 17px !important; line-height: 2 ;width: 80%; margin: auto;">
                                {{ $advert->sub_title }}</h1>
                            @if ($advert->company_id)
                                <p style=" text-decoration: underline"><b>{{ $advert->company->name }}</b></p>
                            @elseif($advert->teacher_id)
                                <p style=" text-decoration: underline"><b>{{ $advert->teacher->name }}</b></p>
                            @else
                                <p style=" text-decoration: underline"><b>{{ $advert->trainer->name }}</b></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="slide slide1"
                style="background:linear-gradient(-90deg, rgba(8, 32, 50, 0.8), rgba(8, 32, 50, 0.8)), url({{ asset('studentAssets/img/advert/default.jpg') }}), #082032;  background-size: cover;
            background-position: center;
            background-repeat: no-repeat;">
                <div class="container">

                </div>
            </div>
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

                                    @forelse ($tasks as $task)
                                        @if (now() >= $task->start_date && now() <= $task->end_date)
                                            <a href="{{ route('student.task', [$task->slug]) }}" style="font-weight: unset"
                                                class="task-box">
                                                <div class="task high">
                                                    <div class="desc">
                                                        <div class="title"><b>{{ $task->main_title }}</b></div>
                                                        <div>
                                                            <p>{{ Str::words(strip_tags(html_entity_decode($task->sub_title)), 6, '...') }}
                                                            </p>
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
                                        @else
                                            <div class="text-center"><img src="{{ asset('studentAssets/img/no-task.webp') }}" alt="" class="img-responsive empty-task">
                                            <h5>{{ __('admin.There is no tasks to show') }}</h5></div>
                                        @endif
                                    @empty
                                            <div class="text-center"><img src="{{ asset('studentAssets/img/no-task.webp') }}" alt="" class="img-responsive empty-task">
                                            <h5>{{ __('admin.There is no tasks yet!') }}</h5></div>

                                    @endforelse
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
                            <p class="mx-auto">{{ __('admin.Check out the different companies and check out their internship opportunities.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($companies as $company)
                        @php
                            $category = $company->categories->first();
                        @endphp
                        <div class="col-md-6 col-lg-4">
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
    <script>
        let next = "{{ __('admin.NEXT') }}";
        let prev = "{{ __('admin.PREV') }}";
    </script>
@stop
