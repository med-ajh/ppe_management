@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <!-- Total Users Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $users->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Departments Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Departments</h5>
                    <p class="card-text">{{ $departments->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Cost Centers Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Cost Centers</h5>
                    <p class="card-text">{{ $costCenters->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Users" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <select name="role" class="form-control mt-2">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="department_id" class="form-control mt-2">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2 class="mb-4">Users List</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>TE</th>
                <th>Role</th>
                <th>Department</th>
                <th>Cost Center</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->te }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->department ? $user->department->name : 'N/A' }}</td>
                <td>{{ $user->costCenter ? $user->costCenter->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $users->links() }}

    <!-- Recent Activity -->
    <div class="mt-5">
        <h2>Recent Activity</h2>
        <ul class="list-group">
            @foreach($recentActivities as $activity)
                <li class="list-group-item">
                    {{ $activity->description }} <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
