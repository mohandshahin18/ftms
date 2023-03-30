@extends('admin.master')

@section('title', __('admin.Companies'))
@section('sub-title' , __('admin.Companies'))
@section('companies-menu-open', 'menu-open')
@section('companies-active', 'active')
@section('index-company-active', 'active')

@section('styles')

<style>

@media(max-width:626px){
    .btn-website {
       margin: 10px 0;
    }

}
</style>
@stop
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex  justify-content-between align-items-center flex-wrap">
                        <div class="card-tools">
                            <form action="" >
                             <div class="input-group input-group" style="width: 280px;">
                                 <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control " placeholder="{{ __('admin.Search by Company Name') }}">
                             </div>
                            </form>
                         </div>


                        <div class="btn-website ">
                            <a title="{{ __('admin.Add Company') }}" href="{{ route('admin.companies.create') }}" class="btn btn-primary btn-flat"><i class="fas fa-plus"></i> {{ __('admin.Add Company') }}</a>
                            <a title="{{ __('admin.Trashed Companies') }}" href="{{ route('admin.companies.trash') }}" class="btn btn-outline-secondary btn-flat"><i class="fas fa-trash"></i> {{ __('admin.Recycle Bin') }}</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Company Name') }}</th>
                                <th>{{ __('admin.Programs no.') }}</th>
                                <th>{{ __('admin.Email') }}</th>
                                <th>{{ __('admin.Phone') }}</th>
                                <th>{{ __('admin.Created at') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = $companies->count();
                            @endphp
                            @forelse ($companies as $company)
                                <tr id="row_{{ $company->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->categories->count() }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->created_at->toDateString() }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px" class="">
                                          <a title="{{ __('admin.Edit') }}" href="{{ route('admin.companies.edit', $company->slug) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>

                                          <form class="delete_form" method="POST" action="{{ route('admin.companies.destroy', $company->slug) }}">
                                            @csrf
                                            @method('delete')
                                            <button title="{{ __('admin.Move to recycle bin') }}" class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-trash"></i> </button>
                                          </form>
                                        </div>

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
                {{ $companies->appends($_GET)->links() }}
              </div>
        </div>
    </div>


@stop

@section('scripts')

@stop

