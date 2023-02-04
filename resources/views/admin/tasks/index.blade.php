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
<<<<<<< HEAD
=======

@section('scripts')
    <script>


        $('.delete-form').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            let data = $(this).serialize();

            Swal.fire({
                title: 'Are you sure?',
                text: "It will be permanently deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#000',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // send ajax request and delete post
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        success: function(res) {
                            $('#row_' + res).remove();

                        }

                    })

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
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
                        title: 'Moved to Recycle Bin'
                    })
                }
            })



        });
    </script>


    {{-- Messages Script --}}
    @if (session('msg'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if (session('type') == 'success')
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'danger')
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


@stop
>>>>>>> 607231d400c432d5f6ffeab0d8ce0dc9d437d855
