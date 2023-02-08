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


.btns{
    gap: 5px
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

@php
    use App\Models\Student;
@endphp

<section class="section-50">
        <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>

        <div class="notification-ui_dd-content">


            @foreach ($auth->notifications as $notify )



                <div class="notification-list {{ $notify->read_at ? '' : 'notification-list--unread' }} ">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            <img src="{{ asset($notify->data['image']) }}" alt="user">
                        </div>
                       <div >
                        <div class="notification-list_detail">
                            <p><b>{{ $notify->data['name'] }}</b> {{ $notify->data['msg'] }}  </p>
                            <p>Program : {{$notify->data['category']  }}</p>
                            <p class="text-muted">{{ $notify->data['reason'] }}</p>
                            <p class="text-muted"><small><i class="far fa-clock mr-1"></i>{{$notify->created_at->diffForHumans()  }}</small></p>
                        </div>

                        @php
                            $student = Student::where('id',$notify->data['student_id'] )->first();
                        @endphp


                        @if($student->company_id == null )
                        <div class="btns d-flex justify-content-end" >
                            <form action="{{ route('admin.accept_apply') }}">
                                @csrf

                                <input type="hidden" name="company_id" value="{{ $notify->data['company_id'] }}" >
                                <input type="hidden" name="student_id" value="{{ $notify->data['student_id'] }}" >
                                <input type="hidden" name="category_id" value="{{ $notify->data['category_id'] }}" >
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            <form action="">
                                <button type="button" class="btn btn-danger">Reject</button>

                            </form>
                        </div>
                        @elseif($student->company_id != Auth::user()->id)
                            <div class="d-flex justify-content-end"><span class="text-danger">Reject</span></div>
                        @elseif($student->company_id == Auth::user()->id)
                            <div class="d-flex justify-content-end"><span class="text-success">Approved</span></div>
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


    @stop
