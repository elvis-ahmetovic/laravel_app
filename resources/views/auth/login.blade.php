@extends('layouts.app')

@section('content')
    <div class="container">

        @if(session('status') || session('error'))
            <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger' }} text-center">
                {{ session('status') ? session('status') : session('error') }}
            </div>
        @endif

        <!-- Login div -->
        <div class="login d-flex flex-column justify-content-center align-items-center py-5">
                    
            <h2 class="mb-5">{{ __('Sign in') }}</h2>
    
            <form method="POST" action="{{ route('login') }}">
                @csrf
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" autocomplete="username" autofocus>
    
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" autocomplete="current-password">
    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center mt-5 mb-0">
                    <div>
                        <button type="submit" class="btn btn-log-reg">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>      
        </div> <!-- Login div End -->
    </div>
@endsection
