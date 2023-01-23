@extends('admin.master')

@section('title', 'Trainers')
@section('sub-title', 'Trainers')
@section('trainers-menu-open', 'menu-open')
@section('trainers-active', 'active')
@section('index-trainer-active', 'active')

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
                            <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add Trainer</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Trainer Name</th>
                                <th>Company name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($trainers as $trainer)
                                <tr id="row_{{ $trainer->id }}">
                                    <td>{{ $trainer->id }}</td>
                                    <td>{{ $trainer->name }}</td>
                                    <td>{{ $trainer->company->name }}</td>
                                    <td>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i> </button>
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
                {{ $trainers->links() }}
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

        // to hide alert ------
        setTimeout(() => {
            $('.alert-success').fadeOut(3000);
        }, 500);
      
      
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
