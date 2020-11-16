@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="register d-flex flex-column justify-content-center align-items-center">
            
            <h2 class="mb-4">{{ __('Create new account') }}</h2>
    
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="register d-flex flex-column align-items-center">
                @csrf
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" autocomplete="name" autofocus>
    
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" placeholder="Lastname" autocomplete="lastname">
    
                        @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" autocomplete="username">
    
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" autocomplete="email">
    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" placeholder="City" autocomplete="city">
    
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="img">
    
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center">
                    <div>
                        <select class="form-control thin" id="role" @error('role') is-invalid @enderror name="role" value="{{ old('role') }}">
                            <option value="" selected="true" disabled="disabled">Choose yout status</option>
                            <option value="user">I need a coach</option>
                            <option value="coach">I am a coach</option>
                        </select>
    
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
    
                <div class="form-group row justify-content-center mb-0 mt-2">
                    <div>
                        <button type="submit" class="btn btn-log-reg">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
                  
        </div>
    </div>
@endsection
