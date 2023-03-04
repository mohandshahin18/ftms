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
            height: 130px;
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



                        <div class="btn-website">
                            <a title="{{ __('admin.University ID') }}" href="{{ route('admin.subscribes.create') }}" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> {{ __('admin.University ID') }}</a>

                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>{{ __('admin.University ID') }}</th>
                                <th>{{ __('admin.Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($subscribes as $subscribe)
                                <tr id="row_{{ $subscribe->id }}">
                                    <td>{{ $subscribe->id }}</td>
                                    <td>{{ $subscribe->university_id }}</td>
                                    <td>
                                        <button title="{{ __('admin.Edit') }}" type="button" class="btn btn-primary btn-sm btn-edit" data-toggle="modal"
                                            data-target="#editUniversityID"
                                            data-url="{{ route('admin.subscribes.update', $subscribe->id) }}"
                                            data-university_id="{{ $subscribe->university_id }}"> <i class="fas fa-edit"></i>
                                        </button>
                                        <form class="d-inline delete_form"
                                            action="{{ route('admin.subscribes.destroy', $subscribe->university_id) }}"
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
                {{ $subscribes->links() }}
            </div>
        </div>
    </div>


    <!-- Modal Edit Category -->
    <div class="modal fade" id="editUniversityID" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">{{ __('admin.Edit University ID') }}</h4>
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
                                <label class="mb-2">{{ __('admin.University ID') }}</label>
                                <input type="text" class="form-control" name="university_id_st" placeholder="{{ __('admin.University ID') }}">
                            </div>
                            {{-- end name --}}



                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save Edit') }}</button>
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
            // $('#editUniversityID').css('display','block');

            let university_id = $(this).data('university_id');
            let url = $(this).data('url');

            $('#editUniversityID form').attr('action', url);
            $('#editUniversityID input[name=university_id_st]').val(university_id);


        });

        // send data using ajax
        $('#edit_form').on('submit', function(e) {
            e.preventDefault();


            let data = $(this).serialize();
            // send ajax request
            $.ajax({

                type: 'post',
                url: $('#editUniversityID form').attr('action'),
                data: data,
                success: function(res) {
                    $('.invalid-feedback').remove();
                    $('input').removeClass('is-invalid');
                    // $('#editUniversityID').hide();

                    // $("#edit_form").click(function(){
                    //     $("#editUniversityID").modal("hide");
                    // });
                    $('#row_' + res.id + " td:nth-child(2)").text(res.university_id);

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
                        title:' {{ __('admin.University ID has been updated successfully') }}'
                    });
                },
                error: function(data) {

                    $('.invalid-feedback').remove();

                    $.each(data.responseJSON.errors, function(field, error) {
                            $("input[name='" + field + "']").addClass('is-invalid').after(
                                '<small class="invalid-feedback">' + error + '</small>');
                        });
                }

            });

        });


    </script>




@stop
