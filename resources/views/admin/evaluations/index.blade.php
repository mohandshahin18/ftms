@extends('admin.master')

@section('title', __('admin.Evaluations'))
@section('sub-title', __('admin.Evaluations'))
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




                        <div class="btn-website">
                            <a title="{{ __('admin.Add Evaluation') }}" href="{{ route('admin.evaluations.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Evaluation') }}</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Evaluation Name') }}</th>
                                <th>{{ __('admin.For') }}</th>
                                <th>{{ __('admin.Starts Date') }}</th>
                                <th>{{ __('admin.Ends Date') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($evaluations as $evaluation)
                                <tr id="row_{{ $evaluation->id }}">
                                    <td>{{ $evaluation->id }}</td>
                                    <td>{{ $evaluation->name }}</td>
                                    <td>{{ $evaluation->evaluation_type == 'company' ? 'Company' : 'Students' }}</td>
                                    <td>{{ Carbon::parse($evaluation->start_date)->format('Y/m/j')}}</td>
                                    <td>{{ Carbon::parse($evaluation->end_date)->format('Y/m/j') }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            <a title="{{ __('admin.Edit') }}" href="{{ route('admin.evaluations.edit', $evaluation) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>
                                            <form class="d-inline delete_form" action="{{ route('admin.evaluations.destroy', $evaluation) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i> </button>
                                            </form>
                                        </div>
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
                {{ $evaluations->links() }}
            </div>
        </div>
    </div>


@stop

