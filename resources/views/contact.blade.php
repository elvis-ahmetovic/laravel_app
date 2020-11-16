@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success text-center w-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="content pt-4 pt-lg-5">
            <h2>Contact</h2>

            <!-- Contact form -->
            <form action="{{ route('contact') }}" method="POST" class="col-12 col-md-10 col-xl-6 mx-auto py-4 py-lg-5">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::check() ? Auth::user()->id : null }}">

                <div class="form-row justify-content-center mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" value="{{ Auth::check() ? ucfirst(Auth::user()->name) : old('name') }}" {{ Auth::check() ? 'readonly' : '' }}>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong class="ml-4">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-row justify-content-center mb-3">
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" placeholder="Lastname" value="{{ Auth::check() ? ucfirst(Auth::user()->lastname) : old('lastname') }}" {{ Auth::check() ? 'readonly' : '' }}>

                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong class="ml-4">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-row justify-content-center mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" {{ Auth::check() ? 'readonly' : '' }}>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong class="ml-4">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-row justify-content-center mb-3">
                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" cols="30" rows="10" placeholder="Type your message here"></textarea>

                    @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong class="ml-4">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-row justify-content-center">
                    <button class="btn" type="submit" name="send">Send</button>
                </div>
            </form> <!-- Contact form END -->

        </div>
    </div>
@endsection