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
               @can('add_task')
               <div class="card-header">
                <div class="d-flex  justify-content-between">
                    <div class="btn-website">
                        <a title="{{ __('admin.Add Task') }}" href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-flat"><i
                                class="fas fa-plus"></i> {{ __('admin.Add Task') }}</a>
                    </div>
                </div>
            </div>
               @endcan
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
                               @canAny(['edit_task','delete_task'])
                               <th>{{ __('admin.Actions') }}</th>
                               @endcan
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
                                    @canAny(['edit_task','delete_task'])

                                    <td>
                                        @can('edit_task')
                                        <a  title="{{ __('admin.Edit') }}" href="{{ route('admin.task.edit', $task->slug) }}" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-edit"></i></a>

                                        @endcan
                                        @can('delete_task')
                                        <form class="d-inline delete_form"
                                        action="{{ route('admin.tasks.destroy', $task->slug) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete btn-flat"> <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                        @endcan
                                    </td>
                                    @endcan
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
