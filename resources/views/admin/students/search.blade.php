@extends('admin.master')

@section('title', 'Students')
@section('sub-title', 'Students')
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')

@section('styles')
    <style>
        .search {
            position: relative;
            
        }

        .search input {
            border-top-right-radius: 0.25rem !important;
            border-bottom-right-radius: 0.25rem !important;
        }
        .search button{
            border: none;
            position: absolute;
            right: 0;
            top: 0px;
            height: 38px;
            z-index: 999;
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
                                <div class="input-group search" style="width: 280px;">
                                    <input type="text" class="form-control" name="keyword" value="{{ request()->keyword }}" placeholder="Search by Student Name">
                                    <button class="btn btn-outline-secondary btn-flat" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                                </div>
                            {{-- <div class="input-group" style="width: 280px;">
                                <input type="text" name="keyword" value="{{ request()->keyword }}" class="form-control " placeholder="Search by Student Name">
                            </div> --}}
                           </form>
                           <form action="{{ route('admin.filter') }}" style="display: flex; align-items: center; gap: 15px">
                            @csrf
                                <div class="input-group">
                                    <select name="filter" class="form-control" id="filter">
                                        <option @selected($filter == 'all') value="all">All</option>
                                        <option @selected($filter == 'evaluated')  value="evaluated">Evaluated</option>
                                        <option @selected($filter == 'not evaluated')  value="not evaluated">Not Evaluated</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-dark btn-sm btn-flat">Result</button>
                           </form>
                        </div>


                        <div class="btn-website">
                            
                            <a href="{{ route('admin.students.trash') }}" class="  btn btn-outline-warning text-dark btn-flat"><i
                                class="fas fa-trash"></i> Recycle Bin</a>
                        </div>


                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
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

                        <tbody id="students_list">
                            @forelse ($students as $student)
                                <tr id="row_{{ $student->id }}">
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->university->name }}</td>
                                    <td>{{ $student->specialization->name }}</td>
                                    <td>
                                    @if($evaluated_student)
                                        @if ($student->id == $evaluated_student->id)
                                            <span class="text-success">Evaluated</span>
                                        @else
                                            <span class="text-danger">Not Evaluated yet</span>
                                        @endif
                                        @else

                                        <span class="text-danger">Not Evaluated yet</span>
                                    @endif
                                    </td>
                                    <td>
                                        <div>
                                            @if($evaluated_student)
                                                @if ($student->id == $evaluated_student->id)

                                                <a href="{{ route('admin.show_evaluation', $student) }}" class="btn btn-info btn-sm btn-flat" data-disabled="true" title="show evaluation">Evaluation</a>
                                                @else

                                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary btn-flat" data-disabled="true" title="evaluate">Evaluate</a>

                                                @endif
                                            @else
                                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary btn-flat" data-disabled="true" title="evaluate">Evaluate</a>

                                            @endif

                                            <form class="d-inline delete_form"
                                                action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm btn-delete btn-flat"> <i class="fas fa-trash"></i> </button>
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
                {{ $students->appends($_GET)->links() }}
            </div>
        </div>
    </div>




@stop

@section('scripts')
    {{-- Disabled Links  --}}
    <script>
        document.querySelectorAll('.disabled[data-disabled="true"]').forEach(function (el) {
            el.addEventListener('click', function (event) {
                event.preventDefault();
            });
        });

    </script>

    {{-- AJAX Filter --}}

    {{-- <script>
        $(document).ready(function() {
            $("#filter").on("change", function() {
                let filter = $("#filter").val();

                $.ajax({
                    url: '/admin/students/filter',
                    type: "GET",
                    data: {filter: filter},
                    success:function(data) {
                        let student = data.students;
                        // let res = Array.isArray(student) ? student : [student];
                        let value = data.value;
                        $("#students_list").empty();
                        student.forEach(function(student) {

                            let row = `<tr>
                                            <td>${student.id}</td>
                                            <td>${student.name}</td>
                                            <td>${student.phone}</td>
                                            <td>${student.student_id}</td>
                                            <td>${student.university.name}</td>
                                            <td>${student.specialization.name}</td>
                                            <td>${value}</td>
                                            ${value == 'Not Evaluated yet' ? 
                                                `<td>
                                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary" data-disabled="true" title="evaluate">Evaluate</a>
                                                </td>` : ''
                                            }
                                        </tr>`;
                                        $("#students_list").append(row);
                        })
                    }
                })
            });
            
        });
    </script> --}}
@stop
