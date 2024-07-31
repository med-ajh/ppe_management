@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Employees under {{ Auth::user()->name }}</h1>

    <!-- Dashboard Stats -->
    <div class="row mb-4">
        <!-- Total Employees Card -->
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text">{{ $employees->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-4 d-flex justify-content-between">
        <div>
            <a href="{{ route('manager.create') }}" class="btn btn-primary">Add Employee</a>
            <a href="{{ route('manager.activities') }}" class="btn btn-secondary">View Employee Activities</a>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('manager.dashboard') }}" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search Employees" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <select name="department_id" class="form-control mt-2">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="role" class="form-control mt-2">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="cost_center" class="form-control mt-2">
                    <option value="">All Cost Centers</option>
                    @foreach($costCenters as $costCenter)
                        <option value="{{ $costCenter->id }}" {{ request('cost_center') == $costCenter->id ? 'selected' : '' }}>
                            {{ $costCenter->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <!-- Employees Table -->
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Role</th>
                <th>TE</th>
                <th>Cost Center</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->lastname }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->department ? $employee->department->name : 'N/A' }}</td>
                <td>{{ ucfirst($employee->role) }}</td>
                <td>{{ $employee->te }}</td>
                <td>{{ $employee->costCenter ? $employee->costCenter->name : 'N/A' }}</td>
                <td>
                    <a href="{{ route('manager.employees.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('manager.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" class="d-inline-block" id="delete-form-{{ $employee->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $employee->id }})">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No employees found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $employees->links() }}

    <!-- Recent Activities -->
    <div class="mt-5">
        <h2>Recent Activities</h2>
        <ul class="list-group">
            @foreach($recentActivities as $activity)
                <li class="list-group-item">
                    {{ $activity->description }} <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
function confirmDelete(employeeId) {
    if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
        document.getElementById('delete-form-' + employeeId).submit();
    }
}
</script>
@endsection
