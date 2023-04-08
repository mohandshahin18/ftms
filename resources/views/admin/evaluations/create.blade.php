@extends('admin.master')

@section('title' , __('admin.Add New Evaluation'))
@section('sub-title' , __('admin.Evaluations'))
@section('evaluations-menu-open' , 'menu-open')
@section('evaluations-active' , 'active')
@section('add-evaluations-active' , 'active')

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
        color: #fff;
        border-radius: 50px;
        cursor: pointer;
        position: absolute;
        right: 4px;
        top: 8px;
        transition: all 0.1s linear;
        justify-content: center;
        align-items: center;

    }

    .question_wrapper div span:hover {
        background-color: red;
    }

    .question_wrapper div:hover span {
        display: flex;
    }

</style>

@if(app()->getLocale()=='ar')
<style>
.question_wrapper div span {

    right: unset !important;
    left: 4px !important;
}


</style>
@endif

@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{ __('admin.Add New Evaluation') }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('admin.evaluations.store') }}" method="POST" >
                @csrf
              <div class="card-body">
               <div class="row">
                 {{-- name --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Evaluation Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="{{ __('admin.Evaluation Name') }}" value="{{ old('name') }}">
                            @error('name')
                            <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                     {{-- type --}}
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.For') }}</label>
                            <select name="evaluation_type" class="form-control" id="">
                                <option value="company">{{ __('admin.Companies') }}</option>
                                <option value="student">{{ __('admin.Students') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- start date --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Starts Date') }}</label>
                            <input type="date" class="datepicker form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" name="start_date">
                            @error('start_date')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- end date --}}
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">{{ __('admin.Ends Date') }}</label>
                            <input type="date" class="datepicker form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" name="end_date">
                            @error('end_date')
                                <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>



               </div>
               <hr>
                <h4>{{ __('admin.Questions') }}</h4>

                <button id="add_question" class="btn btn-sm btn-success mb-2 btn-flat"><i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

                <div class="question_wrapper">

                </div>


              </div>
              <!-- /.card-body -->


              <div class="card-footer">
                  <button  class="btn btn-dark btn-flat" type="button" onclick="history.back()">
                      <i class="fas fa-undo-alt"> </i> {{ __('admin.Return Back') }} </button>
                <button type="submit" class="btn btn-primary btn-flat">
                    <i class="fas fa-plus"></i> {{ __('admin.Add') }}</button>

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
