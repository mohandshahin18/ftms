@extends('admin.master')

@section('title', __('admin.Trainers'))
@section('sub-title', __('admin.Trainers'))
@section('trainers-menu-open', 'menu-open')
@section('trainers-active', 'active')
@section('index-trainer-active', 'active')

@section('styles')

@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
              @can('add_trainer')
              <div class="card-header">
                <div class="d-flex  justify-content-between">

                    <div class="btn-website">
                        <a title="{{ __('admin.Add Trainer') }}" href="{{ route('admin.trainers.create') }}" class="btn btn-primary btn-flat"><i
                                class="fas fa-plus"></i> {{ __('admin.Add Trainer') }}</a>
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
                                <th>{{ __('admin.Trainer Name') }}</th>
                                <th>{{ __('admin.Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                @if(!Auth::guard('company')->check())
                                <th>{{ __('admin.Company Name') }}</th>
                                @endif
                                <th>{{ __('admin.Program') }}</th>
                                @can('delete_trainer')
                                <th>{{ __('admin.Actions') }}</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>

                            @php
                                $count = $trainers->count();
                            @endphp
                            @forelse ($trainers as $trainer)
                                <tr id="row_{{ $trainer->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $trainer->name }}</td>
                                    <td>{{ $trainer->email }}</td>
                                    <td>{{ $trainer->phone }}</td>
                                    @if(!Auth::guard('company')->check())
                                    <td>{{ $trainer->company->name }}</td>
                                    @endif
                                    <td>{{ $trainer->category->name }}</td>
                                   @can('delete_trainer')
                                   <td>
                                    <form class="d-inline delete_form"
                                        action="{{ route('admin.trainers.destroy', $trainer->slug) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm btn-delete btn-flat"> <i class="fas fa-trash"></i> </button>
                                    </form>
                                </td>
                                   @endcan
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
                {{ $trainers->links() }}
            </div>
        </div>
    </div>




@stop




