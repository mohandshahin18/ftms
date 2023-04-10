@extends('admin.master')
<?php $name = $student->name; ?>
@section('title', __('admin.Attendance'))
@section('sub-title', __('admin.Attendance'))
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')


@section('content')

    <div class="row">
        <div class="col-12">

            <div class="card p-3">

                <div class="d-flex  justify-content-between align-items-center">
                    <div>
                        <h5>{{ __('admin.Student Name') }}: <strong style="color: #22486a;"> {{ $name }}</strong>
                        </h5>
                    </div>
                    <div>
                        <a href="{{ route('admin.export_attendance_pdf', $student->slug) }}" class="btn btn-primary mb-2 btn-flat"><i
                                class="fas fa-pdf"> {{ __('admin.Export as PDF') }}</i></a>
                    </div>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped  table-hover ">
                    <thead>
                        <tr style="background-color: #1e272f; color: #fff;">
                            <th style="width: 60%;">{{ __('admin.Date') }}</th>
                            <th>{{ __('admin.Attendance') }}</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($student->attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->attendance_date }}</td>
                                <td>
                                    @if ($attendance->attendance_status == 1)
                                        <span class="text-success">{{ __('admin.Presence') }}</span>
                                    @else
                                        <span class="text-danger">{{ __('admin.Absence') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="m-3 text-center">
                <button class="btn btn-outline-secondary btn-flat" onclick="history.back()">
                    @if (app()->getLocale() == 'ar')
                        <i class="fas fa-arrow-right"></i>
                    @else
                        <i class="fas fa-arrow-left"></i>
                    @endif
                    {{ __('admin.Return Back') }}
                </button>
            </div>
        </div>
        <!-- /.card -->

    </div>
    </div>




@stop
