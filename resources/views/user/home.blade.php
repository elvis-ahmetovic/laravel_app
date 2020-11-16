@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="content">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <!-- First row, relations -->
            <div class="row pt-4 pt-lg-5 relations">

                <!-- Left column, my latest requests -->
                <div class="col-12 col-md-4 col-lg-3 pt-4 mb-4 d-flex flex-column align-items-center new-relations">
                    <h4>My Latest Requests</h4>

                    <!-- If exists any relation requests -->
                    @if(count($relation_requests) > 0)

                        <!-- List of my requests -->
                        <ul class="list-group list-group-flush w-100 my-3">
                            <!-- Loop through relation requests -->
                            @foreach ($relation_requests as $relation)

                                <!-- List Items -->
                                <li class="list-group-item">
                                    {{ ucfirst($relation->name) . ' ' . ucfirst($relation->lastname) }}
                                    , {{ $relation->city }}

                                    <!-- Action buttons -->
                                    <span class="row float-right relation-btns">
                                        <!-- Coach's public profile -->
                                        <button>
                                            <a href="{{ route('public-profile', ['coach_id' => $relation->coach_id, 'params' => 'u']) }}" title="Show Coach's Informations"><i class="fas fa-info-circle"></i></a>
                                        </button>
                                        <!-- Cancel request -->
                                        <form action="{{ route('cancel-request', ['relation_id' => $relation->relations_id, 'coach_id' => $relation->coach_id, 'params' => 'u']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="cancel" title="Cancel Request"><i class="fas fa-times-circle"></i></button>
                                        </form>
                                    </span> <!-- Action buttons END -->
                                </li>
                            @endforeach <!-- Loop through relation requests END -->
                        </ul> <!-- List of my requests END -->
                    <!-- If doesnt exists any relation requests, display message -->
                    @else
                        <p>No New Requests</p>
                    @endif <!-- If exists relation requests END -->
                </div> <!-- Left column, my latest requests END -->

                <!-- Right column, two insides column (active and finished relations) -->
                <div class="col-12 col-md-8 col-lg-9">
                    <h2>Home</h2>

                    <!-- Right column wrapper -->
                    <div class="row mb-4">

                        <!-- Left column, active relations -->
                        <div class="col-12 col-md-5 offset-md-1">
                            <div class="p-4 d-flex flex-column align-items-center active-relations">
                                <h4><a href="{{ route('active-relations') }}">Active Relations</a></h4>

                                <!-- If exists active relations -->
                                @if(count($active_relations) > 0)

                                    <!-- List of active relations -->
                                    <ul class="list-group list-group-flush w-100 my-3">
                                        <!-- Loop through active relations -->
                                        @foreach ($active_relations as $relation)

                                            <!-- List items -->
                                            <li class="list-group-item">
                                                {{ ucfirst($relation->name) . ' ' . ucfirst($relation->lastname) }}
                                                , {{ $relation->city }}

                                                <!-- Action buttons -->
                                                <span class="row float-right relation-btns">
                                                    <!-- Coach's public profile -->
                                                    <button>
                                                        <a href="{{ route('public-profile', ['coach_id' => $relation->coach_id, 'params' => 'u']) }}" title="Show Coach's Informations"><i class="fas fa-info-circle"></i></a>
                                                    </button>
                                                    <!-- Finish relation -->
                                                    <form action="{{ route('finish-relation', ['relation_id' => $relation->relations_id, 'coach_id' => $relation->coach_id, 'params' => 'u']) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="finish" title="Finish Relation"><i class="fas fa-check-circle"></i></button>
                                                    </form>
                                                </span> <!-- Action buttons END -->
                                            </li> <!-- List items END -->
                                        @endforeach<!-- Loop through active relations END -->
                                    </ul> <!-- List of active relations END -->

                                <!-- If doesnt exists active relations, display message -->
                                @else
                                    <p>No Active Relations</p>    
                                @endif <!-- If exists active relations END -->
                            </div>
                        </div> <!-- Left column, active relations END -->

                        <!-- Right column, finished relations -->
                        <div class="col-12 col-md-5 offset-md-1">
                            <div class="p-4 d-flex flex-column align-items-center finished-relations">
                                <h4><a href="{{ route('finished-relations') }}">Finished Relations</a></h4>

                                <!-- If exists finished relations -->
                                @if(count($finished_relations) > 0)

                                    <!-- List of finished relations -->
                                    <ul class="list-group list-group-flush w-100 my-3">
                                        <!-- Loop through finished relations -->
                                        @foreach ($finished_relations as $relation)

                                            <!-- List items -->
                                            <li class="list-group-item">
                                                {{ ucfirst($relation->name) . ' ' . ucfirst($relation->lastname) }}
                                                , {{ $relation->city }}

                                                <!-- Action button -->
                                                <span class="row float-right relation-btns">
                                                    <!-- Coach's public profile -->
                                                    <button>
                                                        <a href="{{ route('public-profile', ['coach_id' => $relation->coach_id, 'params' => 'u']) }}" title="Show Coach's Informations"><i class="fas fa-info-circle"></i></a>
                                                    </button>
                                                </span> <!-- Action button END -->
                                            </li> <!-- List items END -->
                                        @endforeach <!-- Loop through finished relations END -->
                                    </ul><!-- List of finished relations END -->

                                <!-- If doesnt exists finished relations, display message -->
                                @else
                                    <p>No Finished Relations</p>    
                                @endif <!-- If exists finished relations END -->
                            </div>
                        </div> <!-- Right column, finished relations END -->

                    </div> <!-- Right column wrapper END -->
                </div> <!-- Right column END -->
            </div> <!-- First row, relations END -->

            <!-- Second row, reviews and calendar -->
            <div class="row">

                <!-- Left column, latest reviews -->
                <div class="col-12 col-md-4 col-lg-3 pt-4 mb-4 d-flex flex-column align-items-center my-reviews">
                    <h4>My Latest Reviews</h4>

                    <!-- If exists reviews -->
                    @if(count($reviews) > 0)

                        <!-- Loop through reviews -->
                        @foreach ($reviews as $review)
                            <div class="review mb-2">
                                <p>To: <strong>{{ ucfirst($review->name) . ' ' . ucfirst($review->lastname) }}</strong></p>
                                <p>{{ ucfirst($review->text) }}</p>
                                <p class="review-date">{{ date('d.m.Y, H:i', strtotime($review->created_at)) }}</p>
                            </div>
                        @endforeach <!-- Loop through reviews END -->

                    <!-- If doesnt exists reviews, display message -->
                    @else
                        <p>No Finished Relations</p>    
                    @endif <!-- If exists reviews END -->
                </div> <!-- Left column, latest reviews END -->
                
                <div class="col-12 col-md-8 col-lg-9 mb-4">
                    <div class="d-flex flex-column align-items-center pt-4 my-notes">
                        <h4><a href="{{ route('show-notes') }}">My Notes</a></h4>

                        <form action="{{ route('store-note', $param='u') }}" method="post" class="form-inline my-4 note-form">
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
                                            <td class="row justify-content-center action-note">
                                                <!-- Edit button -->
                                                <a href="#" data-toggle="modal" data-target="#edit{{ $note->id }}" class="mr-3" title="Edit Note">
                                                    <button type="submit" title="Edit Note"><i class="far fa-edit"></i></button>
                                                </a>
                                                
                                                <!-- Finish button -->
                                                <form action="{{ route('finish-note', ['note_id'=>$note->id, 'param'=>'u']) }}" method="POST" class="mr-3">
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
                                                <form action="{{ route('delete-note', ['note_id'=>$note->id, 'param'=>'u']) }}" method="POST">
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
                                                    <form action="{{ route('edit-note', ['note_id'=>$note->id, 'param'=>'u']) }}" method="POST">
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
                        @else
                            <p>Writte some note</p>
                        @endif
                    </div>
                </div>
            </div> <!-- Second row, reviews END -->

        </div>
    </div>
@endsection