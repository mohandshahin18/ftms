@extends('student.master')

@section('title', 'Chat Messages')

@section('styles')
    <link rel="stylesheet" href="{{ asset('adminAssets/dist/css/mystyle.css') }}">
    <style>
        .chat-wrapper {
            background: #f4f6f9;
        }

        .chat-list {
            padding: 50px;
        }

        .chat-area,
        .chat_box {
            background: #fff;
        }
    </style>
@endsection
@section('content')

    <div class="chat-wrapper container-fluid">
        <div class="chat-list">
            <div class="chats-label">
                <h5>Chats</h5>
            </div>

            <div class="chat-boxes">

            </div>



        </div>
        <div class="chat-area">
            <header>

                <img src="{{ asset($user->image) }}" alt="">
                <div class="details">
                    <span id="student_name">{{ $user->name }}</span>
                    <p>Active now</p>
                </div>
            </header>
            <div class="chat_box">

            </div>
            <form method="POST" class="typing_area" action="{{ route('student.send.message') }}">
                @csrf
                <input type="text" value="{{ $user->slug }}" name="reciver_id" id="receiver_id" hidden>
                <input type="text" name="message" class="form-control input-field" placeholder="Type a message here..."
                    autocomplete="off">
                <button type="submit" class="message_btn"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="{{ asset('studentAssets/js/chat.js') }}"></script>
    <script>
        const userId = "{{ Auth::user()->id }}";
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('d13948d0184f21111953', {
            cluster: 'ap2',
            authEndpoint: '/broadcasting/auth',
        });

        var channel = pusher.subscribe(`private-Messages.${userId}`);
        channel.bind('new-message', function(data) {
            appendMessage(data.message.message, data.image);
            scrollToBottom();
        });
    </script>
@endsection
