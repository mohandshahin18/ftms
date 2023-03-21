@extends('admin.master')

@section('title', __('admin.Tasks'))
@section('sub-title', __('admin.Tasks'))
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
                            <a title="{{ __('admin.Add Task') }}" href="{{ route('admin.tasks.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Task') }}</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Task Name') }}</th>
                                <th>{{ __('admin.Program Name') }}</th>
                                <th>{{ __('admin.Starts Date') }}</th>
                                <th>{{ __('admin.Ends Date') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tasks as $task)
                                <tr id="row_{{ $task->slug }}">
                                    <td>{{ $task->id }}</td>
                                    <td>{{Str::words(strip_tags(html_entity_decode($task->sub_title)), 4, '...')  }}</td>
                                    <td>{{ $task->category->name }}</td>

                                    <td>{{ Carbon::parse($task->start_date)->locale(config('app.locale'))->format('j F') }} <b>at</b> {{ Carbon::parse($task->start_date)->format('h:i A') }}</td>

                                    <td>{{ Carbon::parse($task->end_date)->locale(config('app.locale'))->format('j F') }} <b>at</b> {{ Carbon::parse($task->end_date)->format('h:i A') }}</td>
                                    <td>
                                        <a  title="{{ __('admin.Edit') }}" href="{{ route('admin.task.edit', $task->slug) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.tasks.destroy', $task->slug) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt="" width="300" >
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
                {{ $tasks->links() }}
            </div>
        </div>
    </div>



@stop
