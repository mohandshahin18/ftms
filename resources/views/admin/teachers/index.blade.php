@extends('admin.master')

@section('title', __('admin.Teachers'))
@section('sub-title', __('admin.Teachers'))
@section('teachers-menu-open', 'menu-open')
@section('teachers-active', 'active')
@section('index-teacher-active', 'active')

@section('styles')

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">




                        <div class="btn-website">
                            <a title="{{ __('admin.Add Teacher') }}" href="{{ route('admin.teachers.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add Teacher') }}</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Teacher Name') }}</th>
                                <th>{{ __('admin.Teacher Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                <th>{{ __('admin.University Name') }}</th>
                                <th>{{ __('admin.Specialization') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($teachers as $teacher)
                                <tr id="row_{{ $teacher->slug }}">
                                    <td>{{ $teacher->id }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->university->name }}</td>
                                    <td>{{ $teacher->specialization->name }}</td>
                                    <td>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.teachers.destroy', $teacher->slug) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button  title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i> </button>
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
                {{ $teachers->links() }}
            </div>
        </div>
    </div>




@stop

