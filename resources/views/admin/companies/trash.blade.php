@extends('admin.master')

@section('title', __('admin.Recycle Bin'))
@section('sub-title', __('admin.Companies'))
@section('companies-active', 'active')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">

                        <div class="card-tools">
                            <form action="" >
                             <div class="input-group input-group" style="width: 280px;">
                                 <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control " placeholder="{{ __('admin.Search by Company Name') }}">
                             </div>
                            </form>
                         </div>


                        <div class="btn-website">
                            <a title="{{ __('admin.Companies Page') }}" href="{{ route('admin.companies.index') }}" class="btn btn-primary"> {{ __('admin.All Companies') }}</a>
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
                            @forelse ($companies as $company)
                                <tr id="row_{{ $company->slug }}">
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->categories->count() }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->deleted_at->toDateString() }}</td>
                                    <td>
                                      <div style="display: flex; gap: 5px">
                                        <form action="{{ route('admin.companies.restore', $company->slug) }}" method="POST" class="restor_form">
                                          @csrf
                                          <button title="{{ __('admin.Restore') }}" class="btn btn-primary btn-sm btn_restore"><i class="fas fa-trash-restore"></i></button>
                                        </form>
                                        <form action="{{ route('admin.companies.forcedelete', $company->slug) }}" method="POST" class="delete_form">
                                          @csrf
                                          @method('delete')
                                          <button title="{{ __('admin.Delete') }}" class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-times"></i> </button>
                                        </form>
                                      </div>
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
                {{ $companies->appends($_GET)->links() }}
              </div>
        </div>
    </div>

@stop

