@extends('admin.master')

@section('title', 'Tasks')
@section('sub-title', 'Tasks')
@section('tasks-menu-open', 'menu-open')
@section('tasks-active', 'active')
@section('index-task-active', 'active')

@section('styles')
    <style>
        /* modal  */
        .modal-body {
            height: 220px;
            overflow-y: scroll;
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
                            <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add university</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>University Name</th>
                                <th>University Email</th>
                                <th>University Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tasks as $university)
                                <tr id="row_{{ $university->id }}">
                                    <td>{{ $university->id }}</td>
                                    <td>{{ $university->name }}</td>
                                    <td>{{ $university->email }}</td>
                                    <td>{{ $university->phone }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-toggle="modal"
                                            data-target="#editUniversity" data-name="{{ $university->name }}"
                                            data-url="{{ route('admin.tasks.update', $university->id) }}"
                                            data-email="{{ $university->email }}" data-phone="{{ $university->phone }}"
                                            data-address="{{ $university->address }}"> <i class="fas fa-edit"></i>
                                        </button>
                                        <form class="d-inline delete-form"
                                            action="{{ route('admin.universities.destroy', $university->id) }}"
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
                {{ $universities->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Edit Category -->
    <div class="modal fade" id="editUniversity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Edit University</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_form" action="" method="Post">
                    <div class="modal-body">


                        @csrf
                        @method('put')
                        <div class="row">

                            {{-- start name --}}
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            {{-- end name --}}

                            {{-- email --}}
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                            {{-- email --}}

                            {{-- phone  --}}
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone">
                            </div>
                            {{-- phone  --}}

                            {{-- address  --}}
                            <div class="col-sm-6 mb-3">
                                <label class="mb-2">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                            {{-- address  --}}

                        </div>

                        <div class="alert alert-danger d-none">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>


            </div>
        </div>
    </div>








@stop

@section('scripts')
    <script>
        // get old data from edit button
        $('.btn-edit').on('click', function() {
            let name = $(this).data('name');
            let phone = $(this).data('phone');
            let email = $(this).data('email');
            let address = $(this).data('address');
            let url = $(this).data('url');

            $('#editUniversity form').attr('action', url);
            $('#editUniversity input[name=name]').val(name);
            $('#editUniversity input[name=email]').val(email);
            $('#editUniversity input[name=phone]').val(phone);
            $('#editUniversity input[name=address]').val(address);


            $('#editUniversity .alert ').addClass('d-none');
            $('#editUniversity .alert ul').html('');

        });

        // send data using ajax
        $('#edit_form').on('submit', function(e) {
            e.preventDefault();


            let data = $(this).serialize();
            // send ajax request
            $.ajax({

                type: 'post',
                url: $('#editUniversity form').attr('action'),
                data: data,
                success: function(res) {

                    $('#row_' + res.id + " td:nth-child(2)").text(res.name);
                    $('#row_' + res.id + " td:nth-child(3)").text(res.email);
                    $('#row_' + res.id + " td:nth-child(4)").text(res.phone);

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: 'Edit is successfully'
                    });
                    $('#editUniversity').modal('hide');
                },
                error: function(err) {
                    $('#editUniversity .alert ul').html('');
                    $('#editUniversity .alert ').removeClass('d-none');
                    for (const key in err.responseJSON.errors) {
                        let li = '<li>' + err.responseJSON.errors[key] + '</li>';
                        $('#editUniversity .alert ul').append(li);
                    }
                }

            });

        });

//delete university

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
