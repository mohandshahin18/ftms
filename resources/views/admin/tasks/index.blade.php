@extends('admin.master')

@section('title', 'Tasks')
@section('sub-title', 'Tasks')
@section('tasks-menu-open', 'menu-open')
@section('tasks-active', 'active')
@section('index-task-active', 'active')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">


                        <div class="btn-website">
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add task</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Category</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tasks as $task)
                                <tr id="row_{{ $task->id }}">
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->sub_title }}</td>
                                    <td>{{ $task->category->name }}</td>

                                    <td>{{ Carbon::parse($task->start_date)->locale(config('app.locale'))->format('j F') }} <b>at</b> {{ Carbon::parse($task->start_date)->format('h:i A') }}</td>

                                    <td>{{ Carbon::parse($task->end_date)->locale(config('app.locale'))->format('j F') }} <b>at</b> {{ Carbon::parse($task->end_date)->format('h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('admin.task.edit', $task->slug) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.tasks.destroy', $task) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    NO Data Selected
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <div class="mb-3">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>



@stop
