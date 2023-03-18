@forelse ($students as $student)
@php
      $message = Auth::user()->messages()
      ->where('student_id', $student->id)
      ->latest('created_at')
      ->first();

      $Lastmessage = __('admin.No messages yet!');
      $time = '';
      $unread = '';

      if($message) {    
            $Lastmessage = $message->message;

            if($message->read_at == null) {
                  $unread = 'notification-list--unread';
            }
      }
@endphp
    <a href="#" style="font-weight: unset" class="chat-circle main-msg" data-slug="{{ $student->slug }}"
        data-name="{{ $student->name }}">
        <div class="notification-list {{ $unread }}">
            <p class="open-msg">open</p>
            <div class="notification-list_content">
                <div class="notification-list_img">
                    <img src="{{ asset($student->image) }}" width="60" height="60" alt="user"
                        style="object-fit: cover; border-radius: 50%">
                </div>
                <div style="width: 100%">
                    <div class="notification-list_detail">
                        <p><b>{{ $student->name }}</b>
                            <br>{{ $Lastmessage }}
                        </p>
                        <p class="text-muted">
                              <small><i class="far fa-clock mr-1"> {{ $message ? $message->created_at->diffForHumans() : '' }}</i></small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </a>
@empty
    <div class="text-center">
        <p class=" mt-3 mb-5 text-center">{{ __('admin.NO Data Selected') }}</p>
    </div>
@endforelse