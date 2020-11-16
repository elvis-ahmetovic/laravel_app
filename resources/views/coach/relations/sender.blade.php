@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="pt-4 pt-lg-5 sender-info">

                <h2>Sender Information</h2>

                <!-- Back on previous page -->
                <a href="{{ url()->previous() }}">Back</a>
                
                <!-- Content Card -->
                <div class="card">
                    <!-- Card Image (Users's image) -->
                    <img class="card-img-top" src="{{ asset('/storage/avatars/' . $sender->image) }}" alt="Sender's Image">

                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="card-title">{{ ucfirst($sender->name) . ' ' . ucfirst($sender->lastname) }}</h5>
                        <p class="card-text">{{ $sender->email }}</p>
                        <p class="card-text">{{ ucfirst($sender->city) }}</p>

                        <!-- Action buttons -->
                        <div class="action-btns row justify-content-center">

                            <!-- If $param in "new" that means
                                 that action comes from home page, 
                                 New Relation Requests section -->
                            @if ($param === 'new')
                                <!-- Cancel button -->
                                <form action="{{ route('cancel-request', ['relation_id' => $sender->relations_id, 'coach_id' => $sender->coach_id, 'params' => $param]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cancel m-2">Cancel</button>
                                </form>

                                <!-- Accept Relation button -->
                                <form action="{{ route('accept-relation', $sender->relations_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="accept m-2">Accept</button>
                                </form>

                            <!-- If $param in "active" that means
                                 that action comes from Active Relations page -->
                            @elseif($param === 'active')
                                <!-- Finish Relation button -->
                                <form action="{{ route('finish-relation', ['relation_id' => $sender->relations_id, 'coach_id' => $sender->coach_id, 'params' => $param]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="finish m-2">Finish</button>
                                </form>
                            @endif
                            
                            <!-- Send MEssage button -->
                            <button class="message m-2" data-toggle="modal" data-target="#msg{{ $sender->id }}">Send Message</button>
                        </div> <!-- Action buttons END -->
                    </div> <!-- Card Body END -->
                </div> <!-- Content Card END -->

                <!-- Message Modal -->
                <div class="modal fade" id="msg{{ $sender->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="msg_to" value="{{ $sender->user_id_send }}">
                                        <input type="text" class="form-control pb-0" value="{{ ucfirst($sender->name) . ' ' . ucfirst($sender->lastname) }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="msg_body" rows="12"></textarea>
                                    </div>
                                    <button type="submit" class="btn">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- Message Modal End -->
                
            </div>
        </div>
    </div>
@endsection