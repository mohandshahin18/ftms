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
                @can('add_specialization')
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="btn-website">
                            <a title="{{ __('admin.Add Specialization') }}" href="{{ route('admin.specializations.create') }}" class="btn btn-primary btn-flat"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Specialization') }}</a>

                        </div>


                    </div>
                </div>
                @endcan
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Specialization') }}</th>
                                @canAny(['delete_specialization','edit_specialization'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $count = $specializations->count();
                            @endphp
                            @forelse ($specializations as $specialization)
                                <tr id="row_{{ $specialization->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $specialization->name }}</td>
                                    @canAny(['delete_specialization','edit_specialization'])
                                    <td>
                                        @can('edit_specialization')
                                        <a title="{{ __('admin.Edit') }}" href="{{ route('admin.specializations.edit', $specialization->slug) }}" class="btn btn-primary btn-sm btn-edit btn-flat"> <i class="fas fa-edit"></i> </a>

                                        @endcan
                                        @can('delete_specialization')
                                        <form class="d-inline delete_form"
                                        action="{{ route('admin.specializations.destroy', $specialization->slug) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete btn-flat"> <i class="fas fa-trash"
                                               ></i> </button>
                                    </form>
                                        @endcan

                                    </td>
                                    @endcanAny
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt="" width="300" >
                                    <br>
                                    <h4>{{ __('admin.NO Data Selected') }}</h4>
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

