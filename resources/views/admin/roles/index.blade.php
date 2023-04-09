@extends('admin.master')

@section('title', __('admin.Roles'))
@section('sub-title', __('admin.Roles'))
@section('roles-menu-open', 'menu-open')
@section('roles-active', 'active')
@section('index-roles-active', 'active')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @can('add_role')
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="btn-website ">
                            <a title="{{ __('admin.Add New Role') }}" href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-flat"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add New Role') }}</a>
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
                                <th>{{ __('admin.Role Name') }}</th>

                                <th>{{ __('admin.Abilities Count') }}</th>
                                @canAny(['edit_role','delete_role'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($roles as $role)
                                <tr id="row_{{ $role->id }}">
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->abilities()->count() }}</td>
                                    @canAny(['edit_role','delete_role'])

                                    <td>
                                        @can('edit_role')
                                        <a href="{{ route('admin.roles.edit',$role->id) }}" title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm btn-edit btn-flat"> <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan


                                        @can('delete_role')
                                        <form class="d-inline delete_form"
                                        action="{{ route('admin.roles.destroy', $role->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete btn-flat"> <i class="fas fa-trash"></i>
                                        </button>
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
                {{-- {{ $roles->links() }} --}}
            </div>
        </div>
    </div>




@stop

