@extends('admin.master')

@section('title', 'Programs')
@section('sub-title', 'Programs')
@section('categories-menu-open', 'menu-open')
@section('categories-active', 'active')
@section('index-category-active', 'active')

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
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Add Program</a>
                            <a href="{{ route('admin.categories.trash') }}" class="  btn btn-outline-warning text-dark"><i
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
                                <th>Program Name</th>
                                <th>Companies no.</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr id="row_{{ $category->id }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->companies->count() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-toggle="modal"
                                            data-target="#editCategory" data-name="{{ $category->name }}"
                                            data-url="{{ route('admin.categories.update', $category->id) }}"> <i
                                                class="fas fa-edit"></i> </button>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"
                                                    data-totalPost="{{ $categories->total() }}"></i> </button>
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Edit Category -->
    <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Edit Program</h4>
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

            $('#editCategory form').attr('action', url);
            $('#editCategory input[name=name]').val(name);


            $('#editCategory .alert ').addClass('d-none');
            $('#editCategory .alert ul').html('');

        });

        // send data using ajax
        $('#edit_form').on('submit', function(e) {
            e.preventDefault();


            let data = $(this).serialize();
            // send ajax request
            $.ajax({

                type: 'post',
                url: $('#editCategory form').attr('action'),
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
                    $('#editCategory').modal('hide');
                },
                error: function(err) {
                    $('#editCategory .alert ul').html('');
                    $('#editCategory .alert ').removeClass('d-none');
                    for (const key in err.responseJSON.errors) {
                        let li = '<li>' + err.responseJSON.errors[key] + '</li>';
                        $('#editCategory .alert ul').append(li);
                    }
                }

            });

        });


    </script>



@stop
