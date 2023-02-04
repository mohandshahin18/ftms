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
                                        <a title="Edit" href="{{ route('admin.specializations.edit', $specialization) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>

                                        <form class="d-inline delete_form"
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








@stop

