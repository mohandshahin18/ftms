@extends('admin.master')

@section('title' , 'Add New Evaluation')
@section('sub-title' , 'Evaluations')
@section('evaluations-menu-open' , 'menu-open')
@section('evaluations-active' , 'active')
@section('add-specialization-active' , 'active')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Evaluation</h3>
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
                        <label class="mb-2">Evaluation name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="Evaluation name" value="{{ old('name') }}">
                        @error('name')
                        <small class="invalid-feedback"> {{ $message }}</small>
                        @enderror
                    </div>
                    </div>

                     {{-- company --}}
                     <div class="col-6">
                        <div class="form-group">
                            <label class="mb-2">Company</label>
                            <select name="company_id" class="form-control" id="">
                                <option data-display="Select company">Select company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     {{-- university --}}
                     <div class="col-6">
                        <div class="form-group">
                            <label class="mb-2">Student</label>
                            <select name="student_id" class="form-control" id="">
                                <option data-display="Select student">Select student</option>
                                @foreach ($universities as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

               </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add</button>
                <button  class="btn btn-dark" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> Return Back </button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop
