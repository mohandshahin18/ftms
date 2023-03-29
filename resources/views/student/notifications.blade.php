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
            border-left: 2px solid #d64022;
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

        a:hover {
            text-decoration: none
        }

        @media (min-width: 767px) {
            .empty-state-img {
                width: 430px;
            }
        }
    </style>

    @if (app()->getLocale()=='ar')
        <style>
            .heading-line:after {
                bottom: -8px;
            }
        </style>
    @endif
@stop
@php
    use App\Models\Company;
    use App\Models\Trainer;

@endphp
@section('content')


    <div class="container mt-5">
        <section class="section-50">
            <h3 class="m-b-50 heading-line">{{ __('admin.Notifications') }} <i class="fa fa-bell text-muted"></i></h3>

            <div class="notification-ui_dd-content">
                {{-- @dump($noti ); --}}
                @forelse ($auth->notifications as $notify)
                    <a href="{{ route('student.mark_read', $notify->id) }}" style="font-weight: unset">
                        <div class="notification-list {{ $notify->read_at ? '' : 'notification-list--unread' }} ">
                            <div class="notification-list_content">
                                <div class="notification-list_img">
                                    @php
                                        if ($notify->data['from'] == 'apply') {
                                            $company = Company::where('id', $notify->data['company_id'])->first();
                                            $company = $company->image;

                                            $name = $notify->data['name'] ?? '';
                                            $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                            if ($company) {
                                                $img = $company;
                                                $notifySrc = asset($img);
                                            }
                                        } elseif ($notify->data['from'] == 'task') {
                                            $trainer = Trainer::where('id', $notify->data['trainer_id'])->first();
                                            $trainer = $trainer->image;

                                            $name = $notify->data['name'] ?? '';
                                            $notifySrc = 'https://ui-avatars.com/api/?background=random&name=' . $name;
                                            if ($trainer) {
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
                                        @if ($notify->data['from'] == 'apply')
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
                @empty
                    <div class="text-center">
                        <img src="{{ asset('studentAssets/img/notifications.jpg') }}" class="img-responsive empty-state-img" alt="">
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

    </div>
@stop
