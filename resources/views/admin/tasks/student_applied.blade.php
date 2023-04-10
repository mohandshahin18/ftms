@extends('admin.master')

@section('title', __('admin.Applied Tasks'))
@section('sub-title', __('admin.Applied Tasks'))
@section('tasks-menu-open', 'menu-open')
@section('tasks-active', 'active')
@section('index-task-active', 'active')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Student Name') }}</th>
                                <th>{{ __('admin.File') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $count = $applied_tasks->count();
                            @endphp
                            @forelse ($applied_tasks as $applied_task)
                                <tr>
                                    <td>{{ $count }}
                                        @php
                                            $count--;
                                        @endphp</td>
                                    <td>{{ $applied_task->student->name }}</td>
                                    <td>
                                        @if ($applied_task->student_id == $applied_task->student->id)
                                            <a target="_blank"
                                                href="{{ asset('uploads/tasks-files/' . $applied_task->file) }}"
                                                download>{{ $applied_task->file }}</a><i
                                                class="fas fa-file task-file-icon"></i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt="" width="300">
                                    <br>
                                    <h4>{{ __('admin.NO Data Selected') }}</h4>
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <div class="mb-3">
                {{ $applied_tasks->links() }}
            </div>
        </div>
    </div>



@stop
