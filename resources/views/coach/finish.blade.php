@extends('layouts.app')

@section('content')
    <div class="container register d-flex flex-column justify-content-center align-items-center">
        
        <h2 class="mb-5">{{ __('Finish your registration') }}</h2>

        <!-- Finish Registration form -->
        <form method="POST" action="{{ route('store-finish-registration') }}" class="register d-flex flex-column align-items-center">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <!-- Choose a category -->
            <div class="form-group row justify-content-center">
                <div>
                    <select class="form-control thin" id="role" name="category_id">
                        <option value="" selected="true" disabled="disabled">Choose category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                        @endforeach
                    </select>

                    @if($errors->has('category_id'))
                        <span class="help-block inv text-danger">
                            {{ $errors->first('category_id') }}
                        </span>
                    @endif
                </div> 
            </div> <!-- Choose a category END -->

            <!-- Set price -->
            <div class="form-group row justify-content-center">
                <div>
                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" placeholder="Set your price (per hour)">

                    @error('price')
                        <span class="inv text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- Set price END -->

            <!-- Phone number -->
            <div class="form-group row justify-content-center">
                <div>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Phone number" autocomplete="phone">

                    @error('phone')
                        <span class="inv text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- Phone number END -->

            <!-- Public message title -->
            <div class="form-group row justify-content-center">
                <div>
                    <input type="text" class="form-control" name="msg_title" value="{{ old('msg_title') }}" placeholder="Message title" autocomplete="city">

                    @error('msg_title')
                        <span class="inv text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- Public message title END -->

            <!-- Public message body -->
            <div class="form-group row justify-content-center">
                <div>
                    <textarea class="form-control" id="editor" name="msg_body" rows="7" value="{{ old('msg_body') }}" placeholder="Writte your message (This will be displayed to your potential clients)"></textarea>

                    @error('msg_body')
                        <span class="inv text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- Public message body End -->

            <div class="form-group row justify-content-center mb-0 mt-4">
                <div>
                    <button type="submit" class="btn btn-log-reg">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form> <!-- Finish Registration form END -->
              
    </div>
@endsection