@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content content d-flex flex-column align-items-center">
            <h3 class="mb-5">DELETED MESSAGES</h3>

            <!-- If deleted contact messages count more then 0 -->
            @if (count($contact_msgs) > 0)
                <div class="del-read-messages align-self-start p-2 w-100">

                    <!-- Loop through deleted contact messages -->
                    @foreach ($contact_msgs as $msg)

                        <!-- Card -->
                        <div class="card p-0 mb-3">
                            <!-- Card header -->
                            <div class="card-header">
                                From: <strong>{{ ucfirst($msg->name) . ' ' . ucfirst($msg->lastname) }}</strong>{{ ', ' . $msg->email }} 
                            </div> 
                            <!-- Card body -->
                            <div class="card-body row justify-content-between">
                                <!-- Messages -->
                                <div class="messages p-2">
                                    <!-- User's contact message -->
                                    <div class="users-msg mb-1 p-2">
                                        <p class="card-text">{{ ucfirst($msg->message) }}</p>
                                        <p class="date-time">{{ $msg->created_at->format('d/m/Y') }}</p>
                                    </div>

                                    <!-- If is replied on message -->
                                    @if ($msg->replied === 1)
                                        <div class="reply-msg p-2">
                                            <p class="card-text">{{ $msg->reply->reply_msg }}</p>
                                            <p class="date-time">{{ $msg->reply->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    @endif
                                </div> <!-- Messages END -->
                                
                                <!-- Action button -->
                                <div class="floar-right row">
                                    <!-- If isn't replied on message -->
                                    @if ($msg->user_id !== NULL && $msg->replied === NULL)
                                        <!-- Reply button -->
                                        <a href="#" data-toggle="modal" data-target="#edit{{ $msg->id }}" class="mr-2">
                                            <button type="submit" title="Reply Message"><i class="fas fa-reply"></i></button>
                                        </a>
                                    @endif
                                </div> <!-- Action button END -->
                            </div> <!-- Card body END -->
                        </div> <!-- Card END -->

                        <!-- Reply Modal -->
                        <div class="modal fade reply-message" id="edit{{ $msg->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Reply Message form -->
                                    <form action="{{ route('reply-cont-msgs', $msg->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
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

                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form><!-- Reply Message form END -->
                                </div>
                            </div>
                        </div> <!-- Reply Modal END -->
                    @endforeach <!-- Loop through deleted contact messages END -->
                </div>

                {{ $contact_msgs->links() }} <!-- Pagination links -->
            <!-- If deleted contact messages doesn't exist, display message -->
            @else
                <p>No Deleted Messages</p>
            @endif <!-- If deleted contact messages exists END -->
        </div>
    </div>
@endsection