@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content d-flex flex-column align-items-center">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">RELATIONS</h3>

            <table class="table text-center custom-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Coach</th>
                        <th>Category</th>
                        <th>City</th>
                        <th>Started</th>
                        <th>Finished</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through users -->
                    @foreach ($relations as $user)
                        <tr>
                            <td>{{ ucfirst($user->send_name) . ' ' . ucfirst($user->send_lastname) }}</td>
                            <td>{{ ucfirst($user->receive_name) . ' ' . ucfirst($user->receive_lastname) }}</td>
                            <td>{{ ucfirst($user->cat_name) }}</td>
                            <td>{{ ucfirst($user->receive_city) }}</td>
                            @if($user->activated_at !== NULL)
                                <td>{{ date('d-m-Y', strtotime($user->started_at)) }}</td>
                            @else
                                <td>Wait activation</td>
                            @endif
                            
                            @if($user->finished === 1)
                                <td>{{ date('d-m-Y', strtotime($user->finished_at)) }}</td>
                            @elseif($user->active === 1)
                                <td>Active</td>
                            @else
                                <td>Wait activation</td>
                            @endif
                            <td>{{ duration($user->finished_at, $user->started_at) }}</td>
                        </tr>
                    @endforeach <!-- Loop through users END -->
                </tbody>
            </table>
            {{ $relations->links() }}

        </div>
    </div>
@endsection