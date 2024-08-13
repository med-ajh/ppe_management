@extends('layouts.user_type.auth')

@section('content')

<style>
    .small-avatar {
        width: 150px; /* Adjust size as needed */
        height: 150px; /* Square image */
        object-fit: cover; /* Maintain aspect ratio */
        border-radius: 50%; /* Circular images */
        margin-bottom: 10px; /* Space between image and name */
    }
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Space between cards */
        justify-content: center; /* Center the cards */
    }
    .employee-card {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        width: 200px; /* Fixed width for uniformity */
    }
    .employee-name {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .icon-actions {
        display: flex;
        justify-content: center;
        gap: 10px; /* Space between action buttons */
        margin-top: 10px;
    }
    .icon-button {
        border: none;
        background: none;
        cursor: pointer;
        color: #6c757d; /* Gray color */
    }
    .icon-button i {
        font-size: 18px; /* Adjust size as needed */
    }
    .icon-button:hover {
        color: #ff8000; /* Highlight color on hover */
    }
    .add-user-btn {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Employees</h5>
        <div class="add-user-btn">
            <a href="{{ route('manager.employees.create') }}" class="btn btn-success">Add Employee</a>
        </div>
    </div>
    <div class="card-body">
        @if ($employees->count() > 0)
            <div class="card-container">
                @foreach ($employees as $employee)
                    <div class="employee-card">
                        <img src="{{ $employee->picture ? asset('storage/' . $employee->picture) : asset('assets/img/employee.png') }}"
                             alt="{{ $employee->name }} {{ $employee->lastname }}"
                             class="small-avatar">
                        <div class="employee-name">{{ $employee->name }} {{ $employee->lastname }}</div>
                        <div class="icon-actions">
                            <a href="{{ route('manager.employees.show', $employee->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="View employee">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('manager.employees.edit', $employee->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="Edit employee">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-button" data-toggle="tooltip" data-original-title="Delete employee">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No employees found.</p>
        @endif
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this employee?');
    }
</script>

@endsection
