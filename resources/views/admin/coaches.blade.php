@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-0">
        <div class="page-content content d-flex flex-column align-items-center">
            <h3 class="mb-5">COACHES</h3>

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
                        <th>Date of Registration</th>
                        <th>Banned</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through coaches -->
                    @foreach ($coaches as $coach)
                        <tr class="{{ ($coach->admin_status === 1) ? 'admin' : '' }} {{ ($coach->banned === 1) ? 'banned' : '' }}">
                            <td>{{ ucfirst($coach->name) }}</td>
                            <td>{{ ucfirst($coach->lastname) }}</td>
                            <td>{{ ucfirst($coach->username) }}</td>
                            <td>{{ $coach->email }}</td>
                            <td>{{ ucfirst($coach->city) }}</td>
                            <td>{{ ucfirst($coach->role) }}</td>

                            <!-- Admin status -->
                            <td class="text-center">
                                <!-- If coach's admin status is NULL -->
                                @if ($coach->admin_status === NULL)
                                    <!-- Set admin button -->
                                    <form action="{{ route('set-admin-users', $coach->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"><i class="fas fa-times"></i></button>
                                    </form>
                                <!-- If coach's admin status is 1 -->
                                @else
                                    <!-- Remove admin button -->
                                    <form action="{{ route('set-admin-users', $coach->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                            </td><!-- Admin status END -->

                            <td>{{ $coach->created_at->format('d.m.Y') }}</td>

                            <!-- Banned status -->
                            <td class="text-center">
                                <!-- If coach's banned status is NULL -->
                                @if ($coach->banned === NULL)
                                    <!-- Ban coach button -->
                                    <form action="{{ route('ban-users', $coach->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"><i class="fas fa-times"></i></button>
                                    </form>
                                <!-- If coach's banned status is 1 -->
                                @else
                                    <!-- Remove ban button -->
                                    <form action="{{ route('ban-users', $coach->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                            </td><!-- Banned status END -->
                        </tr>
                    @endforeach <!-- Loop through coaches END -->
                </tbody>
            </table>
            {{ $coaches->links() }}
        </div>
    </div>
@endsection