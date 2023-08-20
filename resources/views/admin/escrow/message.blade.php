@foreach ($messages as $message)
    @php
        $classText = $message->admin_id != 0 ? 'send' : 'receive';
    @endphp
    <li class="msg-list__item">
        <div class="msg-{{ $classText }}">
            @if ($escrow->status == 8 && $message->admin_id == 0)
                <p>{{ @$message->sender->username ?? $message->admin->username }}</p>
            @endif
            <div class="msg-{{ $classText }}__content">
                <p class="msg-{{ $classText }}__text mb-0">
                    {{ __($message->message) }}
                    <br>
                    @if ($message->file)
                        {{-- @php
                $mime_type = $message->file->getMimeType();
                $is_image = strpos($mime_type, 'image') !== false;
                $is_video = strpos($mime_type, 'video') !== false;
            @endphp --}}

                        @if (pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) == 'png' ||
                                pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) == 'jpg')
                            <img class="img-fluid imgUploadCss" src="{{ url('') }}/uploads/{{ $message->file }}"
                                alt="">
                        @else
                            <a href="{{ url('') }}/uploads/{{ $message->file }}"
                                target="_blank">{{ $message->file }}</a>
                        @endif
                    @endif
                </p>
            </div>
            <ul class="msg-{{ $classText }}__history @if ($classText == 'send') justify-content-end @endif">
                <li class="msg-receive__history-item">{{ $message->created_at->format('h:i A') }}</li>
                <li class="msg-receive__history-item">{{ $message->created_at->diffForHumans() }}</li>
            </ul>
        </div>
    </li>
@endforeach
