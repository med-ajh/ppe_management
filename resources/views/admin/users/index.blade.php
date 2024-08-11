@extends('layouts.user_type.auth')

@section('content')

<style>
    .small-avatar {
        max-width: 50px; /* Adjust size as needed */
        height: auto; /* Maintain aspect ratio */
    }
    .icon-actions {
        display: flex;
        gap: 10px; /* Adjust spacing as needed */
        align-items: center; /* Align buttons */
    }
    .icon-button {
        border: none;
        background: none;
        cursor: pointer;
        color: #6c757d; /* Gray color */
    }
    .icon-button i {
        font-size: 16px; /* Adjust size as needed */
    }
    .icon-button:hover {
        color: #ff8000; /* Darker gray on hover */
    }
    .search-form {
        display: flex;
        gap: 10px; /* Space between elements */
        align-items: center;
    }
    .search-form .form-control {
        flex: 1; /* Allow inputs to grow */
        margin-right: 10px; /* Add space between inputs and button */
    }
    .search-form .btn {
        flex-shrink: 0; /* Prevent button from shrinking */
        margin: 0; /* Remove any default margin */
    }
    .add-user-btn {
        margin-bottom: 15px;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <form action="{{ route('admin.users.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="form-control">
                <select name="role" class="form-control">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="add-user-btn">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">Add User</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Full Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TE ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Value Stream</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Manager</th>
                    <th class="text-secondary opacity-7"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex align-items-center">
                                @if($user->role === 'manager')
                                    <img src="{{ asset('assets/img/manager.png') }}" alt="Manager" class="small-avatar">
                                @elseif($user->role === 'admin')
                                    <img src="{{ asset('assets/img/admin.png') }}" alt="Admin" class="small-avatar">
                                @elseif($user->role === 'employee')
                                    <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="small-avatar">
                                @endif
                            </div>
                            <div class="d-flex flex-column justify-content-center ms-3">
                                <h6 class="mb-0 text-xs">{{ $user->name }} {{ $user->lastname }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $user->te }}</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ ucfirst($user->role) }}</p>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            {{ $user->valueStream->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            {{ $user->department->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            {{ $user->manager ? $user->manager->name . ' ' . $user->manager->lastname : '-' }}
                        </span>
                    </td>
                    <td class="align-middle">
                        <div class="icon-actions">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="View user">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="Edit user">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-button" data-toggle="tooltip" data-original-title="Delete user">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }
</script>

@endsection
