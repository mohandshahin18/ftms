@extends('admin.master')

@section('title', __('admin.Programs'))
@section('sub-title', __('admin.Programs'))
@section('categories-menu-open', 'menu-open')
@section('categories-active', 'active')
@section('index-category-active', 'active')

@section('styles')
    <style>
        /* modal  */
        .modal-body {
            height: 150px;
        }

        .modal-body::-webkit-scrollbar {
            display: none;
        }
        .modal-body {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
               @canAny(['recycle_programs','add_program'])
               <div class="card-header">
                <div class="d-flex  justify-content-between">

                    <div class="card-tools">
                        @can('add_program')
                        <a title="{{ __('admin.Add Program') }}" href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i
                            class="fas fa-plus"></i> {{ __('admin.Add Program') }}</a>
                        @endcan
                    </div>

                    @can('recycle_programs')

                    <div class="btn-website">

                        <a title="{{ __('admin.Recycle Bin') }}" href="{{ route('admin.categories.trash') }}" class="btn btn-outline-secondary"><i
                                class="fas fa-trash"></i> {{ __('admin.Recycle Bin') }}</a>
                    </div>

                    @endcan

                </div>
            </div>
               @endcan
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.Program Name') }}</th>
                                <th>{{ __('admin.Companies no.') }}</th>
                                @canAny(['edit_program','delete_program'])
                                <th>{{ __('admin.Actions') }}</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>

                            @php
                                $count = $categories->count();
                            @endphp
                            @forelse ($categories as $category)
                                <tr id="row_{{ $category->slug }}">
                                    <td>
                                        {{ $count }}
                                        @php
                                            $count--;
                                        @endphp
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->companies->count() }}</td>
                                    @canAny(['edit_program','delete_program'])
                                    <td>
                                       @can('edit_program')
                                       <button title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm btn-edit" data-toggle="modal"
                                       data-target="#editCategory" data-name="{{ $category->name }}"
                                       data-url="{{ route('admin.categories.update', $category->slug) }}"> <i
                                           class="fas fa-edit"></i> </button>
                                       @endcan
                                        @can('delete_program')
                                        <form class="d-inline delete_form"
                                        action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button title="{{ __('admin.Move to recycle bin') }}" class="btn btn-danger btn-sm btn-delete"> <i class="fas fa-trash"
                                                data-totalPost="{{ $categories->total() }}"></i> </button>
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Edit Category -->
    <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin.Edit Program') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_form" action="" method="Post">
                    <div class="modal-body">


                        @csrf
                        @method('put')
                        <div class="row">

                            {{-- start name --}}
                            <div class="col-sm-12 mb-3">
                                <label class="mb-2">{{ __('admin.Program Name') }}</label>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>
                            {{-- end name --}}

                        </div>

                        <div class="alert alert-danger d-none">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary btn-save">{{ __('admin.Save Edit') }}</button>
                    </div>

                </form>


            </div>
        </div>
    </div>








@stop

@section('scripts')
    <script>
        // get old data from edit button
        $('.btn-edit').on('click', function() {
            let name = $(this).data('name');

            let url = $(this).data('url');

            $('#editCategory form').attr('action', url);
            $('#editCategory input[name=name]').val(name);


            $('#editCategory .alert ').addClass('d-none');
            $('#editCategory .alert ul').html('');

        });

        // send data using ajax
        $('#edit_form').on('submit', function(e) {
            e.preventDefault();


            let data = $(this).serialize();
            // send ajax request
            $.ajax({

                type: 'post',
                url: $('#editCategory form').attr('action'),
                data: data,
                success: function(res) {

                    $('#row_' + res.slug + " td:nth-child(2)").text(res.name);


                    $('#editCategory').modal('hide');

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: '{{ __('admin.Program has been updated successfully') }}'
                    });
                },
                error: function(err) {
                    $('#editCategory .alert ul').html('');
                    $('#editCategory .alert ').removeClass('d-none');
                    for (const key in err.responseJSON.errors) {
                        let li = '<li>' + err.responseJSON.errors[key] + '</li>';
                        $('#editCategory .alert ul').append(li);
                    }
                }

            });

        });


          // to close the modal when click to save button
          $(document).ready(function(){

                $('.btn-save').on("click", function(){
                    $(this).prev().click();

                })

            });

    </script>



@stop
