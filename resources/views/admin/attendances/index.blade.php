@extends('admin.master')

@section('title', __('admin.Attendance'))
@section('sub-title', __('admin.Attendance'))
@section('attendances-menu-open', 'menu-open')
@section('attendances-active', 'active')



@section('content')
@if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}

        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">
                        <h5 style="font-family: 'Cairo', sans-serif;color: red">{{ __("admin.Today's date :") }} {{ date('Y-m-d') }}</h5>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <form action="{{ route('admin.attendances.store') }}" method="POST">
                        @csrf
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Student Name') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $count = $students->count();
                            @endphp
                            @forelse ($students as $student)

                                <tr id="row_{{ $student->id }}">
                                    <td>
                                        {{ $count }}

                                        @php
                                            $count--;
                                        @endphp

                                    </td>
                                    <td>{{ $student->name }}</td>


                                    <td>

                                        @if (isset($student->attendances()->where('attendance_date', date('Y-m-d'))->first()->student_id))
                                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                                <input name="attendances[{{ $student->id }}]" disabled
                                                    {{ $student->attendances()->latest()->first()->attendance_status== 1 ? 'checked' : '' }}
                                                    class="leading-tight" type="radio" value="presence">
                                                <span class="text-success">{{ __('admin.Presence') }}</span>
                                            </label>

                                            <label class="ml-4 block text-gray-500 font-semibold">
                                                <input name="attendances[{{ $student->id }}]" disabled
                                                    {{ $student->attendances()->latest()->first()->attendance_status== 0 ? 'checked' : '' }}
                                                    class="leading-tight" type="radio" value="absent">
                                                <span class="text-danger">{{ __('admin.Absence') }}</span>
                                            </label>
                                        @else
                                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                                <input name="attendances[{{ $student->id }}]" class="leading-tight"
                                                    type="radio" value="presence">
                                                <span class="text-success">{{ __('admin.Presence') }}</span>
                                            </label>

                                            <label class="ml-4 block text-gray-500 font-semibold">
                                                <input name="attendances[{{ $student->id }}]" class="leading-tight"
                                                    type="radio" value="absent">
                                                <span class="text-danger">{{ __('admin.Absence') }}</span>
                                            </label>
                                        @endif

                                        <input type="hidden" name="student_id[]" value="{{ $student->id }}">

                                    </td>




                                    </td>



                                </tr>

                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt=""
                                        width="300">
                                    <br>
                                    <h4>{{ __('admin.NO Data Selected') }}</h4>
                                </td>
                        </tbody>
                        @endforelse


                    </table>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fas fa-plus"></i> {{ __('admin.Enter') }}</button>

                    </div>
                </form>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <div class="mb-3 myPaginate">
                {{ $students->links() }}
            </div>
        </div>
    </div>




@stop
