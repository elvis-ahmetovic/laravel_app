@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content content d-flex flex-column align-items-center">
           
            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">CATEGORIES</h3>

            <!-- Add category form -->
            <form action="{{ route('store-categories') }}" method="POST" class="add-form mb-5 d-flex flex-column align-items-center">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="Add Category">
                    
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit">Add</button>
            </form> <!-- Add category form END -->

            <table class="table text-center custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through categories -->
                    @foreach ($categories as $category)
                        <!-- Row with name and action buttons -->
                        <tr>
                            <td>
                                <!-- If category is disabled display with <del> tag -->
                                @if ($category->disabled === 1)
                                    <del>{{ ucfirst($category->name) }}</del>
                                @else
                                    {{ ucfirst($category->name) }}
                                @endif
                            </td>
                            <!-- Action buttons -->
                            <td class="row justify-content-center">
                                <!-- Edit button -->
                                <a href="#" data-toggle="modal" data-target="#edit{{ $category->id }}" class="mr-3" title="Edit Category">
                                    <button type="submit" title="Edit Category"><i class="far fa-edit"></i></button>
                                </a>
                                
                                <!-- Disable button -->
                                <form action="{{ route('disable-categories', $category->id) }}" method="POST" class="mr-3">
                                    @csrf
                                    <button type="submit" title="Enable/Disable Category"><i class="fas fa-ban"></i></button>
                                </form>

                                <!-- Delete button -->
                                <form action="{{ route('delete-categories', $category->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Delete Category"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td> <!-- Action buttons END -->
                        </tr> <!-- Row END -->

                        <!-- Edit category modal -->
                        <div class="modal fade edit-category" id="edit{{ $category->id }}" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- Edit form -->
                                    <form action="{{ route('edit-categories', $category->id) }}" method="POST">
                                    @csrf
                                        <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <input type="text" name="new-name" class="form-control my-4" value="{{ $category->name }}" autofocus>
                                            </div>

                                            <button type="submit" class="btn my-2">Save changes</button>
                                            
                                        </div>
                                    </form> <!-- Edit form END -->
                                </div>
                            </div>
                        </div> <!-- Modal END -->
                    @endforeach <!-- Loop through categories END -->
                </tbody>
            </table>
            {{ $categories->links() }} <!-- Pagination links -->
        </div>
    </div>
@endsection