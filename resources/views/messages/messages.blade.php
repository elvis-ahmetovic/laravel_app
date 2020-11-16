@extends('layouts.msg')

@section('content')
    <div class="container-fluid">
        <div class="content">

            <!-- If admon's messages exists -->
            @if (!empty($admin_messages) > 0)
                <div class="conversations-messages d-flex flex-column justify-content-between">
                    <div class="contact-admin-messages d-flex flex-column">
                        @foreach ($admin_messages as $message)
                            <div class="contact-message">
                                <div class="message-header">
                                    <h5>
                                        {{ ucfirst($message->name) . ' ' . ucfirst($message->lastname) }}
                                        <span class="float-right">{{ date('d.m.Y, H:i', strtotime($message->created_at)) }}</span>
                                    </h5>
                                </div>
                                <div class="message-body">
                                    <p>{{ $message->message }}</p>
                                </div>
                            </div>

                            <div class="admin-message">
                                <div class="message-header">
                                    <h5>
                                        Administrator
                                        <span class="float-right">{{ date('d.m.Y, H:i', strtotime($message->replied_at)) }}</span>
                                    </h5>
                                </div>
                                <div class="message-body">
                                    <p>{{ $message->reply_msg }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <form action="{{ route('delete-admin-message', $message->reply_id) }}" method="post">
                        @csrf
                        <button type="submit">Delete message</button>
                    </form>
                </div>
            <!-- If messages exists -->
            @elseif(count($messages) > 0)
                <div class="conversations-messages d-flex flex-column justify-content-between">
                    <div class="messages d-flex flex-column">
                        @foreach ($messages as $message)
                            <div class="{{ ($message->user_id_from === Auth::user()->id) ? 'my-message' : 'message' }}">
                                <div class="message-header">
                                    <h5>
                                        {{ ucfirst($message->name) . ' ' . ucfirst($message->lastname) }}
                                        <span class="float-right">{{ date('d.m.Y, H:i', strtotime($message->created_at)) }}</span>
                                    </h5>
                                </div>
                                <div class="message-body">
                                    <p>{{ $message->text }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <form action="{{ route('delete-conversation', $message->conversation_id) }}" method="post">
                        @csrf
                        <button type="submit">Delete conversation</button>
                    </form>
                </div>
                <form action="{{ route('reply-message') }}" method="POST" class="form-inline new-message-form">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $message->conversation_id }}">
                    <input type="hidden" name="msg_to" value="{{ ($message->participant_1 === Auth::user()->id) ? $message->participant_2 : $message->participant_1 }}">
                    <div class="form-group">
                        <input type="text" name="reply-msg" class="form-control mb-sm-4 mb-lg-0 @error('reply-msg') is-invalid @enderror" placeholder="Type message...">
                    </div>
                    <button type="submit">Send</button>
                </form>
            <!-- If messages or admin messages doesn't exists, display message -->
            @else
                <p class="text-center">No conversation selected</p>
            @endif
            
        </div>
    </div>
@endsection