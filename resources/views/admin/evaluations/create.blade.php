@extends('admin.master')

@section('title' , 'Add New Evaluations')
@section('sub-title' , 'Evaluations')
@section('evaluations-menu-open' , 'menu-open')
@section('evaluations-active' , 'active')
@section('add-specialization-active' , 'active')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New Evaluations</h3>
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
                            <label class="mb-2">Evaluations name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="Evaluations name" value="{{ old('name') }}">
                            @error('name')
                            <small class="invalid-feedback"> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                     {{-- student --}}
                     <div class="col-6">
                        <div class="form-group">
                            <label class="mb-2">Student</label>
                            <select name="student_id" class="form-control" id="">
                                <option data-display="Select Student">Select student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                     {{-- company --}}
                     <div class="col-6">
                        <div class="form-group">
                            <label class="mb-2">Company</label>
                            <select name="company_id" class="form-control" id="">
                                <option data-display="Select Company">Select company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    

               </div>
               <hr>
                <h4>Questions</h4>

                <button class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add</button>
              </div>
              <!-- /.card-body -->
                
                
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Save</button>
                <button  class="btn btn-dark" type="button" onclick="history.back()">
                    <i class="fas fa-undo-alt"> </i> Return Back </button>

              </div>
            </form>
          </div>
    </div>
</div>


@stop
