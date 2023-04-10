@extends('admin.master')
@php
    $name = $student->name;
@endphp
@section('title', $name)
@section('sub-title', $name)
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>{{ __('admin.Student Information') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>{{ __('admin.Student Name') }}</th>
                                <td>{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('admin.Student phone') }}</th>
                                <td>{{ $student->phone }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('admin.University Name') }}</th>
                                <td>{{ $student->university->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('admin.Company Name') }}</th>
                                @if ($student->company_id)
                                    <td>{{ $student->company->name }}</td>
                                @else
                                    <td>No company yet</td>
                                @endif
                            </tr>
                            <tr>
                                @if (Auth::guard('admin')->check())
                                    <th>{{ __('admin.Teacher Name') }}</th>
                                    @if ($student->teacher_id)
                                        <td>{{ $student->teacher->name }}</td>
                                    @endif
                                @endif
                            </tr>
                            @if (!(Auth::guard('company')->check() || Auth::guard('trainer')->check()))
                                <tr>
                                    <th>{{ __('admin.Student ID') }}</th>
                                    <td>{{ $student->student_id }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ __('admin.Specialization') }}</th>
                                <td>{{ $student->specialization->name }}</td>
                            </tr>
                            @can('evaluation_student')
                                <tr>
                                    <th>{{ __('admin.Evaluation Status') }}</th>
                                    <td>
                                        @php
                                            $isEvaluated = false;
                                        @endphp
                                        @if ($applied_evaluation)
                                            @php
                                                $isEvaluated = true;
                                            @endphp
                                        @endif
                                        @if ($isEvaluated)
                                            <span class="text-success og-evaluation">{{ __('admin.Evaluated') }}</span>
                                            <span class="text-success evaluation-check"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="text-danger og-evaluation">{{ __('admin.Not Evaluated yet') }}</span>
                                            <span class="text-danger evaluation-check"><i class="fas fa-times"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endcan

                            @if (!Auth::guard('admin')->check())
                                @canAny(['evaluate_student', 'evaluation_student', 'delete_student'])
                                    <tr>
                                        <th>{{ __('admin.Actions') }}</th>
                                        @canAny(['evaluate_student', 'evaluation_student', 'delete_student'])
                                            <td>
                                                <div>
                                                    @canAny(['evaluate_student', 'evaluation_student'])
                                                        @if ($isEvaluated)
                                                            @can('evaluation_student')
                                                                <a title="{{ __('admin.Evaluation') }}"
                                                                    href="{{ route('admin.show_evaluation', $student->slug) }}"
                                                                    class="btn btn-info btn-sm btn-flat" data-disabled="true"
                                                                    title="show evaluation">{{ __('admin.Evaluation') }}</a>
                                                            @endcan
                                                        @else
                                                            @can('evaluate_student')
                                                                <a title="{{ __('admin.Evaluate') }}"
                                                                    href="{{ route('admin.students.show', $student->slug) }}"
                                                                    class="btn btn-sm btn-flat btn-outline-secondary btn-flat"
                                                                    data-disabled="true" title="evaluate">{{ __('admin.Evaluate') }}</a>
                                                            @endcan
                                                        @endif
                                                    @endcanAny

                                                    <a href="{{ route('admin.student.attendence', $student->slug) }}"
                                                        title="{{ __('admin.Student attendence') }}"
                                                        class="btn btn-sm btn-outline-dark"><i
                                                            class="far fa-calendar-check"></i></a>
                                                </div>

                                            </td>
                                        @endcanAny
                                    </tr>
                                @endcanAny
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="m-3 text-center">
                    <button class="btn btn-outline-dark btn-flat" onclick="history.back()">
                        @if (app()->getLocale() == 'ar')
                            <i class="fas fa-arrow-right"></i>
                        @else
                            <i class="fas fa-arrow-left"></i>
                        @endif
                        {{ __('admin.Return Back') }}
                    </button>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>





@stop
