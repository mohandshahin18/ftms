@extends('admin.master')
<?php $name = $student->name ?>
@section('title', 'Students-Evaluation')
@section('sub-title', 'Evaluate '.$name)
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
                    <div class="d-flex  justify-content-between">
                        <h4>{{ $evaluation->name }}</h4>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <form action="{{ route('admin.apply_evaluation', $evaluation) }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $student->id }}" name="student_id">name="evaluation_id">
                        <table class="table table-striped  table-hover ">
                            <thead>
                                <tr style="background-color: #1e272f; color: #fff;">
                                    <th>#</th>
                                    <th style="width: 40%;">Question</th>
                                     <th colspan="5" align="center">Answers</th>
                                    {{--<th>Student phone</th>
                                    <th>Student ID</th>
                                    <th>University name</th>
                                    <th>Specialization name</th> --}}
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($evaluation->questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ $question->question }}</td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">ممتاز
                                                <input type="radio" name="answer[{{ $question->id }}]" value="excellent">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">جيد جداً
                                                <input type="radio" name="answer[{{ $question->id }}]" value="very good">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">جيد
                                                <input type="radio" name="answer[{{ $question->id }}]" value="good">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">مقبول
                                                <input type="radio" name="answer[{{ $question->id }}]" value="acceptable">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">ضعيف
                                                <input type="radio" name="answer[{{ $question->id }}]" value="low">
                                            </label>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center m-3">
                            <button type="submit" class="btn btn-success text-center" style="width: 200px;"><i class="fas fa-save"></i> Save</button>
                            <button type="button" class="btn btn-danger" onclick="history.back()"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            
        </div>
    </div>




@stop


