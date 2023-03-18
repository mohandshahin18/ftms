@extends('admin.master')

@section('title', __('admin.Messages'))

@section('content')



    <section class="section-50">
        <h3 class="m-b-50 heading-line">{{ __('admin.Messages') }} <i class="fas fa-comment-dots text-muted"></i></h3>

        <h3 class="m-3">{{ __('admin.Admins') }}</h3>
        <div class="admins-wrapper m-3">

        </div>

        <div class="notification-ui_dd-content mt-5 m-3">
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

        </div>


        @if ($auth->students()->count() > 6)
            <div class="text-center">
                <button type="button" class="btn-brand">Load more students</button>
            </div>
        @endif

    </section>


@stop

@section('scripts')
    <script>
        var allMsgsRequest = "{{ route('admin.all.messages.request') }}";
        var allAdminsMsgs = "{{ route('admin.all.admins.messages') }}";
        var searchMsgsUrl = "{{ route('admin.search.students.messages') }}";

        const getAllStudentsMsgs = function() {
            $.ajax({
                type: "get",
                url: allMsgsRequest,
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
@endsection
