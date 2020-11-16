@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content d-flex flex-column align-items-center">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">HOME</h3>

            <!-- Numerical State of Users  -->
            <div class="row justify-content-center home w-100 mt-5">
                <!-- All users (coach and verified coach)  -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        All <strong>Users</strong> + Coaches 
                        <span class="badge badge-pill float-right">{{ $data['all_users'] }}</span>
                    </div>
                </div>

                <!-- Regular users (users who need coaches)-->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Regular 
                        <strong>
                            <a href="{{ route('superadmin-users') }}">Users</a>
                        </strong>
                        <span class="badge badge-pill float-right">{{ $data['regular_users'] }}</span>
                    </div>
                </div>

                <!-- Verified coaches -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Verified 
                        <strong>
                            <a href="{{ route('superadmin-coaches') }}">Coaches</a>
                        </strong>
                        <span class="badge badge-pill float-right">{{ $data['verified_coaches'] }}</span>
                    </div>
                </div>

                <!-- Unverified coaches -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Unverified <strong>Coaches</strong>
                        <span class="badge badge-pill float-right">{{ $data['unverified_coaches'] }}</span>
                    </div>
                </div>
            </div> <!-- Numerical State of Users End  -->

            <!-- Numerical State of Categories  -->
            <div class="row justify-content-center home w-100 mt-5">
                <!-- Categories number -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        <strong>
                            <a href="{{ route('superadmin-categories') }}">Categories</a>
                        </strong>
                        <span class="badge badge-pill float-right">{{ $data['categories'] }}</span>
                    </div>
                </div>

                <!-- Most used category -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Most Used 
                        <span class="badge badge-pill float-right">
                            @if(isset($data['most_used']))
                                {{ ucfirst($data['most_used']->name) }} | {{ $data['most_used']->num }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Least used category -->
                <div class="col-12 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Least Used
                        <span class="badge badge-pill float-right">
                            @if(isset($data['least_used']))
                                {{ ucfirst($data['least_used']->name) }} | {{ ucfirst($data['least_used']->num) }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div> <!-- Numerical State of Categories End  -->

            <!-- Relations  -->
            <div class="row justify-content-center home w-100 mt-5">
                <!-- Total relation numbers -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Total 
                        <strong>
                            <a href="{{ route('superadmin-relations') }}">Relations</a>
                        </strong>
                        <span class="badge badge-pill float-right">{{ $data['relations'] }}</span>
                    </div>
                </div>

                <!-- Active relation numbers -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Active 
                        <strong>
                            <a href="{{ route('superadmin-active-relations') }}">Relations</a>
                        </strong>
                        <span class="badge badge-pill float-right">{{ $data['active_relations'] }}</span>
                    </div>
                </div>

                <!-- Coach with most relations -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Most Relations
                        <span class="badge badge-pill float-right">
                            @if(isset($data['most_relations']))
                                {{ ucfirst($data['most_relations']->name) }} | {{ $data['most_relations']->num }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div> <!-- Relations End  -->

            <!-- Rewievs  -->
            <div class="row justify-content-center home w-100 mt-5">
                <!-- Total reviews numbers -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Rewievs 
                        <span class="badge badge-pill float-right">{{ $data['reviews'] }}</span>
                    </div>
                </div>

                <!-- Coach with most reviews -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="p-2 cards">
                        Most Rewievs
                        <span class="badge badge-pill float-right">
                            @if(isset($data['most_reviews']))
                                {{ ucfirst($data['most_reviews']->name) }} | {{ $data['most_reviews']->num }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div> <!-- Rewievs End  -->

        </div>

    </div>
@endsection