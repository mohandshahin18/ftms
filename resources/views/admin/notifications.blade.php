@php
    use App\Models\Student;

@endphp
@extends('admin.master')

@section('title', __('admin.Notifications'))
@section('styles')
<style>
    .empty-state-img {
        width: 100%;
    }
    @media (min-width: 767px) {
        .empty-state-img {
            width: 600px;
        }
    }
</style>
@endsection
@section('content')

    <section class="section-50">
        <h3 class="m-b-50 heading-line">{{  __('admin.Notifications') }} <i class="fa fa-bell text-muted"></i></h3>

        <div class="notification-ui_dd-content">
            @forelse ($auth->notifications as $notify)
                
                <div class="notification-list {{ $notify->read_at ? '' : 'notification-list--unread' }} "  id="notify_{{ $notify->id }}">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            @php
                                $student = Student::where('id',$notify->data['student_id'])->first();
                                    $student = $student->image;

                                $name = $notify->data['name'] ?? '';
                                $src = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                if($student) {
                                    $img = $student;
                                    $src = asset($img);
                                }
                            @endphp

                            <img src="{{ $src }}" alt="user">
                        </div>
                        <div style="width: 100%">
                            <div class="notification-list_detail">
                                <p><b>{{ $notify->data['name'] }}</b> {{ $notify->data['msg'] }} </p>
                                <p>{{ __('admin.Program') }} : {{ $notify->data['category'] }}</p>
                                <p class="text-muted">{{ $notify->data['reason'] }}</p>
                                <p class="text-muted"><small><i
                                            class="far fa-clock mr-1"></i>{{ $notify->created_at->diffForHumans() }}</small>
                                </p>
                            </div>

                            @php
                                $student = Student::where('id', $notify->data['student_id'])

                                    ->first();
                            @endphp
                            @if ($student->company_id == Auth::user()->id)
                                <div class="btns d-flex justify-content-end">
                                    <i class="fas fa-check text-success"> {{ __('admin.Approved') }}</i>
                                </div>

                            @elseif($student->company_id == null)
                            @php
                                $company_id = $notify->data['company_id'];
                                $student_id = $notify->data['student_id'];
                                $category_id = $notify->data['category_id'];

                                $hash = hash('sha256', $company_id. $student_id. $category_id);
                            @endphp
                                <div class="btns d-flex justify-content-end">
                                    <form action="{{ route('admin.accept_apply') }}" class="accept_form" id="form-{{ $notify->data['student_id'] }}">
                                        @csrf
                                        <input type="hidden" name="hash" value="{{ $hash }}" id="">
                                        <input type="hidden" name="company_id" value="{{ $notify->data['company_id'] }}" id="">
                                        <input type="hidden" name="student_id" value="{{ $notify->data['student_id'] }}" id="">
                                        <input type="hidden" name="category_id" value="{{ $notify->data['category_id'] }}" id="">
                                        <button type="button" class="btn btn-success accept_btn"></i> {{ __('admin.Accept') }}</button>
                                    </form>
                                    <form action="{{ route('admin.reject_apply',$notify->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="hash" value="{{ $hash }}" id="">
                                        <input type="hidden" name="company_id" value="{{ $notify->data['company_id'] }}" id="">
                                        <input type="hidden" name="student_id" value="{{ $notify->data['student_id'] }}" id="">
                                        <input type="hidden" name="category_id" value="{{ $notify->data['category_id'] }}" id="">
                                        <button type="button" class="btn btn-danger reject_btn"> {{ __('admin.Reject') }}</button>

                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                {{-- @endif --}}

            @empty
                <div class="text-center">
                    <img src="{{ asset('studentAssets/img/notifications-removebg-preview.png') }}" class="img-responsive empty-state-img" alt="">
                    <h5>{{ __('admin.There is no Notifications.') }}</h5>
                </div>
            @endforelse

        </div>

        @if ($auth->notifications->count() > 5)
            <div class="text-center">
                <button type="button" class="btn-brand ">Load more activity</button>
            </div>
        @endif

    </section>


@stop

@section('scripts')
    <script>
        let accept_btn = $(".accept_btn");
        let reject_btn = $(".reject_btn");


        accept_btn.parent().onsubmit = (e) => {
            e.preventDefault();
        }




        accept_btn.on("click", function() {
            $(this).attr("disabled", true)
            let url = $(this).parent().attr("action");
            let wrapper = $(this).parents().eq(1);
            $.ajax({
                type: "GET",
                url: url,
                data: $(this).parent().serialize(),
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data);
                } ,
                error: function(data) {
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: data.responseJSON.icon,
                    title: data.responseJSON.title
                    })
                } ,
            })
        })


        reject_btn.parent().onsubmit = (e) => {
            e.preventDefault();
        }

        reject_btn.on("click", function() {
            $(this).attr("disabled", true)
            let url = $(this).parent().attr("action");
            let wrapper = $(this).parents().eq(1);
            $.ajax({
                type: "Delete",
                url: url,
                data: $(this).parent().serialize(),
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data.reject);
                    setTimeout(() => {
                        $('#notify_'+data.id).remove();
                    }, 3000);

                },
                error: function(data) {
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: data.responseJSON.icon,
                    title: data.responseJSON.title
                    })
                } ,
            })
        })


        function showMessage(data) {

}
    </script>

@stop
