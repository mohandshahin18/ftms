@extends('admin.master')

@section('title', 'Evaluations')
@section('sub-title', 'Evaluations')
@section('evaluations-menu-open', 'menu-open')
@section('evaluations-active', 'active')
@section('index-evaluations-active', 'active')

@section('styles')
    <style>
        /* modal  */
        .modal-body {
            height: 150px;
            /* overflow-y: scroll; */
        }
    </style>
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
                            <a href="{{ route('admin.evaluations.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add Evaluation</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Evaluations Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($evaluations as $evaluation)
                                <tr id="row_{{ $evaluation->id }}">
                                    <td>{{ $evaluation->id }}</td>
                                    <td>{{ $evaluation->name }}</td>
                                    <td>{{ $evaluation->evaluation_type }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            <a title="Edit" href="{{ route('admin.evaluations.edit', $evaluation) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>
                                            <form class="d-inline delete_form" action="{{ route('admin.evaluations.destroy', $evaluation) }}" method="POST">
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
                {{-- {{ $evaluations->links() }} --}}
            </div>
        </div>
    </div>


@stop

@section('scripts')

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

    <script>

    $('.delete_form').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            let data = $(this).serialize();

            Swal.fire({
                title: 'Are you sure?',
                text: "It will be deleted",
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
                        title: 'Deleted Successfully'
                    })
                }
            })



        });
    </script>

@stop