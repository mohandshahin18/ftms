
@extends('student.master')

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
            background-color: #1a2e44;
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
            border-left: 2px solid #1a2e44;
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
            object-fit: cover;
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

        a:hover{
            text-decoration: none
        }

    </style>
@stop
@php
use App\Models\Company;
use App\Models\Trainer;

// $noti = $auth->notification->paginate(2);
@endphp
@section('content')


<div class="container mt-5">
    <section class="section-50">
        <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>

        <div class="notification-ui_dd-content">
            {{-- @dump($noti ); --}}
            @foreach ($auth->notifications as $notify)

                <a href="{{ $notify->data['url'] }}" style="font-weight: unset">
                    <div class="notification-list {{ $notify->read_at ? '' : 'notification-list--unread' }} ">
                        <div class="notification-list_content">
                            <div class="notification-list_img">
                                @php
                                if ($notify->data['from'] == 'apply') {
                                    $company = Company::where('id',$notify->data['company_id'])->first();
                                    $company = $company->image;

                                    $name = $notify->data['name'] ?? '';
                                    $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                    if($company) {
                                        $img = $company;
                                        $notifySrc = asset($img);
                                    }
                                    }elseif ($notify->data['from'] == 'task') {
                                        $trainer = Trainer::where('id',$notify->data['trainer_id'])->first();
                                        $trainer = $trainer->image;

                                        $name = $notify->data['name'] ?? '';
                                        $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                        if($trainer) {
                                            $img = $trainer;
                                            $notifySrc = asset($img);
                                        }
                                    }
                                @endphp
                                <img src="{{ $notifySrc }}" alt="user">
                            </div>
                            <div style="width: 100%">
                                <div class="notification-list_detail">
                                    <p><b>{{ $notify->data['name'] }}</b> {{ $notify->data['msg'] }} </p>
                                    @if($notify->data['from'] == 'apply')
                                        <p class="text-muted">{{ $notify->data['welcome'] }}</p>
                                    @endif
                                    <p class="text-muted"><small><i
                                                class="far fa-clock mr-1"></i>{{ $notify->created_at->diffForHumans() }}</small>
                                    </p>
                                </div>




                            </div>
                        </div>
                    </div>
                </a>
                {{-- @endif --}}
            @endforeach

        </div>

        <div class="text-center">
            <butaton type="button" class="btn-brand ">Load more activity</butaton>
        </div>

    </section>

</div>
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
                } ,
                error: function(data) {
                        // console.log(data.title);
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
