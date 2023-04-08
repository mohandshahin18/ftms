@extends('admin.master')

@section('title',__('admin.Add New Role'))
@section('sub-title', __('admin.Roles'))
@section('roles-menu-open', 'menu-open')
@section('roles-active', 'active')
@section('add-role-active', 'active')

@section('styles')
    <link rel="stylesheet" href="{{ asset('adminAssets/dist/css/checkBox.css') }}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.Add New Role') }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.roles.store') }}" method="POST" >
                    @csrf
                    <div class="card-body">
                        <div class="row">
                             {{-- name  --}}
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-2">{{ __('admin.Role Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="{{ __('admin.Main Title') }}" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped  table-hover ">
                                        <thead>
                                            <tr style="background-color: #1e272f; color: #fff;">
                                                <th>#</th>
                                                <th>{{ __('admin.Ability Name') }}</th>
                                                <th class="checkbox-wrapper-13">{{ __('admin.Select') }}
                                                    ( <label ><input type="checkbox" id="check_all"> {{ __('admin.Select All') }} </label> )

                                                </th>

                                            </tr>
                                        </thead>


                                        <tbody>
                                            @foreach ($abilites as $ability )
                                            <tr class="checkbox-wrapper-13">
                                                <td>{{ $ability->id }}</td>
                                                <td> {{ $ability->name }}</td>
                                                <td> <input type="checkbox"  id="c1-13" name="ability[]" value="{{ $ability->id }}"></td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>




                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button class="btn btn-dark btn-flat" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                        <button type="submit" class="btn btn-primary btn-flat">
                            <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script>
        $('#check_all').on('change',function(){
            $('input[type=checkBox]').prop('checked', $(this).prop('checked'));
        })
    </script>
@stop
