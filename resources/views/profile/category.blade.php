@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="pt-4 pt-lg-5">
                <h2>Change Category</h2>

                <!-- Back button -->
                <a href="{{ url()->previous() }}" class="float-right">Back</a>

                <!-- Change category form -->
                <form action="{{ route('category-change', $user->id) }}" method="POST" class="col-12 col-md-10 col-xl-6 mx-auto pb-4 pb-lg-5">
                    @csrf
                    <div class="form-group">
                   
                        <select name="new-category" class="form-control @error('new-category') is-invalid @enderror"> 
                            <option value="{{ $user->category_id }}">{{ ucfirst($user->category_name) }}</option>
                            @foreach ($categories as $category)
                                @if ($category->name !== $user->category_name)
                                    <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('new-category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form> <!-- Change category form END -->
            </div>
        </div>
    </div>
@endsection