@extends('admin.master')

@section('title' , __('admin.Edit Evaluation'))
@section('sub-title' , __('admin.Evaluations'))
@section('evaluations-menu-open' , 'menu-open')
@section('evaluations-active' , 'active')
@section('add-specialization-active' , 'active')

@section('styles')
<style>
    .question_wrapper div {
        position: relative;
    }

    .question_wrapper div span {
        display: none;
        background-color: #333;
        width: 20px;
        height: 20px;
        justify-content: center;
        font-size: 36px;
        line-height: 14px;
        color: #fff;
        border-radius: 50px;
        cursor: pointer;
        position: absolute;
        right: 4px;
        top: 8px;
        transition: all 0.1s linear;

    }

    .question_wrapper div span:hover {
        background-color: red;
    }

    .question_wrapper div:hover span {
        display: flex;
    }

</style>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{ __('admin.Edit Evaluation') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.evaluations.update', $evaluation) }}" method="POST" >
                @csrf
                @method('PUT')
              <div class="card-body">
               <div class="row">
                 {{-- name --}}
                 <div class="col-lg-6">
                    <div class="form-group">
                        <label class="mb-2">{{ __('admin.Evaluation Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="Evaluation name" value="{{ old('name', $evaluation->name) }}">
                        @error('name')
                        <small class="invalid-feedback"> {{ $message }}</small>
                        @enderror
                    </div>
                    </div>

                     {{-- company --}}
                     <div class="col-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.For') }}</label>
                            <select name="evaluation_type" class="form-control" id="">
                                    <option @selected($evaluation->evaluation_type == 'company') value="company">Company</option>
                                    <option @selected($evaluation->evaluation_type == 'student') value="student">Students</option>

                            </select>
                        </div>
                    </div>

                    {{-- start date --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Starts Date') }}</label>
                            <input type="date" class="datepicker form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $evaluation->start_date) }}" name="start_date">
                            @error('start_date')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- end date --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Ends Date') }}</label>
                            <input type="date" class="datepicker form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $evaluation->end_date) }}" name="end_date">
                            @error('end_date')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>


               </div>

               <hr>
                <h4>{{ __('admin.Questions') }}</h4>

                <button id="add_question" class="btn btn-sm btn-success mb-2"><i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                <div class="question_wrapper">
                    @foreach ($evaluation->questions as $question)
                        <div>
                            <input type="text" name="questions[{{ $question->id }}]" value="{{ $question->question }}" id="" class="form-control mb-2"      placeholder="{{ __('admin.Question') }}">
                            <span class="remove_question">-</span>
                        </div>
                    @endforeach
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('admin.Edit') }}</button>
                <button  class="btn btn-dark" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop

@section('scripts')
<script>
    $("#add_question").click(function(e) {
        e.preventDefault();

        let q = `<div>
                    <input type="text" name="questions[]" id="" class="form-control mb-2"      placeholder="{{ __('admin.Question') }}">
                    <span class="remove_question">-</span>
                </div>`;

        $('.question_wrapper').append(q);
    })

    $('.question_wrapper').on('click', '.remove_question', function() {
        $(this).parent().remove();
    })

</script>
@stop
