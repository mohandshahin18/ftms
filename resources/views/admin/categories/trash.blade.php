@extends('admin.master')

@section('title', __('admin.Recycle Bin'))
@section('sub-title', __('admin.Programs'))
@section('categories-active', 'active')


@section('content')




    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">


                        <div class="btn-website">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-flat"> {{ __('admin.All Programs') }}</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Program Name') }}</th>
                                @canAny(['forceDelete_program','restore_program'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr id="row_{{ $category->slug }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                     @canAny(['forceDelete_program','restore_program'])
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            @can('restore_program')
                                            <form action="{{ route('admin.categories.restore', $category->slug) }}" method="POST" class="restor_form">
                                                @csrf
                                                <button title="{{ __('admin.Restore') }}" class="btn btn-warning btn-sm btn_restore btn-flat"><i class="fas fa-trash-restore"></i></button>
                                              </form>
                                            @endcan
                                            @can('forceDelete_program')
                                            <form action="{{ route('admin.categories.forcedelete', $category->slug) }}" method="POST" class="delete_form">
                                                @csrf
                                                @method('delete')
                                                <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm delete_btn btn-flat"> <i class="fas fa-times"></i> </button>
                                              </form>
                                            @endcan
                                          </div>
                                    </td>
                                    @endcanAny
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt="" width="300" >
                                    <br>
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>


@stop

