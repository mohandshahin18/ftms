@extends('student.master')

@section('title', $task->main_title)

@section('styles')
    <style>

        .task{
            background: #f8f9fa;
        }
        .divider{
            border-bottom: 1px solid #ccc;
        }
        th{
            width: 220px
        }
    </style>
@stop


@section('content')

    <section  id="reviews">
        <div class="container">
            <h1 class="text-white">{{ $task->main_title }} - {{ $task->sub_title }}</h1>
        </div>
    </section>

    <!-- ABOUT -->
    <section style="padding-top:30px ">
        <div class="container">
            <div class="row ">
                <div class="col-lg-12 ">
                    <div class="task rounded p-3">
                        <p><b>Opend: </b>{{ Carbon::parse($task->start_date)->format('l, j F Y, g:i A') }}</p>
                        <p><b>Due: </b>{{ Carbon::parse($task->end_date)->format('l, j F Y, g:i A') }}</p>

                        <div class="divider"></div>
                        <div class="desc mb-5 mt-3">
                            {!! $task->description !!}

                        </div>
                        {{-- <a href="{{ asset('files/example.pdf') }}" download>Download Example PDF</a> --}}

                        <a target="_blank" href="{{ asset('uploads/tasks-files/'.$task->file) }}" download>{{ $task->file }}</a>
                    </div>

                    <h3 class="my-4">Submission status</h3>

                    <table class="table table-striped table-bordered table-hover">

                        <tbody>
                          <tr>
                            <th >Submission status</th>
                            <td id="submitted_text">@if ($applied_task)
                                    <span class="text-success">Submitted</span>
                                @else
                                    <span class="text-danger">Not Submitted yet</span>
                                @endif
                            </td>

                          </tr>
                          <tr>
                            <th id="time_remaining">Time remaining</th>
                            <td>

                                @php
                                $end_date = Carbon::parse($task->end_date);
                                $time_passed_days = now()->diffInDays($end_date);
                                $time_passed_hours = now()->diffInHours($end_date);
                                $time_passed_minutes = now()->diffInMinutes($end_date);
                                @endphp

                                @if (!$applied_task)
                                    @if ($end_date->gt(now()))
                                        @if ($remaining_days && $remaining_hours)
                                        {{ $remaining_days.' Days and '. $remaining_hours.' hours remaining' }}
                                        @elseif($remaining_hours)
                                        {{ $remaining_hours.' hours remaining' }}
                                        @else
                                        {{ $remaining_minutes.' minutes remaining' }}
                                        @endif
                                    @else
                                    <span class="text-danger">
                                        @if ($time_passed_days && $time_passed_hours)
                                            {{ $time_passed_days == 1 ? $time_passed_days.' Day ago' : $time_passed_days.' Days ago'  }}
                                        @elseif ($time_passed_hours)
                                            {{ $time_passed_hours.' hours ago' }}
                                        @else
                                            {{ $time_passed_minutes.' minutes ago' }}
                                        @endif    
                                    </span>
                                    @endif
                                @else
                                @php
                                    $submission_time_seconds = $applied_task->created_at->diffInSeconds(now());
                                    $submission_time_minutes = floor($submission_time_seconds / 60);
                                    $submission_time_hours = floor($submission_time_minutes / 60);
                                    $submission_time_days = floor($submission_time_hours / 24);
                                    $submission_time_hours = $submission_time_hours % 24;
                                @endphp
                                    @if ($submission_time_days && $submission_time_hours)
                                        <b> {{'Submitted '.$submission_time_days.' days and '.$submission_time_hours.' ago' }}</b> 
                                    @elseif ($submission_time_hours)
                                        <b>{{'Submitted ' .$submission_time_hours.' hours ago' }}</b>
                                    @else
                                        <b>{{'Submitted ' .$submission_time_minutes.' minutes ago' }}</b>
                                    @endif
                                    <span class="float-right text-success"><i class="fas fa-check"></i></span>
                                @endif
                            </td>

                          </tr>
                          <tr>
                            <th class="file_submitted">File submissions</th>
                            @if ($applied_task)
                                <td><a href="{{ asset('uploads/applied-tasks/'.$applied_task->file) }}" target="_blank" download>{{ $applied_task->file }}</a></td>
                            @else
                                <td>There is no file yet</td>
                            @endif

                          </tr>
                        </tbody>
                      </table>


                </div>
                <div class="col-lg-12" id="form_wrapper">
                    @if (!now()->gt($end_date))
                        <button type="button" id="show_form" class="btn btn-primary">Add Submission</button>
                        <form action="{{ route('student.submit.task') }}" class="mt-4" method="POST" id="task_form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <div class="file-drop-area">
                                <span class="fake-btn">Choose files</span>
                                <span class="file-msg">or drag and drop files here</span>
                                <input class="file-input" name="file" id="file_input" type="file">
                                <span class="text-danger">{{ $errors->first('file') }}</span>
                              </div>
                              <button type="button" id="submit_btn" class="mt-3 btn btn-primary">Submit</button>
                              <button type="button" id="hide_form" class="mt-3 btn btn-secondary btn-sm">Cancel</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>






{{-- @endif --}}
@stop

@section('scripts')

    @if(session('msg'))
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

            @if(session('type') == 'success')
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

    {{-- Ajax --}}
    <script>
        $(document).ready(function() {
            $('#task_form').hide();
            $("#form_wrapper").on("click", '#show_form', function() {
                $('#task_form').show();
                $(this).hide();
                
            });
            $("#form_wrapper").on("click", '#hide_form', function() {
                $('#task_form').hide();
                $("#show_form").show();
            });

        })

        
        $("#form_wrapper").on("click", '#submit_btn', function() {
                    let form = $('#task_form')[0];
                    let formData = new FormData(form);
                    let url = form.getAttribute("action");
                    $.ajax({
                        url: url,
                        type: "post",
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response) {
                            form.hide();
                            $("#show_form").hide();

                            var applied_task = JSON.parse(response);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                iconColor: 'white',
                                customClass: {
                                    popup: 'colored-toast'
                                },
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: false,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                })

                                Toast.fire({
                                icon: 'success',
                                title: data
                                })
                        }
                    })
                })
    </script>

    {{-- Drop and drag input --}}
    <script>
        var $fileInput = $('.file-input');
        var $droparea = $('.file-drop-area');

        // highlight drag area
        $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
        });

        // back to normal state
        $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
        });

        // change inner text
        $fileInput.on('change', function() {
        var filesCount = $(this)[0].files.length;
        var $textContainer = $(this).prev();

        if (filesCount === 1) {
            // if single file is selected, show file name
            var fileName = $(this).val().split('\\').pop();
            $textContainer.text(fileName);
        } else {
            // otherwise show number of files
            $textContainer.text(filesCount + ' files selected');
        }
        });
    </script>
@stop
