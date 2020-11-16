@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content d-flex flex-column align-items-center">

            @if(session('success'))
                <div class="alert alert-success text-center w-100">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="mb-5">ACTIVE RELATIONS</h3>

            <table class="table text-center custom-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Coach</th>
                        <th>Category</th>
                        <th>City</th>
                        <th>Started</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through users -->
                    @foreach ($active_relations as $user)
                        <tr>
                            <td>{{ ucfirst($user->send_name) . ' ' . ucfirst($user->send_lastname) }}</td>
                            <td>{{ ucfirst($user->receive_name) . ' ' . ucfirst($user->receive_lastname) }}</td>
                            <td>{{ ucfirst($user->cat_name) }}</td>
                            <td>{{ ucfirst($user->receive_city) }}</td>
                            <td>{{ date('d-m-Y', strtotime($user->started_at)) }}</td>
                            <td>{{ duration($user->finished_at, $user->started_at) }}</td>
                        </tr>
                    @endforeach <!-- Loop through users END -->
                </tbody>
            </table>
            {{ $active_relations->links() }}

        </div>
    </div>
@endsection