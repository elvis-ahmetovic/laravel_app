@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="pt-4 pt-lg-5">
                <h2>Change My City</h2>

                <!-- Back button -->
                <a href="{{ url()->previous() }}" class="float-right">Back</a>

                <!-- Change city form -->
                <form action="{{ route('city-change', $user->id) }}" method="POST" class="col-12 col-md-10 col-xl-6 mx-auto pb-4 pb-lg-5">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control @error('new-city') is-invalid @enderror" name="new-city" value="{{ ucfirst($user->city) }}">

                        @error('new-city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection