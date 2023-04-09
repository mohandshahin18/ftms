@php
    $auth = Auth::user();
    use App\Models\Message;
@endphp

@if ($companies)
    @foreach ($companies as $company)
        @php
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';
            
            $message = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', 'admin'],
                    ['receiver_id', $company->id],
                    ['receiver_type', 'company'],
                ])
                ->orWhere([
                    ['sender_id', $company->id],
                    ['sender_type', 'company'],
                    ['receiver_id', $auth->id],
                    ['receiver_type', 'admin'],
                ])
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                // $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';
                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }
            
            $src = $company->image ? asset($company->image) : 'https://ui-avatars.com/api/?background=random&name=' . $company->name;

        @endphp

        <a href="" style="font-weight: unset" class="chat-circle main-msg" data-slug="{{ $company->slug }}"
            data-name="{{ $company->name }}"
            data-id="{{ $company->id }}"
            data-type="company">
            <div class="notification-list ' . $unread . '">
                <p class="open-msg">open</p>
                <div class="notification-list_content">
                    <div class="notification-list_img">
                        <img src="{{ $src }}" width="60" height="60" alt="user"
                            style="object-fit: cover; border-radius: 50%">
                    </div>
                    <div style="width: 100%">
                        <div class="notification-list_detail">
                            <p><b>{{ $company->name }}</b>
                                <br>{{ $lastMessage }}
                            </p>
                            <p class="text-muted"><small class="{{ $time == null ? 'd-none' : '' }}"><i class="far fa-clock mr-1"></i>{{ $time }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@elseif ($trainers)
    @foreach ($trainers as $trainer)
        @php
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';
            
            $message = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', 'admin'],
                    ['receiver_id', $trainer->id],
                    ['receiver_id', 'trainer'],
                ])
                ->orWhere([
                    ['sender_id', $trainer->id],
                    ['sender_type', 'trainer'],
                    ['receiver_id', $auth->id],
                    ['receiver_id', 'amdin'],
                ])
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
            
                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }
            
            if ($trainer->image) {
                $src = asset($trainer->image);
            } else {
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $trainer->name;
            }
        @endphp

        <a href="" style="font-weight: unset" class="chat-circle main-msg" data-slug="{{ $trainer->slug }}"
            data-name="{{ $trainer->name }}"
            data-id="{{ $trainer->id }}"
            data-type="trainer">>
            <div class="notification-list ' . $unread . '">
                <p class="open-msg">open</p>
                <div class="notification-list_content">
                    <div class="notification-list_img">
                        <img src="{{ $src }}" width="60" height="60" alt="user"
                            style="object-fit: cover; border-radius: 50%">
                    </div>
                    <div style="width: 100%">
                        <div class="notification-list_detail">
                            <p><b>{{ $trainer->name }}</b>
                                <br>{{ $lastMessage }}
                            </p>
                            <p class="text-muted"><small class="{{ $time == null ? 'd-none' : '' }}"><i class="far fa-clock mr-1"></i>{{ $time }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@else
    @foreach ($students as $student)
        @php
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';

            if(Auth::guard('company')->check()) {
                $role = 'company';
            } elseif (Auth::guard('trainer')->check()) {
                $role = 'trainer';
                
            } else {
                $role = 'teacher';
            }
            
            $message = Message::where([
                    ['sender_id', $auth->id],
                    ['sender_type', $role],
                    ['receiver_id', $student->id],
                    ['receiver_type', 'student'],
                ])
                ->orWhere([
                    ['sender_id', $student->id],
                    ['sender_type', 'student'],
                    ['receiver_id', $auth->id],
                    ['receiver_type', $role],
                ])
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
            
                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }
            
            if ($student->image) {
                $src = asset($student->image);
            } else {
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $student->name;
            }
        @endphp

        <a href="" style="font-weight: unset" class="chat-circle main-msg" data-slug="{{ $student->slug }}"
            data-name="{{ $student->name }}"
            data-id="{{ $teacher->id }}"
            data-type="teacher">>
            <div class="notification-list ' . $unread . '">
                <p class="open-msg">open</p>
                <div class="notification-list_content">
                    <div class="notification-list_img">
                        <img src="{{ $src }}" width="60" height="60" alt="user"
                            style="object-fit: cover; border-radius: 50%">
                    </div>
                    <div style="width: 100%">
                        <div class="notification-list_detail">
                            <p><b>{{ $student->name }}</b>
                                <br>{{ $lastMessage }}
                            </p>
                            <p class="text-muted"><small class="{{ $time == null ? 'd-none' : '' }}"><i class="far fa-clock mr-1"></i>{{ $time }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endif
