@extends('student.master')
@section('title', 'Company-Evaluation')
@section('styles')
<style>
    .main {
        padding: 0 20px;
    }
     th {
        align-items: center
     }
</style>
@stop

@section('content')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex  justify-content-between">
                            <h4>{{ $company->name }} Evaluation</h4>
    
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <form action="{{ route('student.apply_evaluation', $evaluation) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $company->id }}" name="company_id">
                            <table class="table table-striped  table-hover ">
                                <thead>
                                    <tr style="background-color: #1e272f; color: #fff;">
                                        
                                        <th style="width: 40%;">Question</th>
                                         <th colspan="5" style="text-align: center">Answers</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($evaluation->questions as $question)
                                        <tr>
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
                                                    <input type="radio" name="answer[{{ $question->id }}]" value="bad">
                                                </label>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center m-3">
                                <p clas><i class="fas fa-info-circle text-warning"></i> Careful: <i>You <span class="text-danger">can't</span> edit this after saving</i></p>
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
    
    </div>



@stop


