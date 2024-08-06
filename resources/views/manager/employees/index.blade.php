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
    .btn-gray {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-gray:hover {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .btn-icon {
        padding: 0.5rem;
        border-radius: 0.25rem;
        font-size: 1.25rem;
        line-height: 1;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="mb-0">My Employees</h3>
        <a href="{{ route('manager.employees.create') }}" class="btn btn-primary">+ Add Employee</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Employee List</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search employees">
            </div>
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex align-items-center">
                                        @if($employee->role === 'manager')
                                            <img src="{{ asset('assets/img/manager.png') }}" alt="Manager" class="img-fluid small-avatar">
                                        @elseif($employee->role === 'admin')
                                            <img src="{{ asset('assets/img/admin.png') }}" alt="Admin" class="img-fluid small-avatar">
                                        @elseif($employee->role === 'employee')
                                            <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="img-fluid small-avatar">
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-xs">{{ $employee->name }} {{ $employee->lastname }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $employee->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->email }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $employee->te }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ ucfirst($employee->role) }}</p>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">
                                    {{ $employee->departement->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="align-middle text-center icon-actions">
                                <a href="{{ route('manager.employees.show', $employee->id) }}" class="btn btn-icon btn-gray" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-gray" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('keyup', '#searchInput', function() {
        var value = $(this).val().toLowerCase();
        $('#employeeTable tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>

@endsection
