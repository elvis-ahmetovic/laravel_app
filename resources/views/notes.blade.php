@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content pt-4 pt-lg-5">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h2>Notes</h2>

            <form action="{{ route('store-note', $param='n') }}" method="post" class="form-inline my-4 note-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="note" class="form-control" placeholder="Type a note...">
                </div>
                <button type="submit" class="btn btn-note">Save</button>
            </form>

            @if (count($notes) > 0)

                <table class="table notes-table">
                    <thead>
                        <tr>
                            <th scope="col">Note</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td>
                                    @if ($note->finished === 1)
                                        <del>{{ ucfirst($note->note) }}</del>
                                    @else
                                        {{ ucfirst($note->note) }}
                                    @endif    
                                </td>

                                <!-- Action buttons -->
                                <td class="row justify-content-center">
                                    <!-- Edit button -->
                                    <a href="#" data-toggle="modal" data-target="#edit{{ $note->id }}" class="mr-3" title="Edit Category">
                                        <button type="submit" title="Edit Note"><i class="far fa-edit"></i></button>
                                    </a>
                                    
                                    <!-- Finish button -->
                                    <form action="{{ route('finish-note', ['note_id'=>$note->id, 'param'=>'n']) }}" method="POST" class="mr-3">
                                        @csrf
                                        <button type="submit" title="Finish Note">
                                            @if ($note->finished === 1)
                                                <i class="fas fa-check-square"></i>
                                            @else
                                                <i class="far fa-check-square"></i>
                                            @endif 
                                        </button>
                                    </form>

                                    <!-- Delete button -->
                                    <form action="{{ route('delete-note', ['note_id'=>$note->id, 'param'=>'n']) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="Delete Note"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td> <!-- Action buttons END -->
                            </tr>

                            <!-- Edit note modal -->
                            <div class="modal fade edit-note" id="edit{{ $note->id }}" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Note</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- Edit form -->
                                        <form action="{{ route('edit-note', ['note_id'=>$note->id, 'param'=>'n']) }}" method="POST">
                                        @csrf
                                            <div class="modal-body">
                                                
                                                <div class="form-group">
                                                    <input type="text" name="new-note" class="form-control my-4" value="{{ $note->note }}" autofocus>
                                                </div>

                                                <button type="submit" class="btn my-2">Save changes</button>
                                                
                                            </div>
                                        </form> <!-- Edit form END -->
                                    </div>
                                </div>
                            </div> <!-- Modal END -->
                        @endforeach
                    </tbody>
                </table>
                {{ $notes->links() }}
            @else
                <p class="text-center">Writte some note</p>
            @endif
        </div>
    </div>
@endsection