@extends('admin.master')

@section('title', __('admin.Recycle Bin'))
@section('sub-title', __('admin.Students'))
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')


@section('content')




    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="card-tools">
                            <form action="" >
                             <div class="input-group input-group" style="width: 280px;">
                                 <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control " placeholder="{{ __('admin.Search by Student Name') }}">
                             </div>
                            </form>
                         </div>


                        <div class="btn-website">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-primary">{{ __('admin.All Students') }}</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Student Name') }}</th>
                                <th>{{ __('admin.Student phone') }}</th>
                                <th>{{ __('admin.Student ID') }}</th>
                                <th>{{ __('admin.University Name') }}</th>
                                <th>{{ __('admin.Specialization') }}</th>
                                <th>{{ __('admin.Evaluation Status') }}</th>
                                @canAny(['restore_student','forceDelete_student'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $student)
                            <tr id="row_{{ $student->slug }}">
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->university->name }}</td>
                                <td>{{ $student->specialization->name }}</td>
                                @canAny(['restore_student','forceDelete_student'])
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            @can('restore_student')
                                            <form action="{{ route('admin.students.restore', $student->slug) }}" method="POST" class="restor_form">
                                                @csrf
                                                <button class="btn btn-warning btn-sm btn_restore" title="Restore"><i class="fas fa-trash-restore"></i></button>
                                              </form>
                                            @endcan
                                            @can('forceDelete_student')
                                            <form action="{{ route('admin.students.forcedelete', $student->slug) }}" method="POST" class="delete_form">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm delete_btn" title="Delete"> <i class="fas fa-times"></i> </button>
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
                {{ $students->appends($_GET)->links() }}
            </div>
        </div>
    </div>


@stop

