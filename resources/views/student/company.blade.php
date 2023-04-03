@extends('student.master')

@section('title', $company->name)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        iframe {
            width: 100%;
        }

        .block {
            display: none;
        }
        .location h5 ,
        .location i{
            color: #ff4d29 ;
        }

        .location ul li{
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
@stop


@section('content')

    <section class="bg-light" id="reviews">
        <div class="container">
            <h2 class="text-white">{{ $company->name }} - {{ $program }}</h2>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="bg-light">
        <div class="container">
            <div class="row ">
                <div class="col-lg-7 ">
                    {!! $company->description !!}
                </div>
                <div class="col-lg-5">
                    <img src="{{ asset($company->image) }}" style="border-radius: 7px;" alt="">
                </div>
            </div>
        </div>
    </section>







@if(Auth::user()->company_id)

    <section >
        <div class="container">
                <div class="row justify-content-center text-start">
                    <div class="col-12">
                        <div class="intro">
                            <h3>{{ __('admin.Provide your opinion on the company') }}</h3>
                        </div>
                    </div>
                    <div class="col-md-10" >
                        <form action="{{ route('student.comment',Auth::user()->slug) }}" method="POST"  class="comment-form">
                            @csrf
                           <div class="row">
                            <div class=" col-md-6">
                                <div class="mb-3">
                                    <label for="">{{ __('admin.Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>

                            <div class=" col-md-6">
                                <div class="mb-3">
                                    <label for="">{{ __('admin.Email') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>

                                <div class=" col-md-12">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Comment') }}</label>
                                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="5"></textarea>
                                        @error('body')
                                            <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                        <p><b class="text-danger">* </b> {{ __('admin.Your comment will be displayed on the homepage') }}</p>
                                    </div>
                                </div>
                           </div>
                            <div class="text-end apply-div">
                                <button type="button" class="btn px-5 btn-brand btn-comment" >{{ __('admin.Send') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
        </div>
    </section>

@else
<section id="services" class="text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="intro">
                    <h6>{{ __('admin.NEED THIS?') }}</h6>
                    <h1>{{ __('admin.Apply To Our Company') }}</h1>
                </div>
            </div>
            <div class="col-md-10" id="main_content">

                    @if ($ap)
                        <p>{{ __('admin.Your application under review, we will send a notification when we approved it') }}</p>

                        <a href="{{ route('student.company_cancel', $ap->id) }}" class="btn btn-brand" id="cancle_btn">{{ __('admin.Cancel Request') }}</a>

                    @else
                        <form action="{{ route('student.company_apply', $company->id) }}" class="apply_form">
                            @csrf
                            <input type="hidden" name="company_id" class="form-control" value="{{ $company->id }}"
                                readonly>

                            @foreach ($company->categories as $category)
                                @if ($program == $category->name)
                                    <input type="hidden" name="category_id" class="form-control"
                                        value="{{ $category->id }}" readonly>
                                @endif
                            @endforeach


                            <div class="row text-start wrapper-apply">

                                <div class=" col-md-6">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Name') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-6">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Email') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>

                                <div class=" col-md-12">
                                    <div class="mb-3">
                                        <label for="">{{ __('admin.Reason') }}</label>
                                        <textarea name="reason" required class="form-control @error('reason') is-invalid @enderror" rows="5"></textarea>
                                        @error('reason')
                                            <small class="invalid-feedback"> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="text-end apply-div">
                                <button type="button" class="btn px-5 btn-brand" id="apply_btn">{{ __('admin.Apply') }}</button>
                            </div>


                        </form>
                    @endif
            </div>
        </div>
    </div>
</section>


@endif
<section class="text-center bg-light location">
    <div class="container w-100">
        <div class="row">
            <div class="col-lg-6 p-0">
                {!! $company->address !!}
            </div>
            <div class="col-lg-6">
               <div class="text-start p-5">
                    <h3 class="mb-4">{{ __('admin.Contact Us') }}</h3>
                    <h5 class="mb-4">{{ __('admin.Contact Information') }}</h5>
                    <p class="mb-5">{{ __('admin.You can contact us via email or mobile number') }}</p>
                    <ul>
                        <li class="mb-3"><i class="fas fa-envelope"></i> {{ $company->email }}</li>
                        <li><i class="fas fa-phone"></i>{{ $company->phone }}</li>
                    </ul>
               </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js"></script>

    <script>
        let applay_form = $("form.apply_form");
        let wrapper = $("#main_content");

        applay_form.onsubmit = (e) => {
            e.preventDefault();
        }

        $(wrapper).on("click", '#apply_btn', function() {
            $(this).attr("disabled", true)
            let url = applay_form.attr("action");
            $.ajax({
                url: url,
                type: "GET",
                data: applay_form.serialize(),
                beforeSend: function() {
                    $('.apply-div').empty();
                    $('.apply-div').html('<i class="fa fa-spin fa-spinner reload-apply"></i> {{ __("admin.Loading...") }}');
                },
                success: function(data) {
                    wrapper.empty();
                    wrapper.append(data.content);
                },
                error: function(data) {
                    // $('#apply_btn').attr("disabled", false)
                    $('.apply-div ').empty();
                    $('.apply-div ').html('<button type="button" class="btn px-5 btn-brand" id="apply_btn">{{ __('admin.Apply') }}</button>');




                    $('.invalid-feedback').remove();
                    $.each(data.responseJSON.errors, function (field, error) {
                        $("textarea").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');
                    });
                } ,
            })
        })

    </script>


<script>
    let btn_comment = $('.btn-comment');
    let form_comment = $(".comment-form");


    form_comment.onsubmit = (e)=> {
              e.preventDefault();

      }

      let formData = form_comment.serialize();
      let url = form_comment.attr("action");
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      btn_comment.on("click", function() {
          btn_comment.attr("disabled", true)

          $.ajax({
              type: "POST",
              url: url,
              data: form_comment.serialize(),
              beforeSend: function(data) {
              btn_comment.html('<i class="fa fa-spin fa-spinner "></i>');
                   $('.invalid-feedback').remove();
                  $('textarea').removeClass('is-invalid');
              } ,
              success: function(data) {
                  setTimeout(() => {

                  btn_comment.html('<i class="fas fa-check"></i>');

                  $('textarea').val('');

                  const Toast = Swal.mixin({
                      toast: true,
                      position: 'top-right',
                      customClass: {
                          popup: 'colored-toast'
                      },
                      showConfirmButton: false,
                      timer: 2000,
                      timerProgressBar: false,
                      didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                      })

                      Toast.fire({
                      icon: 'success',
                      title: '{{ __('admin.Comment has been send') }}'
                      })
                      }, 1500);

              setTimeout(() => {
                  btn_comment.html('{{ __('admin.Send') }}');
                  btn_comment.removeAttr("disabled");
              }, 2000);


              } ,
              error: function(data) {
                  btn_comment.attr("disabled", false)
                  btn_comment.html('{{ __('admin.Send') }}');
                  $('.invalid-feedback').remove();
                  $.each(data.responseJSON.errors, function (field, error) {
                  $("textarea").addClass('is-invalid').after('<small class="invalid-feedback">' +error+ '</small>');

                  });
              } ,
          })

      });


</script>

@stop
