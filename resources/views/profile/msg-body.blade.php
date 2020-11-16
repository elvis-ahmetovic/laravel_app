@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="pt-4 pt-lg-5">
                <h2>Change Message Body</h2>

                <!-- Back button -->
                <a href="{{ url()->previous() }}" class="float-right">Back</a>

                <!-- Change motivation message body -->
                <form action="{{ route('msg-body-change', $user->id) }}" method="POST" class="col-12 col-md-10 col-xl-6 mx-auto pb-4 pb-lg-5">
                    @csrf
                    <div class="form-group">
                        <textarea name="new-body" class="form-control @error('new-body') is-invalid @enderror" cols="30" rows="10">{{ ucfirst($user->msg_body) }}</textarea>

                        @error('new-body')
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