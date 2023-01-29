@extends('admin.master')

@section('title', 'Settings')
@section('sub-title', 'Settings')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Setting</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.settings_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">


                            {{-- footer text  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Footer text</label>
                                    <input type="text" class="form-control @error('footer_text') is-invalid @enderror"
                                        name="footer_text" placeholder=" Footer Text" value="{{ old('footer_text',settings()->get('footer_text')) }}">
                                    @error('footer_text')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- Email Technical support  --}}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-2">Email Technical support</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder=" Email Technical support" value="{{ old('email',settings()->get('email')) }}">
                                    @error('email')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- copy right  --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Copy Right</label>
                                    <input type="text" class="form-control @error('copy_right') is-invalid @enderror"
                                        name="copy_right" placeholder=" Copy Right" value="{{ old('copy_right',settings()->get('copy_right')) }}">
                                    @error('copy_right')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- distributed_by   --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="mb-2">Distributed by</label>
                                    <input type="text" class="form-control @error('distributed_by') is-invalid @enderror"
                                        name="distributed_by" placeholder=" Distributed By"
                                        value="{{ old('distributed_by',settings()->get('distributed_by')) }}">
                                        @error('distributed_by')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                </div>
                            </div>


                            {{-- Logo  --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="mb-2">Logo</label>
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                        name="logo">
                                        <img width="70"  src="{{ asset(settings()->get('logo')) }}" alt="">

                                    @error('logo')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                    @enderror
                                </div>
                            </div>



                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add</button>
                        <button class="btn btn-dark" type="button" onclick="history.back()">
                            <i class="fas fa-undo-alt"> </i> Return Back </button>

                    </div>
                </form>
            </div>
        </div>
    </div>


@stop


@section('scripts')

    {{-- Messages Script --}}
    @if (session('msg'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            @if (session('type') == 'success')
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('msg') }}'
                })
            @elseif (session('type') == 'danger')
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
<script>


    $('input[type=file]').on('change', function(e) {
        // console.log(e.target);
        if (e.target.files && e.target.files[0]) {
            let inp = $(this)
            var reader = new FileReader();
            reader.onload = function (e) {
                // console.log(inp);
                inp.next('img').attr('src', e.target.result).width(70);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    })

</script>




@stop
