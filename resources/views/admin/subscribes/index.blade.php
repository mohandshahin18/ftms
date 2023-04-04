@extends('admin.master')

@section('title', __('admin.University IDs'))
@section('sub-title', __('admin.University IDs'))
@section('subscribes-menu-open', 'menu-open')
@section('subscribes-active', 'active')
@section('index-subscribes-active', 'active')

@section('styles')
    <style>
        /* modal  */
        .modal-body {
            height: 220px;
        }

        .modal-body::-webkit-scrollbar {
            display: none;
        }

        .modal-body {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* #row_20201918 td:nth-child(2){
                background: #1e272f
            } */
    </style>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @canAny(['import_university_id', 'add_university_id'])
                    <div class="card-header">
                        <div class="d-flex  justify-content-between">

                            <div class="search-uni-id">
                                <input type="text" name="searchUniId" id="searchUniId" placeholder="{{ __('admin.Search here') }}" autocomplete="off" class="form-control">
                            </div>

                            <div class="d-flex" style="gap: 10px;">
                                @can('add_university_id')
                                    <div class="btn-website">
                                        <a title="{{ __('admin.Add University ID') }}" href="{{ route('admin.subscribes.create') }}"
                                            class="btn btn-primary"><i class="fas fa-plus"></i>
                                            {{ __('admin.Add University ID') }}</a>
                                    </div>
                                @endcan
                                @can('import_university_id')
                                    <a title="{{ __('admin.Import') }}" href="{{ route('admin.subscribes.import_view') }}"
                                        class="btn btn-primary"><i class="fas fa-file-import"></i> {{ __('admin.Import') }} </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endcanAny
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-hover" id="university_ids_table">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Student Name') }}</th>
                                <th>{{ __('admin.University ID') }}</th>
                                <th>{{ __('admin.University') }}</th>
                                <th>{{ __('admin.Specialization') }}</th>
                                @canAny(['delete_university_id', 'edit_university_id'])
                                    <th>{{ __('admin.Actions') }}</th>
                                @endcanAny
                            </tr>
                        </thead>

                        <tbody id="university_ids_body">
                            @php
                                $count = $subscribes->count();
                            @endphp
                            @forelse ($subscribes as $subscribe)
                                <tr id="row_{{ $subscribe->id }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $subscribe->name }}</td>
                                    <td>{{ $subscribe->student_id }}</td>
                                    <td>{{ $subscribe->university->name }}</td>
                                    <td>{{ $subscribe->specialization->name }}</td>
                                    @canAny(['delete_university_id', 'edit_university_id'])
                                        <td>
                                            @can('edit_university_id')
                                                <a href="{{ route('admin.subscribes.edit', $subscribe->id) }}"
                                                    title="{{ __('admin.Edit') }}" type="button"
                                                    class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete_university_id')
                                                <form class="d-inline delete_form"
                                                    action="{{ route('admin.subscribes.destroy', $subscribe->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button title="{{ __('admin.Delete') }}"
                                                        class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    @endcanAny
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    <img src="{{ asset('adminAssets/dist/img/folder.png') }}" alt=""
                                        width="300">
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
                {{ $subscribes->links() }}
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        let searchUniId = $("#searchUniId");
        let university_ids_table = $("#university_ids_table");
        let university_ids_body = $("#university_ids_body");
        let searchUniIdUrl = "{{ route('admin.search.subsicribers') }}";

        searchUniId.on("keyup", function() {
            let searchUniIdValue = $(this).val();
            $.ajax({
                type: "get",
                url: searchUniIdUrl,
                data: {searchValue: searchUniIdValue},
                success:function(response) {
                    university_ids_body.empty();
                    university_ids_body.append(response);
                }
            })
        })
    </script>
@endsection