@extends('admin.master')

@section('title', 'Recycle Bin')
@section('sub-title', 'Categories')
@section('categories-active', 'active')


@section('content')




    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">


                        <div class="btn-website">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"> All Categories</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr id="row_{{ $category->id }}">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px">
                                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="restor_form">
                                              @csrf
                                              <button class="btn btn-warning btn-sm btn_restore"><i class="fas fa-trash-restore"></i></button>
                                            </form>
                                            <form action="{{ route('admin.categories.forcedelete', $category->id) }}" method="POST" class="delete_form">
                                              @csrf
                                              @method('delete')
                                              <button class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-times"></i> </button>
                                            </form>
                                          </div>
                                    </td>

                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    NO Data Selected
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


@stop

@section('scripts')

@if (session('msg'))
  <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

    @if (session('type') == 'success')
      Toast.fire({
      icon: 'success',
      title: '{{ session('msg') }}'
      })
    @elseif (session('type') == 'danger')
      Toast.fire({
      icon: 'warning',
      title: '{{ session('msg') }}'
      })
    @else
      Toast.fire({
        icon: 'warning',
        title: '{{ session('msg') }}'
        })
    @endif
  </script>
@endif

{{-- Ajax Delete --}}
<script>

    $('.delete_form').on('submit', function(e) {
        e.preventDefault();

        let url = $(this).attr('action');

        let data = $(this).serialize();

        Swal.fire({
            title: 'Are you sure?',
            text: "It will be permanently deleted",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#000',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // send ajax request and delete post
                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    success: function(res) {
                        $('#row_' + res).remove();

                    }

                })

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Deleted Successfully'
                })
            }
        })



    });
  </script>

  {{-- Ajax Restore --}}
  <script>
    $('.restor_form').on('submit', function(e) {
        e.preventDefault();

        let url = $(this).attr('action');

        let data = $(this).serialize();

        Swal.fire({
            title: 'Are you sure?',
            text: "It will be restored and not being deleted",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#000',
            confirmButtonText: 'Yes, restore it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // send ajax request and resotre
                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    success: function(res) {
                        $('#row_' + res).remove();

                    }

                })

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Restored Successfully'
                })
            }
        })



    });
  </script>

@stop
