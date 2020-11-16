@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <div class="pt-4 pt-lg-5 relations">
                <h2>Finished Relations</h2>

                <!-- If exists finished relations -->
                @if(count($finished_relations) > 0)
                    <!-- Content table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">City</th>
                                <th scope="col">Start</th>
                                <th scope="col">Finish</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through finished relations -->
                            @foreach($finished_relations as $relation)
                                <tr>
                                    <td>{{ ucfirst($relation->name) . ' ' . ucfirst($relation->lastname) }}</td>
                                    <td>{{ $relation->email }}</td>
                                    <td>{{ ucfirst($relation->city) }}</td>
                                    <td>{{ date('d.m.Y', strtotime($relation->created_at)) }}</td>
                                    <td>{{ date('d.m.Y', strtotime($relation->updated_at)) }}</td>

                                    <td class="row">
                                        <!-- Sender's Information button -->
                                        <button>
                                            <a href="{{ route('sender-info', ['relation_id' => $relation->relations_id, 'param' => 'finished']) }}" title="Show Sender's Informations"><i class="fas fa-info-circle"></i></a>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach <!-- Loop through finished relations END -->
                            
                        </tbody>
                    </table> <!-- Content table END -->
                <!-- If doesnt exists finished relations display message -->
                @else
                    <p class="text-center">No Finished Relations</p>
                @endif <!-- If exists finished relations END-->
            </div>
        </div>
    </div>
@endsection