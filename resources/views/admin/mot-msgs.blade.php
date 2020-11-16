@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">

        <div class="page-content content d-flex flex-column align-items-center">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">MOTIVATION MESSAGES</h3>

            <!-- Add motivation message form -->
            <form action="{{ route('store-mot-msgs') }}" method="POST" class="add-form mb-5 d-flex flex-column align-items-center">
                @csrf
                <div class="form-group">
                    <input type="text" name="title" class="form-control mb-4 @error('title') is-invalid @enderror" placeholder="Add Title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <textarea name="body" class="form-control mb-2 @error('body') is-invalid @enderror" cols="40" rows="5" placeholder="Type a Message"></textarea>
                    @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <button type="submit">Add</button>
            </form> <!-- Add motivation message form END -->

            <div class="align-self-start p-2 w-100">
                <!-- Loop through motivation messages -->
                @foreach ($mot_msgs as $msg)
                    <!-- Motivation message -->
                    <div class="message d-flex flex-column p-3 mb-3">
                        <h4>{{ ucfirst($msg->title) }}</h4>
                        <p>{{ ucfirst($msg->body) }}</p>
                        <div class="align-self-end row">
                            <a href="#" data-toggle="modal" data-target="#edit{{ $msg->id }}" class="mr-2">
                                <button type="submit" title="Edit Message"><i class="far fa-edit"></i></button>
                            </a>
                            <form action="{{ route('delete-mot-msgs', $msg->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Delete Message"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div> <!-- Motivation message END -->

                    <!-- Edit motivation message modal -->
                    <div class="modal fade edit-message" id="edit{{ $msg->id }}" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Edit motivation message form -->
                                <form action="{{ route('edit-mot-msgs', $msg->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" name="new-title" class="form-control my-4 @error('new-title') is-invalid @enderror" value="{{ $msg->title }}">
                                            @error('new-title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <textarea name="new-body" class="form-control my-4 @error('new-body') is-invalid @enderror" cols="40" rows="5">{{ $msg->body }}</textarea>
                                            @error('new-body')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <button type="submit" class="btn my-2">Save changes</button>
                                        </div>
                                    </div>
                                </form> <!-- Edit motivation message form END -->
                            </div>
                        </div>
                    </div> <!-- Edit motivation message modal END -->
                @endforeach <!-- Loop through motivation messages END -->
            </div>

            {{ $mot_msgs->links('vendor.pagination.bootstrap-4') }} <!-- Pagination links -->

        </div>
    </div>
@endsection