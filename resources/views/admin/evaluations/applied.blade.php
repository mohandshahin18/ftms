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

 


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Evaluations Name</th>
                                <th>Company Name</th>
                                <th>Student Name</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($applied as $apply)
                                <tr id="row_{{ $apply->id }}">
                                    <td>{{ $apply->name }}</td>
                                    <td>{{ $apply->company->name }}</td>
                                    <td>{{ $apply->student->name }}</td>

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
                {{ $applied->links() }}
            </div>
        </div>
    </div>





@stop

