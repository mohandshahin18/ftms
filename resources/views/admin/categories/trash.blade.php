@extends('admin.master')

@section('title', 'Recycle Bin')
@section('sub-title', 'Categories')
@section('categories-active', 'active')


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
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"> All Categories</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr id="row_{{ $category->id }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="restor_form">
                                              @csrf
                                              <button class="btn btn-warning btn-sm btn_restore"><i class="fas fa-trash-restore"></i></button>
                                            </form>
                                            <form action="{{ route('admin.categories.forcedelete', $category->id) }}" method="POST" class="delete_form">
                                              @csrf
                                              @method('delete')
                                              <button class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-times"></i> </button>
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>


@stop

