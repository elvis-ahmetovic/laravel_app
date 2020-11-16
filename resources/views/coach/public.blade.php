@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex flex-column justify-content-center public">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Coach's Info -->
            <div class="row justify-content-center align-items-center">

                <!-- Left Column -->
                <div class="col-12 col-lg-6 left-column">
                    <div class="col-12 card p-0 mb-3 mb-lg-0">
                        <div class="card-header">
                            <h5 class="card-title">{{ ucfirst($coach->user->name) . ' ' . ucfirst($coach->user->lastname) }}</h5>
                            <div class="row justify-content-between">
                                <p class="card-text">{{ ucfirst($coach->category->name) }}</p>
                                <p class="card-text">{{ ucfirst($coach->user->city) }}</p>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column flex-xl-row align-items-center">
                            <div class="pr-xl-3">
                                <img src='/storage/avatars/{{ $coach->user->image }}' alt="Coach Image">
                            </div>
                            <div>
                                <p class="card-text">Email: <span>{{ $coach->user->email }}</span></p>
                                <p class="card-text">Price: <span>{{ $coach->price }} &euro; per hour</span></p>
                                <p class="card-text">Phone: 
                                    <!-- Only registered userc can see coach's phone number -->
                                    @guest
                                        <span>Only registered users</span>
                                    @else
                                        <span>{{ $coach->phone }}</span>
                                    @endguest 
                                </p>
                            </div>
                            @guest
                            @else
                                <!-- Loop through relations -->
                                @foreach ($relations as $relation)

                                    <!-- 
                                        If relation active is NULL
                                        and relation canceled is NULL
                                        and finished is NULL
                                        Display "Request Send"
                                     -->
                                    @if (Auth::user()->id === $relation->user_id_send && 
                                        $coach->id === $relation->coach_id && 
                                        $relation->active === NULL && 
                                        $relation->canceled === NULL &&
                                        $relation->finished === NULL)
                                        <div class="request py-1 pl-1 pr-2">
                                            Request Sent
                                        </div>
                                    <!-- 
                                        Else If relation active is 1
                                        Display "Active"
                                     -->
                                    @elseif(Auth::user()->id === $relation->user_id_send && 
                                            $coach->id === $relation->coach_id && 
                                            $relation->active === 1)
                                        <div class="relation py-1 pl-1 pr-2">
                                            Active
                                        </div>
                                    @endif
                                @endforeach <!-- Loop through relations END -->
                            @endguest
                        </div>
                        
                    </div>
                </div><!-- Left Column End -->

                <!-- Right Column -->
                <div class="col-12 col-lg-6 right-column">
                    <div class="col-12 card p-0">
                        <div class="card-header">
                            <h5 class="card-title">{{ ucfirst($coach->msg_title) }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="align-self-start">
                                <p class="card-text">{{ $coach->msg_body }}</p>
                            </div>
                        </div>
                    </div>
                </div> <!-- Right Column End -->

            </div> <!-- Main Info End -->

            <!-- Buttons -->
            <div class="row justify-content-center mt-5 buttons">
                <!-- If is guest -->
                @guest
                    <a href="" class="btn message" data-toggle="modal" data-target="#msg{{ $coach->id }}" disabled>Send Message</a>
                <!-- If is authenticated user -->
                @elseif(Auth::user()->role === 'user')
                    <!-- If relation exists -->
                    @if(count($relations) > 0) 
                        <!-- Loop through relations -->
                        @foreach ($relations as $relation)
                            <!-- 
                                If relation active is NULL
                                and relation canceled is NULL
                                and finished is NULL
                            -->
                            @if (Auth::user()->id === $relation->user_id_send && 
                                $coach->id === $relation->coach_id && 
                                $relation->active === NULL && 
                                $relation->canceled === NULL &&
                                $relation->finished === NULL)

                                <!-- Display "Cancel Request" button -->
                                <form action="{{ route('cancel-request', ['relation_id' => $relation->id, 'coach_id' => $coach->id, 'params' => $params]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn mb-3 mb-lg-0 cancel">Cancel Request</button>
                                </form>
                            <!-- 
                                If relation active is 1
                                and relation canceled is NULL
                            -->
                            @elseif(Auth::user()->id === $relation->user_id_send && 
                                    $coach->id === $relation->coach_id && 
                                    $relation->active === 1 && 
                                    $relation->canceled === NULL)

                                <!-- Display "Finish Relation" button -->
                                <form action="{{ route('finish-relation', ['relation_id' => $relation->id, 'coach_id' => $coach->id, 'params' => $params]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn mb-3 mb-lg-0 finish">Finish Relation</button>
                                </form>
                            <!-- 
                                If relation active is NULL
                                and relation canceled is NOT NULL
                                and relation finished is NULL
                            -->
                            @elseif(Auth::user()->id === $relation->user_id_send && 
                                    $coach->id === $relation->coach_id && 
                                    $relation->active === NULL && 
                                    $relation->canceled !== NULL &&
                                    $relation->finished === NULL)
                                <!-- Display "Relation Request" button -->
                                <form action="{{ route('restore-request', ['relation_id' => $relation->id, 'coach_id' => $coach->id, 'params' => $params]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn mb-3 mb-lg-0 relation">Relation Request</button>
                                </form>
                            <!-- IF relation finished is NOT NULL -->
                            @elseif(Auth::user()->id === $relation->user_id_send && 
                                    $coach->id === $relation->coach_id && 
                                    $relation->finished !== NULL)
                                <!-- Display "Relation Request" button -->
                                <form action="{{ route('restore-request', ['relation_id' => $relation->id, 'coach_id' => $coach->id, 'params' => $params]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn mb-3 mb-lg-0 relation">Relation Request</button>
                                </form>
                            @endif
                        @endforeach <!-- Loop through relations END -->
                    <!-- If relation don't exists -->
                    @else
                        <!-- Display "Relation Request" button -->
                        <form action="{{ route('relation-request', ['user_id' => $coach->user->id, 'coach_id' => $coach->id, 'params' => $params]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn mb-3 mb-lg-0 relation">Relation Request</button>
                        </form>
                    @endif <!-- If relation exists END -->

                    @if (Auth::check() && Auth::user()->id === $coach->user->id) 
                    @else
                        <a href="" class="btn mb-3 mb-lg-0 message" data-toggle="modal" data-target="#msg{{ $coach->id }}">Send Message</a>
                    @endif
                @endguest <!-- If is guest END -->

                <!-- 
                    BACK BUTTON 
                    IF $params is 'i' that means
                    that previous url is index.php
                -->
                @if($params === 'i')
                    <a href="{{ route('index') }}" class="btn back-btn">Back</a>
                <!--
                    IF $params is 'u' that means
                    that previous url is user/home
                -->
                @elseif($params === 'u')
                <a href="{{ route('user-home') }}" class="btn back-btn">Back</a>
                <!--
                    IF $params is NOT NULL that means
                    that previous url is search.php
                -->
                @else
                    @if($params !== NULL)
                        <a href="/search?{{ $params }}" class="btn back-btn">Back</a>
                    @endif
                @endif
            </div> <!-- Buttons End -->

            <!-- Message Modal -->
            <div class="modal fade" id="msg{{ $coach->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        @guest
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="p-2">
                                    <p class="body-text text-center"><a href="{{ route('login') }}">Sign in </a>to be able to send private message to coach.</p>
                                    <p class="body-text text-center">You do not have account yet? <a href="{{ route('register') }}">Register </a> now!</p>
                                </div>
                            </div>
                        @else
                            <div class="modal-header">
                                <h5 class="modal-title">New Message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('create-new-conversation') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="hidden" name="msg_to" value="{{ $coach->user->id }}">
                                        <input type="text" class="form-control pb-0" value="{{ ucfirst($coach->user->name) . ' ' . ucfirst($coach->user->lastname) }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control @error('msg_body') is-invalid @enderror" name="msg_body" rows="12"></textarea>

                                        @error('msg_body')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn">Send</button>
                                </form>
                            </div>
                        @endguest
                    </div>
                </div>
            </div> <!-- Message Modal End -->

            <!-- Rewievs -->
            <div class="d-flex flex-column justify-content-center align-items-center rewievs p-3 mt-5">
                <h4>Rewievs</h4>
                @guest
                @else
                    <!-- Loopr through relations -->
                    @foreach ($relations as $relation) 
                        <!-- If User and Coach have active relation
                             user have option to leave review        
                        -->
                        @if(Auth::user()->id === $relation->user_id_send && 
                                $coach->id === $relation->coach_id && 
                                $relation->active === 1 && 
                                $relation->canceled === NULL)

                            <!-- Review form -->
                            <form action="{{ route('create-review', $params) }}" method="POST" class="d-flex flex-column justify-content-center align-items-center mb-5">
                                @csrf
                                <input type="hidden" name="coach_id" value="{{ $relation->coach_id }}">
                                <input type="hidden" name="user_id_receive" value="{{ $relation->user_id_receive}}">
                                <div class="form-group">
                                    <textarea name="rewiev" cols="50" rows="3" class="form-control @error('rewiev') is-invalid @enderror"></textarea>

                                    @error('rewiev')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn">Add</button>
                            </form> <!-- Review form END -->
                        @endif
                    @endforeach <!-- Loopr through relations END -->
                @endguest
                
                <!-- If reviews existas -->
                @if(count($reviews) > 0)
                    <div>
                        <!-- Loop through reviews -->
                        @foreach($reviews as $review)
                            <div class="rewiev mb-2 pb-0">
                                <p>{{ ucfirst($review->text) }}, 
                                <span class="rewiev-author">
                                    {{ ucfirst($review->name) . ' ' . ucfirst($review->lastname) }}
                                </span></p>
                                <p class="review-date">{{ date('d.m.Y, H:i', strtotime($review->created_at)) }}</p>
                            </div>
                        @endforeach <!-- Loop through reviews END --> 
                    </div>
                    {{ $reviews->links() }}
                <!-- If doesnt exists reviews, display message -->
                @else
                    <p>No Reviews</p>
                @endif <!-- If reviews existas END -->
            </div> <!-- Rewievs End -->

        </div>

    </div>
@endsection