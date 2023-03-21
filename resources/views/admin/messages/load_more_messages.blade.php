@php
    $auth = Auth::user();
@endphp

@if ($companies)
    @foreach ($companies as $company)
        @php
            $lastMessage = __('admin.No messages yet!');
            $time = '';
            $unread = '';
            
            $message = $auth
                ->messages()
                ->where('company_id', $company->id)
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';
            
                if ($message->read_at == null) {
                    $unread = 'notification-list--unread';
                }
            }
            
            if ($company->image) {
                $src = asset($company->image);
            } else {
                $src = 'https://ui-avatars.com/api/?background=random&name=' . $company->name;
            }
        @endphp

        <a href="" style="font-weight: unset" class="chat-circle main-msg" data-slug="{{ $company->slug }}"
            data-name="{{ $company->name }}">
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
                            <p class="text-muted">{{ $time }}</p>
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
            
            $message = $auth
                ->messages()
                ->where('trainer_id', $trainer->id)
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';
            
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
            data-name="{{ $trainer->name }}">
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
                            <p class="text-muted">{{ $time }}</p>
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
            
            $message = $auth
                ->messages()
                ->where('student_id', $student->id)
                ->latest('created_at')
                ->first();
            
            if ($message) {
                $lastMessage = $message->message;
                $time = $message->created_at->diffForHumans();
                $time = '<small><i class="far fa-clock mr-1"></i>' . $time . '</small>';
            
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
            data-name="{{ $student->name }}">
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
                            <p class="text-muted">{{ $time }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endif
