@extends('admin.master')

@section('title', 'Recycle Bin')
@section('sub-title', 'Students')
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')


@section('content')




    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="card-tools">
                            <form action="" >
                             <div class="input-group input-group" style="width: 280px;">
                                 <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control " placeholder="Search by Name">
                             </div>
                            </form>
                         </div>


                        <div class="btn-website">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-primary"> All Students</a>
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
                                <th>Student email</th>
                                <th>Student phone</th>
                                <th>Student ID</th>
                                <th>University name</th>
                                <th>Specialization name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $student)
                            <tr id="row_{{ $student->id }}">
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->university->name }}</td>
                                <td>{{ $student->specialization->name }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            <form action="{{ route('admin.students.restore', $student->id) }}" method="POST" class="restor_form">
                                              @csrf
                                              <button class="btn btn-warning btn-sm btn_restore" title="Restore"><i class="fas fa-trash-restore"></i></button>
                                            </form>
                                            <form action="{{ route('admin.students.forcedelete', $student->id) }}" method="POST" class="delete_form">
                                              @csrf
                                              @method('delete')
                                              <button class="btn btn-danger btn-sm delete_btn" title="Delete"> <i class="fas fa-times"></i> </button>
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
                {{ $students->appends($_GET)->links() }}
            </div>
        </div>
    </div>


@stop

@section('scripts')

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
        icon: 'warning',
        title: '{{ session('msg') }}'
        })
    @endif
  </script>
@endif

{{-- Ajax Delete --}}
<script>

    $('.delete_form').on('submit', function(e) {
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
                    icon: 'warning',
                    title: 'Deleted Successfully'
                })
            }
        })



    });
  </script>

  {{-- Ajax Restore --}}
  <script>
    $('.restor_form').on('submit', function(e) {
        e.preventDefault();

        let url = $(this).attr('action');

        let data = $(this).serialize();

        Swal.fire({
            title: 'Are you sure?',
            text: "It will be restored and not being deleted",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#000',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // send ajax request and resotre
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
                    title: 'Restored Successfully'
                })
            }
        })



    });
  </script>

@stop
