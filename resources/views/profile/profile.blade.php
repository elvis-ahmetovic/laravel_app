@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="pt-4 pt-lg-5">
                <h2>Profile</h2>

                <!-- Main users Info -->
                <div class="col-12 col-md-10 col-xl-8 mb-4 row main-info">
                    <!-- Card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h5 class="card-title">{{ ucfirst($user->users_name) . ' ' . ucfirst($user->lastname) }}</h5>
                        </div>
                        <!-- Card body -->
                        <div class="card-body d-flex flex-column align-items-center flex-md-row">
                            <!-- Image column -->
                            <div class="mb-3 mb-md-0 mr-md-3 mr-lg-4">
                                <img src='/storage/avatars/{{ $user->image }}' alt="/storage/avatars/{{  $user->id }}/{{ $user->image }}">
                            </div>
                            <!-- Info column -->
                            <div class="ml-md-4">

                                <!-- City -->
                                <p class="card-text">City: 
                                    <span>{{ ucfirst($user->city) }}</span>
                                    <a href="{{ route('city') }}"><i class="far fa-edit"></i></a>
                                </p>

                                <!-- Email -->
                                <p class="card-text">Email: 
                                    <span>{{ $user->email }}</span>
                                </p>

                                <!-- If users role is verified_coach -->
                                @if($user->role === 'verified_coach')
                                    <!-- Phone -->
                                    <p class="card-text">Phone: 
                                        <span>{{ ucfirst($user->phone) }}</span>
                                        <a href="{{ route('phone') }}"><i class="far fa-edit"></i></a>
                                    </p>

                                    <!-- Category -->
                                    <p class="card-text">Category: 
                                        <span>{{ ucfirst($user->category_name) }}</span>
                                        <a href="{{ route('category') }}"><i class="far fa-edit"></i></a>
                                    </p>

                                    <!-- Price -->
                                    <p class="card-text">Price: 
                                        <span>{{ $user->price }} &euro;/h</span>
                                        <a href="{{ route('price') }}"><i class="far fa-edit"></i></a>
                                    </p>
                                @endif <!-- If users role is verified_coach END -->

                                <!-- Password -->
                                <p class="card-text">Password: 
                                    <span>******</span>
                                    <a href="{{ route('password') }}"><i class="far fa-edit"></i></a>
                                </p>

                                <!-- Change image link -->
                                <p class="card-text change-image">
                                    <a href="{{ route('image') }}">Change Image</a>
                                </p>
                            </div> <!-- Info column END -->
                        </div> <!-- Card body END -->
                    </div> <!-- Card END -->
                </div><!-- Main-Info End -->

                <!-- If users role is verified_coach -->
                @if($user->role === 'verified_coach')
                    <!-- Message to Users -->
                    <div class="col-12 col-md-10 col-xl-8 row main-info">
                        <!-- Card -->
                        <div class="card">
                            <!-- Card header -->
                            <div class="card-header">
                                <h5 class="card-title">Message to Users</h5>
                            </div>

                            <!-- Card body -->
                            <div class="card-body d-flex flex-column align-items-center flex-md-row">
                                <div class="ml-md-4">
                                    <!-- Message title -->
                                    <h5 class="card-title">
                                        <strong>{{ ucfirst($user->msg_title) }}</strong>
                                        <a href="{{ route('msg-title') }}"><i class="far fa-edit"></i></a>
                                    </h5>
                                    <!-- Message body -->
                                    <p class="card-text">
                                        {{ $user->msg_body }}
                                        <span class="float-right">
                                            <a href="{{ route('msg-body') }}"><i class="far fa-edit"></i></a>
                                        </span>
                                    </p>
                                </div>
                            </div> <!-- Card body END -->
                        </div> <!-- Card END -->
                    </div><!-- Message to Users End -->
                @endif <!-- If users role is verified_coach END -->
                
            </div>
        </div>
    </div>
@endsection