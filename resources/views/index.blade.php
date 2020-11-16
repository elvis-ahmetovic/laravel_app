@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">

    <!-- Welcome div -->
    <div class="welcome py-5 p-md-5">
        <div class="d-flex flex-column align-items-center justify-content-center pt-sm-2 pt-md-4">
            @guest
                <p class="text-center">You want to be best version of yourself?</p>
                <p class="text-center">Find coach in your city, browse a category of your interest</p>
            @else
                <!-- Motivation message (quote) -->
                <div class="quotes p-3">
                    <h3 class="text-center">{{ $motivation_message->title }}</h3>
                    <p class="text-center">{{ $motivation_message->body }}</p>
                </div>
            @endguest 
        </div>
    </div> <!-- Welcome div End -->

    <!-- Search div -->
    <div class="search mb-5">
        <div class="pt-4 pt-lg-5">
            <h2 class="text-center">Find Coach</h2>

            <!-- Search form -->
            <form action="{{ route('search') }}" method="GET" class="col-12 col-xl-10 mt-5 mx-auto py-4 py-lg-5">
                @csrf

                <!-- Top row -->
                <div class="form-row align-items-center justify-content-center mb-4">
                    <!-- City input field -->
                    <div class="col-auto mx-5 mb-4">
                        <input type="text" class="form-control" name="city" placeholder="City">
                    </div>
                    <!-- Category delect -->
                    <div class="col-auto mx-5 mb-lg-4">
                        <select class="form-control" name="category">
                            <option value="">Choose a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">{{ ucfirst($category->name) }}</option>
                                @endforeach
                        </select>
                    </div>
                </div><!-- Top row END-->

                <!-- Bottom row -->
                <div class="form-row align-items-center justify-content-center mb-4">
                    <!-- Lower price input field -->
                    <div class="col-auto mx-5 mb-4">
                        <input type="number" class="form-control" name="lowprice" placeholder="Lower Price">
                    </div>
                    <!-- Higher price input field -->
                    <div class="col-auto mx-5 mb-lg-4">
                        <input type="number" class="form-control" name="highprice" placeholder="Higher Price">
                    </div>
                </div><!-- Bottom row END -->

                <div class="form-row align-items-center justify-content-center">
                    <button class="btn" type="submit" name="search">Find</button>
                </div>
            </form> <!-- Search form END -->

        </div>
    </div> <!-- Search div End -->

    <!-- If exists any coaches -->
    @if (count($coaches) > 0)
        
        <!-- Random Coaches Row -->
        <div class="row justify-content-center cards">
            <!-- Loop through coaches -->
            @foreach ($coaches as $coach)

                <!-- Card -->
                <div class="card col-12 col-lg-3 mx-3 mb-4 p-0">
                    <!-- Card header -->
                    <div class="card-header">
                        <h5 class="card-title">{{ ucfirst($coach->users_name) . ' ' . ucfirst($coach->lastname) }}</h5>
                        <div class="row justify-content-between">
                            <p class="card-text">{{ ucfirst($coach->category_name) }}</p>
                            <p class="card-text">{{ ucfirst($coach->city) }}</p>
                        </div>
                    </div> <!-- Card header END -->

                    <!-- Card body -->
                    <div class="card-body d-flex flex-column align-items-center">
                        <img class="p-1 mb-2" src='/storage/avatars/{{ $coach->image }}' alt="Coach Image">
                        <div class="align-self-start">
                            <p class="card-text">Email: <span>{{ $coach->email }}</span></p>
                            <p class="card-text">Price: <span>{{ $coach->price }} &euro; per hour</span></p>
                            <p class="card-text">Phone: 
                                <!-- Only authenticated user can see coach's phone number -->
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
                                    $coach->coach_id === $relation->coach_id && 
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
                                        $coach->coach_id === $relation->coach_id && 
                                        $relation->active === 1 && 
                                        $relation->canceled === NULL)
                                    <div class="relation py-1 pl-1 pr-2">
                                        Active
                                    </div>
                                @else
                                @endif
                            @endforeach <!-- Loop through relations END -->
                        @endguest
                    </div> <!-- Card body END -->

                    <!-- Card footer -->
                    <div class="card-footer">
                        <div class="row justify-content-between">

                            <!-- Show coach's public profile button -->
                            <a href="{{ route('public-profile', ['coach_id' => $coach->coach_id, 'params' => 'i']) }}" class="btn card-link">Show More Info</a>

                            <!-- Only authanticated user can send private message -->
                            @guest
                            @elseif(Auth::user()->role === 'user')
                                <a href="#" class="btn card-link" data-toggle="modal" data-target="#msg{{ $coach->id }}">Send Message</a>
                            @endguest
                 
                        </div>
                    </div> <!-- Card footer END -->
                </div> <!-- Card End -->

                <!-- Private message Modal -->
                <div class="modal fade" id="msg{{ $coach->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <!-- If visitor is guest -->
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
                            <!-- If visitor is authenticated -->
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
                                            <input type="hidden" name="msg_to" value="{{ $coach->user_id }}">
                                            <input type="text" class="form-control pb-0" value="{{ ucfirst($coach->users_name) . ' ' . ucfirst($coach->lastname) }}" disabled>
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

            @endforeach <!-- Loop through coaches END -->
        </div> <!-- Random Coaches Row End -->

    <!-- If doesnt exists any coaches, display message -->
    @else
        <h3 class="text-center mt-5">No Avalible Coaches</h3>
    @endif <!-- If exists any coaches END -->

</div>
@endsection