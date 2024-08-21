@extends('layouts.user_type.auth')

@section('content')

<style>
    .small-avatar {
        max-width: 50px;
        height: auto;
        border-radius: 50%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .small-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .icon-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .icon-button {
        border: none;
        background: none;
        cursor: pointer;
        color: #6c757d;
        transition: color 0.3s ease, transform 0.3s ease;
        font-size: 18px;
    }
    .icon-button:hover {
        color: #ff8000;
        transform: scale(1.1);
    }
    .search-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .search-form .form-control {
        flex: 1;
        margin-right: 12px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .search-form .btn {
        flex-shrink: 0;
        margin: 0;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .search-form .btn:hover {
        background-color: #004085;
    }
    .add-user-btn {
        margin-bottom: 15px;
        display: flex;
        justify-content: flex-end;
    }
    .table thead th {
        background-color: #f8f9fa;
        color: #343a40;
        font-size: 14px;
        font-weight: 600;
    }
    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .table tbody tr:hover {
        background-color: #e2e6ea;
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cost center</th>
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
                            {{ $user->cost_center ?? '-' }}
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
