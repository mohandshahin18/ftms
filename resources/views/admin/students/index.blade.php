@extends('admin.master')

@section('title', 'Students')
@section('sub-title', 'Students')
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')

@section('styles')

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 280px;">
                                <input type="text" name="table_search" class="form-control " placeholder="Search by Name">
                            </div>
                        </div>


                        <div class="btn-website">
                            <a href="{{ route('admin.students.trash') }}" class="  btn btn-outline-warning text-dark"><i
                                class="fas fa-trash"></i> Recycle Bin</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Student name</th>
                                <th>Student phone</th>
                                <th>Student ID</th>
                                <th>University name</th>
                                <th>Specialization</th>
                                <th>Evaluation Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $student)
                                <tr id="row_{{ $student->id }}">
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->university->name }}</td>
                                    <td>{{ $student->Specialization->name }}</td>
                                    <td>@if ($student->id == $evaluated_student->id)
                                        <span class="text-success">Evaluated</span>
                                    @else
                                        <span class="text-danger">Not Evaluated yet</span>
                                    @endif    
                                    </td>
                                    <td>
                                        <div>
                                            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary @if ($student->id == $evaluated_student->id )
                                                disabled
                                            @endif" title="evaluate">Evaluate</a>

                                            <a href="{{ route('admin.show_evaluation', $student) }}" class="btn btn-info btn-sm 
                                            @if ($student->id !== $evaluated_student->id)
                                                disabled
                                            @endif" title="show evaluation"><i class="fas fa-eye"></i> Show Evaluation</a>
                                            
                                            <form class="d-inline delete_form"
                                                action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i> </button>
                                            </form>
                                        </div>
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
                {{ $students->links() }}
            </div>
        </div>
    </div>




@stop

@section('scripts')


    <script>

        $('.delete_form').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            let data = $(this).serialize();

            Swal.fire({
                title: 'Are you sure?',
                text: "Trainer will be Deleted",
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
                        icon: 'warning',
                        title: 'Trainer Deleted Successfully'
                    })
                }
            })



        });
      </script>

@stop
