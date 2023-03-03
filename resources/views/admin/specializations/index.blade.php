@extends('admin.master')

@section('title', __('admin.Specializations'))
@section('sub-title', __('admin.Specializations'))
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




                        <div class="btn-website">
                            <a title="{{ __('admin.Add Specialization') }}" href="{{ route('admin.specializations.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Specialization') }}</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Specialization') }}</th>
                                <th>{{ __('admin.University Name') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($specializations as $specialization)
                                <tr id="row_{{ $specialization->slug }}">
                                    <td>{{ $specialization->id }}</td>
                                    <td>{{ $specialization->name }}</td>
                                    <td>{{ $specialization->university->name }}</td>
                                    <td>
                                        <a title="{{ __('admin.Edit') }}" href="{{ route('admin.specializations.edit', $specialization->slug) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>

                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.specializations.destroy', $specialization->slug) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"
                                                   ></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    {{ __('admin.NO Data Selected') }}
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

