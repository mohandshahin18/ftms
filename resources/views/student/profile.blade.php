@extends('student.master')

@section('title', Auth::guard()->user()->name)
@section('sub-title', 'Profile')
@section('styles')
<style>
.bg-light{
    height:100%;
}

</style>
@stop
@section('content')
<div class="bg-light">
<div class="container ">
    <div class="box-all  ">
        <form action="{{ route('student.profile_edit' ,Auth::guard()->user()->slug ) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row  ">
            <div class="col-md-4 mt-5 ">
                <div class="info bg-white shadow  rounded mr-3  alig-content-center">
                    <div class="d-flex flex-column align-items-center text-center p-2 py-2">


                        @php

                            if (Auth::guard()->user()->image) {
                                $img = Auth::guard()->user()->image;
                                $src = asset($img);
                            } else {
                                $src = asset('adminAssets/dist/img/no-image.png');
                            }

                        @endphp


                        <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_user_avatar_3">
                            <div class="kt-avatar__holder" style="background-image: url({{ $src }})"></div>
                            <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="Change avatar">
                                <i class='bx bxs-pencil'></i>
                                <input type="file" name="image" id="image">
                            </label>
                        </div>



                        <span class="font-weight-bold mt-3">{{ Auth::guard()->user()->name }}</span>
                        <span class="text-black-50 mb-3">{{ Auth::guard()->user()->email }}</span><span> </span>
                    </div>
                </div>
            </div>
            <div class=" col-md-8 mt-5 ">
                <div class="p-3 bg-white shadow rounded mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="labels">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ Auth::guard()->user()->name }}">
                                @error('name')
                                        <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="labels">Email</label>
                            <input type="text" name="email" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::guard()->user()->email }}"
                                placeholder="Email">
                                @error('name')
                                <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="labels">Phone</label>
                            <input type="text" name="phone" class="form-control @error('name') is-invalid @enderror" placeholder="Phone"
                                value="{{ Auth::guard()->user()->phone }}">
                                @error('name')
                                <small class="invalid-feedback"> {{ $message }}</small>
                                @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="labels">Student ID</label>
                            <input type="text" name="" class="form-control " disabled  value="{{ Auth::guard()->user()->student_id }}">
                        </div>


                        <div class="col-md-6 mb-3">
                            <label class="labels">University</label>
                            <input type="text" name="" class="form-control " disabled  value="{{ $university }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="labels">Specialization</label>
                            <input type="text" name="" class="form-control " disabled  value="{{ $specialization }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="labels">Your Teacher</label>
                            <input type="text" name="" class="form-control " disabled  value="{{ $teacher }}">
                        </div>



                    </div>


                    <div class="mt-2 ">
                        <button class="btn btn-primary profile-button"  type="submit"> Save Edit </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>






</div>
</div>
@stop



@section('scripts')
<script>




   </script>

{{-- Messages Script --}}
@if (session('msg'))
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
        "use strict";

        /**
         * @class KApp
         */

        var KTApp = function() {
            // /** @type {object} colors State colors **/
            // var colors = {};



        }();




        // plugin setup
        var KTAvatar = function(elementId, options) {
            // Main object
            var the = this;
            var init = false;

            // Get element object
            var element = KTUtil.get(elementId);
            var body = KTUtil.get('body');

            if (!element) {
                return;
            }

            // Default options
            var defaultOptions = {};

            ////////////////////////////
            // ** Private Methods  ** //
            ////////////////////////////

            var Plugin = {
                /**
                 * Construct
                 */

                construct: function(options) {
                    if (KTUtil.data(element).has('avatar')) {
                        the = KTUtil.data(element).get('avatar');
                    } else {
                        // reset menu
                        Plugin.init(options);

                        // build menu
                        Plugin.build();

                        KTUtil.data(element).set('avatar', the);
                    }

                    return the;
                },

                /**
                 * Init avatar
                 */
                init: function(options) {
                    the.element = element;
                    the.events = [];

                    the.input = KTUtil.find(element, 'input[type="file"]');
                    the.holder = KTUtil.find(element, '.kt-avatar__holder');
                    the.cancel = KTUtil.find(element, '.kt-avatar__cancel');
                    the.src = KTUtil.css(the.holder, 'backgroundImage');

                    // merge default and user defined options
                    the.options = KTUtil.deepExtend({}, defaultOptions, options);
                },

                /**
                 * Build Form Wizard
                 */
                build: function() {
                    // Handle avatar change
                    KTUtil.addEvent(the.input, 'change', function(e) {
                        e.preventDefault();

                        if (the.input && the.input.files && the.input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                KTUtil.css(the.holder, 'background-image', 'url(' + e.target
                                    .result + ')');
                            }
                            reader.readAsDataURL(the.input.files[0]);

                            KTUtil.addClass(the.element, 'kt-avatar--changed');
                        }
                    });


                },


            };




            // Construct plugin
            Plugin.construct.apply(the, [options]);

        };





        var KTUtil = function() {
            var resizeHandlers = [];





            return {




                // Deep extend:  $.extend(true, {}, objA, objB);
                deepExtend: function(out) {
                    out = out || {};

                    for (var i = 1; i < arguments.length; i++) {
                        var obj = arguments[i];

                        if (!obj)
                            continue;

                        for (var key in obj) {
                            if (obj.hasOwnProperty(key)) {
                                if (typeof obj[key] === 'object')
                                    out[key] = KTUtil.deepExtend(out[key], obj[key]);
                                else
                                    out[key] = obj[key];
                            }
                        }
                    }

                    return out;
                },


                get: function(query) {
                    var el;

                    if (query === document) {
                        return document;
                    }

                    if (!!(query && query.nodeType === 1)) {
                        return query;
                    }

                    if (el = document.getElementById(query)) {
                        return el;
                    } else if (el = document.getElementsByTagName(query), el.length > 0) {
                        return el[0];
                    } else if (el = document.getElementsByClassName(query), el.length > 0) {
                        return el[0];
                    } else {
                        return null;
                    }
                },
                find: function(parent, query) {
                    parent = KTUtil.get(parent);
                    if (parent) {
                        return parent.querySelector(query);
                    }
                },


                data: function(element) {

                    return {



                        has: function(name) {




                        },


                    };
                },




                css: function(el, styleProp, value) {


                    if (value !== undefined) {
                        el.style[styleProp] = value;
                    } else {
                        var defaultView = (el.ownerDocument || document).defaultView;

                    }
                },


                addEvent: function(el, type, handler, one) {
                    el = KTUtil.get(el);

                    if (typeof el !== 'undefined' && el !== null) {
                        el.addEventListener(type, handler);
                    }
                },




                ready: function(callback) {
                    if (document.attachEvent ? document.readyState === "complete" : document.readyState !==
                        "loading") {
                        callback();
                    } else {
                        document.addEventListener('DOMContentLoaded', callback);
                    }
                },


            }
        }();



        // Class definition
        var KTAvatarDemo = function() {
            // Private functions
            var initDemos = function() {
                var avatar1 = new KTAvatar('kt_user_avatar_1');
                var avatar2 = new KTAvatar('kt_user_avatar_2');
                var avatar3 = new KTAvatar('kt_user_avatar_3');
                var avatar4 = new KTAvatar('kt_user_avatar_4');
            }

            return {
                // public functions
                init: function() {
                    initDemos();
                }
            };
        }();

        KTUtil.ready(function() {
            KTAvatarDemo.init();
        });
    </script>
@stop