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
                <h2>Active Relations</h2>

                <!-- If exists active relations -->
                @if(count($active_relations) > 0)
                    <!-- Content table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">City</th>
                                <th scope="col">Active at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through active relations -->
                            @foreach($active_relations as $relation)
                                <tr>
                                    <td>{{ ucfirst($relation->name) . ' ' . ucfirst($relation->lastname) }}</td>
                                    <td>{{ $relation->email }}</td>
                                    <td>{{ ucfirst($relation->city) }}</td>
                                    <td>{{ date('d.m.Y', strtotime($relation->created_at)) }}</td>

                                    <td class="row">
                                        <!-- Sender's Information button -->
                                        <button>
                                            <a href="{{ route('sender-info', ['relation_id' => $relation->relations_id, 'param' => 'active']) }}" title="Show Sender's Informations"><i class="fas fa-info-circle"></i></a>
                                        </button>

                                        <!-- Finish relation button -->
                                        <form action="{{ route('finish-relation', ['relation_id' => $relation->relations_id, 'coach_id' => $relation->coach_id, 'params' => 'c']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="finish" title="Finish Relation"><i class="fas fa-check-circle"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach <!-- Loop through active relations END -->

                        </tbody>
                    </table> <!-- Content table END -->
                <!-- If doesnt exists active relations display message -->
                @else
                    <p class="text-center">No Active Relations</p>
                @endif <!-- If exists active relations END -->
            </div>
        </div>
    </div>
@endsection