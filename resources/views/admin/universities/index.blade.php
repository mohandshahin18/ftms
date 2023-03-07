@extends('admin.master')

@section('title', __('admin.Universities'))
@section('sub-title', __('admin.Universities'))
@section('universities-menu-open', 'menu-open')
@section('universities-active', 'active')
@section('index-university-active', 'active')

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



                        <div class="btn-website">
                            <a title="{{ __('admin.Add University') }}" href="{{ route('admin.universities.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add University') }}</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.University Name') }}</th>
                                <th>{{ __('admin.Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($universities as $university)
                                <tr id="row_{{ $university->slug }}">
                                    <td>{{ $university->id }}</td>
                                    <td>{{ $university->name }}</td>
                                    <td>{{ $university->email }}</td>
                                    <td>{{ $university->phone }}</td>
                                    <td>
                                        <a href="{{ route('admin.universities.edit', $university) }}" title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>
                                        </a>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.universities.destroy', $university->slug) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i>
                                            </button>
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
                {{ $universities->links() }}
            </div>
        </div>
    </div>

@stop
