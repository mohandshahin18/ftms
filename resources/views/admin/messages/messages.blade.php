@extends('admin.master')

@section('title', __('admin.Messages'))
    
@section('content')
@php
    use App\Models\Company;
    use App\Models\Teacher;
@endphp


    <section class="section-50" style="position: relative;">
        <h3 class="m-b-50 heading-line">{{ __('admin.Messages') }} <i class="fas fa-comment-dots text-muted"></i></h3>

        @if (Auth::guard('company')->check() || Auth::guard('teacher')->check())
            <h3 class="m-3">{{ __('admin.Admins') }}</h3>
            <div class="admins-wrapper m-3">

            </div>
        @elseif (Auth::guard('admin')->check())
            <h3 class="m-3">{{ __('admin.Companies') }}</h3>
            <div class="companies-wrapper m-3">

            </div>

            @php
                $companies = Company::all();
            @endphp
            @if ($companies->count() > 2)
                <div class="text-center mt-3" id="load_more_com_div">
                    <button class="btn btn-primary" id="load_more_companies" data-page="1">{{ __('admin.Load More') }}</button>
                </div>
            @endif
            
        @endif
        

        <div class="notification-ui_dd-content mt-5 m-3">
            @if (!Auth::guard('admin')->check())
                <h3>{{ __('admin.Students') }}</h3>
                <div class="search-box mb-4">
                    <form action="">
                        @csrf
                        <label for="">
                            search here
                            <input type="text" class="form-control" name="students_search" placeholder="Student name or ID"
                                id="search_students_messages" autocomplete="off">
                        </label>
                    </form>
                </div>

                <div class="students-wrapper">

                </div>
            @else
                <h3>{{ __('admin.Teachers') }}</h3>
                <div class="teachers-wrapper">

                </div>

                @php
                $teachers = Teacher::all();
            @endphp
            @if ($teachers->count() > 2)
                <div class="text-center mt-3" id="load_more_tea_div">
                    <button class="btn btn-primary" id="load_more_teachers" data-page="1">{{ __('admin.Load More') }}</button>
                </div>
            @endif
            @endif

        </div>


       @if (!Auth::guard('admin')->check())
            @if ($auth->students()->count() > 6)
                <div class="text-center" id="load_more_stu_div">
                    <button id="load_more_students" class="btn btn-brand">Load more students</button>
                </div>
            @endif
       @endif
                
    </section>


@stop

@section('scripts')
    @if (!Auth::guard('admin')->check())
        <script>
            var allMsgsRequest = "{{ route('admin.all.messages.request') }}";
            var allAdminsMsgs = "{{ route('admin.all.admins.messages') }}";
            var searchMsgsUrl = "{{ route('admin.search.students.messages') }}";

            const getAllStudentsMsgs = function() {
                $.ajax({
                    type: "get",
                    url: allMsgsRequest,
                    beforeSend:function() {
                        $(".students-wrapper").append('<div class="spinner-div d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; position:absolute; top: 0; right: 0; z-index: 5455; background: #fff; font-size: 24px;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px;"></i>Loading...</div>');
                    },
                    success: function(response) {
                        $(".students-wrapper").empty();
                        $(".students-wrapper").append(response);

                    }
                });
            };

            const getAllAdminsMsgs = function() {
                $.ajax({
                    type: "get",
                    url: allAdminsMsgs,
                    success: function(response) {
                        $(".admins-wrapper").empty();
                        $(".admins-wrapper").append(response);

                    }
                });
            };

            // display all messages on load 
            $(document).ready(function() {
                getAllStudentsMsgs();
                getAllAdminsMsgs();
            });

            // search ajax
            var searchMsgsInput = $("#search_students_messages");

            searchMsgsInput.on("keyup", function() {
                var value = $(this).val();
                if (value == 0) {
                    getAllStudentsMsgs();
                } else {
                    $.ajax({
                        type: "get",
                        url: searchMsgsUrl,
                        data: {
                            value: value
                        },
                        success: function(response) {
                            $(".students-wrapper").empty();
                            $(".students-wrapper").append(response);
                        }
                    });
                }
            })
        </script>
    @else
    <script>
        // Urls
        var allComapniesMsgs = "{{ route('admin.all.companeis.messages') }}";
        var allTeachersMsgs = "{{ route('admin.all.teachers.messages') }}";
        var loadMoreCompaniesUrl = "{{ route('admin.load.more.companies') }}";
        var loadMoreTeachersUrl = "{{ route('admin.load.more.teachers') }}";

        // wrappers
        var companiesWrapper = $(".companies-wrapper");
        var teachersWrapper = $(".teachers-wrapper");
        var studentsWrapper = $(".students-wrapper");

        // get messages requests
        const getAllCompaniesMsgs = function() {
            $.ajax({
                type: "get",
                url: allComapniesMsgs,
                beforeSend:function() {
                    companiesWrapper.append('<div class="spinner-div d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; position:absolute; top: 0; right: 0; z-index: 5455; background: #fff; font-size: 24px;"><i class="fa fa-spin fa-spinner" style="margin-right: 5px;"></i>Loading...</div>');
                },
                success:function(response) {
                    companiesWrapper.empty();
                    companiesWrapper.append(response);
                }
            });
        }

        const getAllTeachersMsgs = function() {
            $.ajax({
                type: "get",
                url: allTeachersMsgs,
                success:function(response) {
                    teachersWrapper.empty();
                    teachersWrapper.append(response);
                }
            });
        }

        $(document).ready(function() {
            getAllCompaniesMsgs();
            getAllTeachersMsgs();
        })


        // load more companies
        $(document).on("click", "#load_more_companies", function() {
            var page = $(this).data("page");
            var loadMoreComDiv = $("#load_more_com_div");
            $.ajax({
                type: "get",
                url: loadMoreCompaniesUrl,
                data: {page: page},
                beforeSend:function() {
                    loadMoreComDiv.html('<i class="fa fa-spin fa-spinner"></i> {{ __("admin.Loading...") }}');
                },
                success:function(response) {
                    if(response.length > 0) {
                        companiesWrapper.append(response);
                        page++;
                        btn = `<button class="btn btn-primary" id="load_more_companies" data-page="${page}">{{ __('admin.Load More') }}</button>`;
                        loadMoreComDiv.empty();
                        loadMoreComDiv.append(btn);
                    } else {
                        loadMoreComDiv.empty();
                        loadMoreComDiv.html('<span style="color = #1a2e44">{{ __("admin.There is no more to load.") }}</span>');
                    }
                }

            })
        })
        // load more teachers
        $(document).on("click", "#load_more_teachers", function() {
            var page = $(this).data("page");
            var loadMoreTeaDiv = $("#load_more_tea_div");
            $.ajax({
                type: "get",
                url: loadMoreTeaDiv,
                data: {page: page},
                beforeSend:function() {
                    loadMoreTeaDiv.html('<i class="fa fa-spin fa-spinner"></i> {{ __("admin.Loading...") }}');
                },
                success:function(response) {
                    if(response.length > 0) {
                        teachersWrapper.append(response);
                        page++;
                        btn = `<button class="btn btn-primary" id="load_more_teachers" data-page="${page}">{{ __('admin.Load More') }}</button>`;
                        loadMoreTeaDiv.empty();
                        loadMoreTeaDiv.append(btn);
                    } else {
                        loadMoreTeaDiv.empty();
                        loadMoreTeaDiv.html('<span style="color = #1a2e44">{{ __("admin.There is no more to load.") }}</span>');
                    }
                }

            })
        })
        // load more students
        $(document).on("click", "#load_more_students", function() {
            var page = $(this).data("page");
            var loadMoreStuDiv = $("#load_more_stu_div");
            $.ajax({
                type: "get",
                url: loadMoreTeaDiv,
                data: {page: page},
                beforeSend:function() {
                    loadMoreTeaDiv.html('<i class="fa fa-spin fa-spinner"></i> {{ __("admin.Loading...") }}');
                },
                success:function(response) {
                    if(response.length > 0) {
                        studentsWrapper.append(response);
                        page++;
                        btn = `<button class="btn btn-primary" id="load_more_students" data-page="${page}">{{ __('admin.Load More') }}</button>`;
                        loadMoreStuDiv.empty();
                        loadMoreStuDiv.append(btn);
                    } else {
                        loadMoreStuDiv.empty();
                        loadMoreStuDiv.html('<span style="color = #1a2e44">{{ __("admin.There is no more to load.") }}</span>');
                    }
                }

            })
        })
    </script>
    @endif
@endsection
