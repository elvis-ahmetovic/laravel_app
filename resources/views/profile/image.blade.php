@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="pt-4 pt-lg-5">
                <h2>Change Image</h2>

                <!-- Back button -->
                <a href="{{ url()->previous() }}" class="float-right">Back</a>

                <!-- Change image form -->
                <form action="{{ route('image-change', $user->id) }}" method="POST" enctype="multipart/form-data" class="col-12 col-md-10 col-xl-6 mx-auto pb-4 pb-lg-5">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="form-control @error('new-image') is-invalid @enderror" name="new-image">

                        @error('new-image')
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