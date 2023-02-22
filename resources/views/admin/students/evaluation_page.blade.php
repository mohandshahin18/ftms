@extends('admin.master')
<?php $name = $student->name ?>
@section('title', __('admin.Evaluation Page'))
@section('sub-title', __('admin.Student Evaluation'))
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
                    <div><button class="btn btn-secondary btn-sm mb-3" onclick="history.back()">@if (app()->getLocale()=='ar')
                            <i class="fas fa-arrow-right"></i></button></div>
                        @else
                            <i class="fas fa-arrow-left"></i></button></div>
                        @endif
                        
                    <div class="d-flex  justify-content-between align-items-center">
                        <div>
                            <h5>{{ __('admin.Student Name') }}: <strong style="color: #22486a;"> {{ $student->name }}</strong></h5>
                            <h6>{{ __('admin.Total rate') }}: <b>{{ $average_score }}%</b></h6>
                        </div>
                        <div>
                            <a href="{{ route('admin.export_pdf', $student) }}" class="btn btn-primary mb-2"><i class="fas fa-pdf"> {{ __('admin.Export as PDF') }}</i></a>
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
                <div class="m-3 text-center">
                    <button class="btn btn-outline-secondary" onclick="history.back()">
                        @if (app()->getLocale() == 'ar')
                            <i class="fas fa-arrow-right"></i>
                        @else
                            <i class="fas fa-arrow-left"></i>
                        @endif
                         {{ __('admin.Return Back') }}</button>
                </div>
            </div>
            <!-- /.card -->

        </div>
    </div>




@stop


