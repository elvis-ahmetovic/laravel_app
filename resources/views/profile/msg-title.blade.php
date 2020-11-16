@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="pt-4 pt-lg-5">
                <h2>Change Message Title</h2>

                <!-- CBack button -->
                <a href="{{ url()->previous() }}" class="float-right">Back</a>

                <!-- Change motivation message title -->
                <form action="{{ route('msg-title-change', $user->id) }}" method="POST" class="col-12 col-md-10 col-xl-6 mx-auto pb-4 pb-lg-5">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control @error('new-title') is-invalid @enderror" name="new-title" value="{{ ucfirst($user->msg_title) }}">

                        @error('new-title')
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