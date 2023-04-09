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
               @can('add_university')
               <div class="card-header">
                <div class="d-flex  justify-content-between">

                    <div class="btn-website">
                        <a title="{{ __('admin.Add University') }}" href="{{ route('admin.universities.create') }}" class="btn btn-primary btn-flat"><i
                                class="fas fa-plus"></i> {{ __('admin.Add University') }}</a>
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
                                <th>{{ __('admin.University Name') }}</th>
                                <th>{{ __('admin.Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                @canAny(['delete_university','edit_university'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $count = $universities->count();
                            @endphp
                            @forelse ($universities as $university)
                                <tr id="row_{{ $university->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $university->name }}</td>
                                    <td>{{ $university->email }}</td>
                                    <td>{{ $university->phone }}</td>
                                     @canAny(['delete_university','edit_university'])
                                    <td>
                                        @can('edit_university')
                                        <a href="{{ route('admin.universities.edit', $university) }}" title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm btn-flat"><i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                       @can('delete_university')
                                       <form class="d-inline delete_form"
                                       action="{{ route('admin.universities.destroy', $university->slug) }}"
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
                {{ $universities->links() }}
            </div>
        </div>
    </div>

@stop
