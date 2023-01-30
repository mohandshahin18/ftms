@extends('admin.master')
<?php $name = $student->name ?>
@section('title', 'Evaluation Page')
@section('sub-title', 'Student Evaluation ')
@section('students-menu-open', 'menu-open')
@section('students-active', 'active')

@section('styles')
<style>
    /* th {
        text-align: center;
    } */
</style>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex  justify-content-between align-items-center">
                        <div>
                            <h4>{{ $applied_evaluation->evaluation->name }}</h4>
                            <h5>Student Name: <strong class="text-primary"> {{ $student->name }}</strong></h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.export_pdf', $student) }}" class="btn btn-primary mb-2"><i class="fas fa-pdf"> Export as PDF</i></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped  table-hover ">
                        <thead>
                            <tr style="background-color: #1e272f; color: #fff;">
                                <th style="width: 60%;">Question</th>
                                 <th>Answer</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $id => $answer)
                                <tr>
                                    <td>{{ get_question_name($id) }}</td>
                                    <td>{{ $answer }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            
        </div>
    </div>




@stop


