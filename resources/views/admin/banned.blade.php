@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content content d-flex flex-column align-items-center">
            <h3 class="mb-5">BANNED USERS</h3>
            
            <!-- If banned users exists -->
            @if(count($users) > 0)
                <table class="table text-center custom-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Lastname</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Role</th>
                            <th>Admin Status</th>
                            <th>Registration</th>
                            <th>Banned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through banned users -->
                        @foreach ($users as $user)
                            <tr class="{{ ($user->admin_status === 1) ? 'admin' : '' }} {{ ($user->banned === 1) ? 'banned' : '' }}">
                                <td>{{ ucfirst($user->name) }}</td>
                                <td>{{ ucfirst($user->lastname) }}</td>
                                <td>{{ ucfirst($user->username) }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->city) }}</td>
                                <td>{{ ucfirst($user->role) }}</td>

                                <!-- Admin status -->
                                <td>
                                    <!-- If user's admin status is NULL -->
                                    @if ($user->admin_status === NULL)
                                        <!-- Set admin button -->
                                        <form action="{{ route('set-admin-users', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fas fa-times"></i></button>
                                        </form>
                                    <!-- If user's admin status is 1 -->
                                    @else
                                        <!-- Remove admin button -->
                                        <form action="{{ route('set-admin-users', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                </td><!-- Admin status END -->

                                <td>{{ $user->created_at->format('d.m.Y') }}</td>

                                <!-- Banned status -->
                                <td class="text-center">
                                    <!-- If user's banned status is NULL -->
                                    @if ($user->banned === NULL)
                                        <!-- Ban user button -->
                                        <form action="{{ route('ban-users', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fas fa-times"></i></button>
                                        </form>
                                    <!-- If user's banned status is 1 -->
                                    @else
                                        <!-- Remove ban button -->
                                        <form action="{{ route('ban-users', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                </td><!-- Banned status END -->
                            </tr>
                        @endforeach <!-- Loop through banned users END -->
                    </tbody>
                </table>
                {{ $users->links() }}
            <!-- If doesnt exists, display message -->
            @else
                <p>No banned users</p>
            @endif <!-- If banned users exists END -->
        </div>
    </div>
@endsection