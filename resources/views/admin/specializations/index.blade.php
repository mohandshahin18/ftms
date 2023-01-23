@extends('admin.master')

@section('title', 'Specializations')
@section('sub-title', 'Specializations')
@section('specializations-menu-open', 'menu-open')
@section('specializations-active', 'active')
@section('index-specialization-active', 'active')

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
                            <a href="{{ route('admin.specializations.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add specialization</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Specialization Name</th>
                                <th>University Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($specializations as $specialization)
                                <tr id="row_{{ $specialization->id }}">
                                    <td>{{ $specialization->id }}</td>
                                    <td>{{ $specialization->name }}</td>
                                    <td>{{ $specialization->university->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-toggle="modal"
                                            data-target="#editspecializations" data-name="{{ $specialization->name }}"
                                            data-url="{{ route('admin.specializations.edit', $specialization->id) }}"> <i
                                                class="fas fa-edit"></i> </button>
                                        <form class="d-inline delete-form"
                                            action="{{ route('admin.specializations.destroy', $specialization->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"
                                                   ></i> </button>
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
                {{ $specializations->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Edit Category -->
    <div class="modal fade" id="editspecializations" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Edit Specialization</h4>
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
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            {{-- end name --}}

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

            let url = $(this).data('url');

            $('#editspecializations form').attr('action', url);
            $('#editspecializations input[name=name]').val(name);


            $('#editspecializations .alert ').addClass('d-none');
            $('#editspecializations .alert ul').html('');

        });

        // send data using ajax
        $('#edit_form').on('submit', function(e) {
            e.preventDefault();


            let data = $(this).serialize();
            // send ajax request
            $.ajax({

                type: 'post',
                url: $('#editspecializations form').attr('action'),
                data: data,
                success: function(res) {

                    $('#row_' + res.id + " td:nth-child(2)").text(res.name);



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
                    $('#editspecializations').modal('hide');
                },
                error: function(err) {
                    $('#editspecializations .alert ul').html('');
                    $('#editspecializations .alert ').removeClass('d-none');
                    for (const key in err.responseJSON.errors) {
                        let li = '<li>' + err.responseJSON.errors[key] + '</li>';
                        $('#editspecializations .alert ul').append(li);
                    }
                }

            });

        });



        $('.delete-form').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            let data = $(this).serialize();

            Swal.fire({
                title: 'Are you sure?',
                text: "It will be moved to the Recycle Bin",
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
