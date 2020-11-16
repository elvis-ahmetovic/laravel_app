@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content content d-flex flex-column align-items-center">
            <div class="del-read-messages align-self-start p-2 w-100">
                <div class="card p-0">
                    <div class="card-header"> 
                        From: <strong>{{ ucfirst($msg->name) . ' ' . ucfirst($msg->lastname) }}</strong>{{ ', ' . $msg->email }} <span class="float-right"><a href="{{ route('superadmin-cont-msgs') }}">Back</a></span>
                    </div>
                    <div class="card-body row justify-content-between">
                        <div class="messages p-2">
                            <div class="users-msg mb-1 p-2">
                                <p class="card-text">{{ ucfirst($msg->message) }}</p>
                                <p class="date-time">{{ $msg->created_at->format('d/m/Y, h:m') }}</p>
                            </div>

                            @if ($msg->replied === 1)
                                <div class="reply-msg p-2">
                                    <p class="card-text">{{ $msg->reply->reply_msg }}</p>
                                    <p class="date-time">{{ $msg->reply->created_at->format('d/m/Y, h:m') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="floar-right row">
                            <!-- If sender is user show reply button -->
                            @if ($msg->user_id !== NULL && $msg->replied === NULL)
                                <a href="#" data-toggle="modal" data-target="#edit{{ $msg->id }}" class="mr-2">
                                    <button type="submit" title="Reply Message"><i class="fas fa-reply"></i></button>
                                </a>
                            @endif
                            
                            <form action="{{ route('delete-cont-msgs', $msg->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Delete Message"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade reply-message" id="edit{{ $msg->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('reply-cont-msgs', $msg->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Reply Message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="contact_id" value="{{ $msg->id }}">
                                <input type="hidden" name="user_id" value="{{ $msg->user_id }}">
                                <input type="text" name="name" class="form-control mb-3" value="To: {{ ucfirst($msg->name) . ' ' . ucfirst($msg->lastname) }}" disabled>
                                <textarea name="message" class="form-control mb-3" disabled>{{ ucfirst($msg->message) }}</textarea>
                                <textarea name="reply_msg" class="form-control mb-3" cols="30" rows="10"></textarea>

                                <button type="submit" class="btn">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection