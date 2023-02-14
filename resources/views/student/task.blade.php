@extends('student.master')

@section('title', $task->main_title)

@section('styles')
    <style>

        .task{
            background: #f8f9fa;
        }
        .divider{
            border-bottom: 1px solid #ccc;
        }
        th{
            width: 220px
        }
    </style>
@stop


@section('content')

    <section  id="reviews">
        <div class="container">
            <h1 class="text-white">{{ $task->main_title }} - {{ $task->sub_title }}</h1>
        </div>
    </section>

    <!-- ABOUT -->
    <section style="padding-top:30px ">
        <div class="container">
            <div class="row ">
                <div class="col-lg-12 ">
                    <div class="task rounded p-3">
                        <p><b>Opend: </b>{{ Carbon::parse($task->start_date)->format('l, j F Y, g:i A') }}</p>
                        <p><b>Due: </b>{{ Carbon::parse($task->end_date)->format('l, j F Y, g:i A') }}</p>

                        <div class="divider"></div>
                        <div class="desc mb-5 mt-3">
                            {!! $task->description !!}

                        </div>
                        {{ $task->file }}
                    </div>

                    <h3 class="my-4">Submission status</h3>

                    <table class="table table-striped table-bordered table-hover">

                        <tbody>
                          <tr>
                            <th >Submission status</th>
                            <td>Mark</td>

                          </tr>
                          <tr>
                            <th>Time remaining</th>
                            <td>Jacob</td>

                          </tr>
                          <tr>
                            <th >File submissions</th>
                            <td>Larry</td>

                          </tr>
                        </tbody>
                      </table>


                </div>
                <div class="col-lg-4">
                    {{-- <img src="{{ asset($company->image) }}" style="border-radius: 20px;" alt=""> --}}
                </div>
            </div>
        </div>
    </section>






{{-- @endif --}}
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>



    @if(session('msg'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if(session('type') == 'success')
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'danger')
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'warning')
                Toast.fire({
                    icon: 'warning',
                    title: '{{ session('msg') }}'
                })
            @else
                Toast.fire({
                    icon: 'info',
                    title: '{{ session('msg') }}'
                })
            @endif
        </script>
    @endif
@stop
