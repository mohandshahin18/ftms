@extends('admin.master')

@section('title', __('admin.Admins'))
@section('sub-title', __('admin.Admins'))
@section('admins-menu-open', 'menu-open')
@section('admins-active', 'active')
@section('index-admin-active', 'active')

@section('styles')

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">




                        <div class="btn-website">
                            <a title="{{ __('admin.Add Admin') }}" href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-flat"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Admin') }}</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Admin Name') }}</th>
                                <th>{{ __('admin.Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $count = $admins->count();
                            @endphp
                            @forelse ($admins as $admin)
                                <tr id="row_{{ $admin->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>
                                        <form class="d-inline delete_form" action="{{ route('admin.admins.destroy', $admin->slug) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
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
                {{ $admins->links() }}
            </div>
        </div>
    </div>




@stop
