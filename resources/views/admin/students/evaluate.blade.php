@extends('admin.master')
<?php $name = $student->name ?>
@section('title', __('admin.Student Evaluation'))
@section('sub-title', __('admin.Evaluate').' '.$name)
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
                        <input type="hidden" value="{{ $student->id }}" name="student_id">
                        <table class="table table-striped  table-hover ">
                            <thead>
                                <tr style="background-color: #1e272f; color: #fff;">
                                    <th style="width: 40%;">{{ __('admin.Question') }}</th>
                                     <th colspan="5" style="text-align: center;">{{ __('admin.Answers') }}</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($evaluation->questions as $question)
                                    <tr>
                                        <td>{{ $question->question }}</td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">{{ __('admin.Excellent') }}
                                                <input type="radio" name="answer[{{ $question->id }}]" value="excellent">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">{{ __('admin.Very Good') }}
                                                <input type="radio" name="answer[{{ $question->id }}]" value="very good">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">{{ __('admin.Good') }}
                                                <input type="radio" name="answer[{{ $question->id }}]" value="good">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">{{ __('admin.Acceptance') }}
                                                <input type="radio" name="answer[{{ $question->id }}]" value="acceptable">
                                            </label>
                                        </td>
                                        <td>
                                            <label style="display: flex; align-items: center; gap: 4px; ">{{ __('admin.Bad') }}
                                                <input type="radio" name="answer[{{ $question->id }}]" value="bad">
                                            </label>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center m-3">
                            <p clas><i class="fas fa-info-circle text-warning"></i> Careful: <i>you <span class="text-danger">can't</span> edit this after saving</i></p>
                            <button type="submit" class="btn btn-success text-center" style="width: 200px;"><i class="fas fa-save"></i> {{ __('admin.Save') }}</button>
                            <a href="{{ route('admin.students.index') }}" class="btn btn-danger" ><i class="fas fa-times"></i> {{ __('admin.Cancel') }}</a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            
        </div>
    </div>




@stop


