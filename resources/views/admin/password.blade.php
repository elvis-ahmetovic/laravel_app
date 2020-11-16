@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">

        <div class="page-content content d-flex flex-column align-items-center">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">CHANGE PASSWORD</h3>

            <!-- Change password form -->
            <form action="{{ route('update-admin-password', $user->id) }}" method="POST" class="add-form mt-5 d-flex flex-column align-items-center">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="form-group">
                    <input type="password" name="password" class="form-control mb-2 @error('password') is-invalid @enderror" placeholder="Type Password">
                    
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="new-password" class="form-control mb-2 @error('new-password') is-invalid @enderror" placeholder="Type New Password">
                    
                    @error('new-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="confirm-password" class="form-control mb-2 @error('confirm-password') is-invalid @enderror" placeholder="Confirm New Password">
                    
                    @error('confirm-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit">Save</button>
            </form> <!-- Add category form END -->

        </div>

    </div>
@endsection