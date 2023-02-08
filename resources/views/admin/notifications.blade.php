@php
    use App\Models\Student;
    
@endphp
@extends('admin.master')

@section('title', 'Notifications')

@section('styles')
    <style>
        .section-50 {
            padding: 0;
            padding-bottom: 50PX
        }

        .m-b-50 {
            margin-bottom: 50px;
        }

        .dark-link {
            color: #333;
        }

        .heading-line {
            position: relative;
            padding-bottom: 5px;
        }

        .heading-line:after {
            content: "";
            height: 4px;
            width: 75px;
            background-color: #29B6F6;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .notification-ui_dd-content {
            margin-bottom: 30px;
        }

        .notification-list {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 20px;
            margin-bottom: 7px;
            background: #fff;
            -webkit-box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        }

        .notification-list--unread {
            border-left: 2px solid #29B6F6;
        }

        .notification-list .notification-list_content {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .notification-list .notification-list_content .notification-list_img img {
            height: 48px;
            width: 48px;
            border-radius: 50px;
            margin-right: 20px;
        }

        .notification-list .notification-list_content .notification-list_detail p {
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .notification-list .notification-list_feature-img img {
            height: 48px;
            width: 48px;
            border-radius: 5px;
            margin-left: 20px;
        }


        .btns {
            gap: 5px;
            width: 100%;
        }

        /* p.text-muted{
        width: 80%
    }
    @media(max-width:767px){
        p.text-muted{
        width: 100%
    }
    } */
    </style>
@stop

@section('content')

    <section class="section-50">
        <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>

        <div class="notification-ui_dd-content">
            @foreach ($auth->notifications as $notify)
                {{-- @dump( $notify->data) --}}
                {{-- @if ($notify->data['company'] == Auth::guard('company')->user()->id) --}}


                <div class="notification-list {{ $notify->read_at ? '' : 'notification-list--unread' }} ">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            <img src="{{ asset($notify->data['image']) }}" alt="user">
                        </div>
                        <div style="width: 100%">
                            <div class="notification-list_detail">
                                <p><b>{{ $notify->data['name'] }}</b> {{ $notify->data['msg'] }} </p>
                                <p>Program : {{ $notify->data['category'] }}</p>
                                <p class="text-muted">{{ $notify->data['reason'] }}</p>
                                <p class="text-muted"><small><i
                                            class="far fa-clock mr-1"></i>{{ $notify->created_at->diffForHumans() }}</small>
                                </p>
                            </div>

                            @php
                                $student = Student::where('id', $notify->data['student_id'])
                                    ->where('company_id', '!=', null)
                                    ->first();
                            @endphp
                            @if ($student)
                                <div class="btns d-flex justify-content-end">
                                    <i class="fas fa-check text-success">Approved</i>
                                </div>
                            @else
                                <div class="btns d-flex justify-content-end">
                                    <form action="{{ route('admin.accept_apply') }}" class="accept_form" id="form-{{ $notify->data['student_id'] }}">
                                        @csrf
                                        <input type="hidden" name="company_id" value="{{ $notify->data['company_id'] }}"
                                            id="">
                                        <input type="hidden" name="student_id" value="{{ $notify->data['student_id'] }}"
                                            id="">
                                        <input type="hidden" name="category_id" value="{{ $notify->data['category_id'] }}"
                                            id="">
                                        <button type="button" class="btn btn-success accept_btn"></i>Accept</button>
                                    </form>
                                    <form action="">
                                        <button type="button" class="btn btn-danger">Reject</button>

                                    </form>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            @endforeach

        </div>

        <div class="text-center">
            <a href="#!" class="dark-link">Load more activity</a>
        </div>

    </section>


@stop

@section('scripts')
    <script>
        // let form = $("#form-");
        let accept_btn = $(".accept_btn");
        // let content_div = $(".btns");

        // let url = accept_btn.parent().attr("action");

        accept_btn.parent().onsubmit = (e) => {
            e.preventDefault();
        }



        accept_btn.on("click", function() {
            let url = $(this).parent().attr("action");
            let wrapper = $(this).parents().eq(1);
            $.ajax({
                type: "GET",
                url: url,
                data: $(this).parent().serialize(),
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data);
                }
            })
        })
    </script>

@stop
