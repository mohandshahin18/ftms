@extends('admin.master')

@section('title', __('admin.Adverts'))
@section('sub-title', __('admin.Adverts'))
@section('adverts-menu-open', 'menu-open')
@section('adverts-active', 'active')
@section('index-adverts-active', 'active')

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
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
                <div class="card-header">
                    <div class="d-flex  justify-content-between">



                        <div class="btn-website ">
                            <a title="{{ __('admin.Add New Advert') }}" href="{{ route('admin.adverts.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.Add New Advert') }}</a>



                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Main Title') }}</th>
                                <th>{{ __('admin.Sub Title') }}</th>
                                <th>{{ __('admin.Image') }}</th>
                                <th>{{ __('admin.Created at') }}</th>

                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($adverts as $advert)
                                <tr id="row_{{ $advert->id }}">
                                    <td>{{ $advert->id }}</td>
                                    <td>{{ $advert->main_title }}</td>
                                    <td>{{ Str::words(strip_tags(html_entity_decode($advert->sub_title)), 4, '...') }}</td>
                                    <td><img src="{{ asset($advert->image) }}" style="object-fit: cover" alt="" width="80" height="80"></td>
                                    <td>{{ $advert->created_at->diffForHumans() }}</td>

                                    <td>
                                        <a href="{{ route('admin.adverts.edit',$advert->id) }}" title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i>
                                        </a>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.adverts.destroy', $advert->id) }}"
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
                {{ $adverts->links() }}
            </div>
        </div>
    </div>










@stop

