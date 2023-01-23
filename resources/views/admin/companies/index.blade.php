@extends('admin.master')

@section('title', 'Companies')
@section('sub-title' , 'Companies')
@section('companies-menu-open', 'menu-open')
@section('companies-active', 'active')
@section('index-company-active', 'active')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex  justify-content-between align-items-center">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 280px;">
                                <input type="text" name="table_search" class="form-control " placeholder="Search by Name">
                            </div>
                        </div>


                        <div class="btn-website">
                            <a title="Create Company" href="{{ route('admin.companies.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add company</a>
                            <a title="Trashed Companies" href="{{ route('admin.companies.trash') }}" class="btn btn-outline-secondary"><i class="fas fa-trash"></i> Recycle Bin</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Category</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($companies as $company)
                                <tr id="row_{{ $company->id }}">
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->category->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->created_at->toDateString() }}</td>
                                    <td>
                                        <div style="display: flex; gap: 5px" class="">
                                          <a title="Edit" href="{{ route('admin.companies.edit', $company) }}" class="btn btn-primary btn-sm btn-edit"> <i class="fas fa-edit"></i> </a>
                                          <form class="delete_form" method="POST" action="{{ route('admin.companies.destroy', $company) }}">
                                            @csrf
                                            @method('delete')
                                            <button title="Move to recycle bin" class="btn btn-danger btn-sm delete_btn"> <i class="fas fa-trash"></i> </button>
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
                {{ $companies->links() }}
              </div>
        </div>
    </div>


@stop

@section('scripts')

{{-- Messages Script --}}
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
        icon: 'info',
        title: '{{ session('msg') }}'
        })
    @endif
  </script>
@endif

<script>

  // to hide alert ------
  setTimeout(() => {
      $('.alert-success').fadeOut(3000);
  }, 500);


  $('.delete_form').on('submit', function(e) {
      e.preventDefault();

      let url = $(this).attr('action');

      let data = $(this).serialize();

      Swal.fire({
          title: 'Are you sure?',
          text: "It will be moved to the Recycle Bin",
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
                  title: 'Moved to Recycle Bin'
              })
          }
      })



  });
</script>

@stop
