@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content d-flex flex-column align-items-center">
            <h3 class="mb-5">CONTACT MESSAGES</h3>

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <!-- If contact messages count more then 0 -->
            @if (count($contact_msgs) > 0)
                <div class="contact-messages row justify-content-center p-2 w-100">

                    <!-- Loop through contact messages -->
                    @foreach ($contact_msgs as $msg)
                        <div class="col-12 col-lg-6">
                            <!-- Card -->
                            <div class="card p-0 mb-3">
                                <!-- Card header -->
                                <div class="card-header">
                                    From: <strong>{{ ucfirst($msg->name) . ' ' . ucfirst($msg->lastname) }}</strong>{{ ', ' . $msg->email }} 

                                    <!-- If wasn't repied on message, display badge -->
                                    @if ($msg->readed === NULL)
                                        <span class="float-right badge badge-pill badge-warning mt-1" title="New">
                                            New
                                        </span>
                                    @endif

                                    <!-- If was repied on message, display check mark -->
                                    @if ($msg->replied === 1)
                                        <span class="float-right" title="Replied">
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                    @endif
                                    
                                </div><!-- Card header END -->

                                <!-- Card body -->
                                <div class="card-body row justify-content-between">
                                    <div>
                                        <!-- Display 25 chars of messages in anchor tag,
                                            that leads on read-message page -->
                                        <a href="{{ route('read-cont-msgs', $msg->id) }}">
                                            {{ substr($msg->message, 0, 25) . '...' }}
                                        </a>
                                        <!-- Send date and time -->
                                        <p class="card-text">{{ $msg->created_at->format('d/m/Y, h:m') }}</p>
                                    </div>
                                    
                                    <!-- Action buttons -->
                                    <div class="float-right row">
                                        <!-- Read message button -->
                                        <a href="{{ route('read-cont-msgs', $msg->id) }}" class="mr-2 align-self-end">
                                            <button type="submit" title="Read Message"><i class="far fa-eye"></i></button>
                                        </a>
                                        
                                        <!-- If sender is authenticated user show reply button -->
                                        @if ($msg->user_id !== NULL && $msg->replied === NULL)
                                            <a href="#" data-toggle="modal" data-target="#edit{{ $msg->id }}" class="mr-2 align-self-end">
                                                <button type="submit" title="Reply Message"><i class="fas fa-reply"></i></button>
                                            </a>
                                        @endif

                                        <!-- Delete button -->
                                        <a href="" class="mr-2 align-self-end">
                                            <form action="{{ route('delete-cont-msgs', $msg->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Delete Message">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </a>

                                    </div> <!-- Action buttons END -->
                                </div> <!-- Card body END -->
                            </div> <!-- Card END -->
                        </div>

                        <!-- Reply Modal -->
                        <div class="modal fade reply-message" id="edit{{ $msg->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Reply Message form -->
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
                                    </form> <!-- Reply Message form END -->
                                </div>
                            </div>
                        </div> <!-- Reply Modal END -->
                        
                    @endforeach <!-- Loop through contact messages END -->
                </div>

                {{ $contact_msgs->links() }} <!-- Pagination links -->
            <!-- If contact messages doesn't exist, display message -->
            @else
                <p>No Contact Messages</p>
            @endif <!-- If contact messages exists END -->
        </div>
    </div>
@endsection