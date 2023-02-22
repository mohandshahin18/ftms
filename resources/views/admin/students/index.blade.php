@extends('admin.master')

@section('title', 'Students')
@section('sub-title', 'Students')
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')

@section('styles')

    <style>
        .search-wrapper {
            position: relative;
        }

        .search-wrapper input:focus {
            /* border-right: none; */
            /* box-shadow:none */

        }

        .search-wrapper input:focus {
            border: 1px solid #86b7fe !important;
            /* outline: 0 !important; */
            box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%) !important;
        }



        .search-result {
            background: #e2e2e2;
            position: absolute;
            width: 100%;
            /* height: auto; */
            top: 38px;
            left: 0;
            border-radius: .375rem;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
            /* border: 1px solid #ced4da; */
            border-top: none;
            display: none;

        }

        .search-result ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }


        .search-result ul li a {
            width: 100%;
            padding: 8px 15px;
            display: block;
            text-decoration: none;
            color: #000
        }

        .search-result ul li a u {
            text-decoration: none;
            /* color: #b40000 */
            font-weight: 600
        }

        .search-result ul li a:hover {
            background: #dbdbdb
        }
    </style>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between">




                        <div class="card-tools col-6" style="display: flex; align-items: center; gap: 10px">
                            <form action="">
                                <div class="input-group input-group" style="width: 280px;">
                                    <input type="text" name="keyword" value="{{ request()->keyword }}"
                                        class="form-control " placeholder="Search by Student Name">
                                </div>
                            </form>


                        </div>


                        <div class="btn-website">

                            <a href="{{ route('admin.students.trash') }}" class="  btn btn-outline-warning text-dark"><i
                                    class="fas fa-trash"></i> Recycle Bin</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th>#</th>
                                <th>Student name</th>
                                <th>Student phone</th>
                                <th>Student ID</th>
                                <th>University name</th>
                                <th>Specialization</th>
                                <th>Evaluation Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($students as $student)
                                <tr id="row_{{ $student->id }}">
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->university->name }}</td>
                                    <td>{{ $student->specialization->name }}</td>
                                    <td>
                                        @php
                                            $isEvaluated = false;
                                        @endphp
                                        @foreach ($applied_evaluations as $applied_evaluation)
                                            @if ($student->id == $applied_evaluation->student_id )
                                                @php
                                                    $isEvaluated = true;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @if ($isEvaluated)
                                            <span class="text-success">Evaluated</span>
                                        @else
                                            <span class="text-danger">Not Evaluated yet</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @if ($isEvaluated)
                                                <a href="{{ route('admin.show_evaluation', $student) }}"
                                                    class="btn btn-info btn-sm" data-disabled="true"
                                                    title="show evaluation">Evaluation</a>
                                            @else
                                                <a href="{{ route('admin.students.show', $student) }}"
                                                    class="btn btn-sm  btn-outline-secondary" data-disabled="true"
                                                    title="evaluate">Evaluate</a>
                                            @endif
                                            @if (Auth::guard('company')->check())
                                                <form class="d-inline delete_company"
                                                    action="{{ route('admin.students.delete.from.company', $student->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm btn-delete"> <i
                                                            class="fas fa-trash"></i> </button>
                                                </form>
                                            @else
                                                <form class="d-inline delete_form"
                                                    action="{{ route('admin.students.destroy', $student->id) }}"method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm btn-delete"> <i
                                                            class="fas fa-trash"></i> </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="12" style="text-align: center">
                                    NO Data Selected
                                </td>
                        </tbody>
                        @endforelse


                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <div class="mb-3 myPaginate">
                {{ $students->appends($_GET)->links() }}
            </div>
        </div>
    </div>




@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        // Delete
        $('.delete_company').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            let data = $(this).serialize();

            Swal.fire({
                title: 'Are you sure?',
                text: "It will be deleted",
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
                        position: 'top',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'error',
                        title: 'Delete Completed'
                    })
                }
            })

<<<<<<< HEAD
=======


        });
    </script>
>>>>>>> f305488a507c4922415f503b533e3ca92cf0e3b8
@stop
