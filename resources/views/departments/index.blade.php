@extends('layouts.user_type.auth')

@section('content')

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem; /* Space between cards */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e1e4e8;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-body {
        padding: 1.5rem;
    }
    .table thead th {
        background-color: #f7f9fc;
        color: #333;
        border-bottom: 2px solid #e1e4e8;
        text-align: center; /* Center align header text */
    }
    .table tbody tr:hover {
        background-color: #f1f1f1;
        transform: scale(1.01);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .table tbody td {
        text-align: center; /* Center align table data */
        vertical-align: middle; /* Center align content vertically */
    }
    .icon-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }
    .icon-button {
        border: none;
        background: none;
        cursor: pointer;
        color: #6c757d; /* Grey color */
        transition: color 0.3s ease, transform 0.3s ease;
    }
    .icon-button i {
        font-size: 18px;
    }
    .icon-button:hover {
        color: #ff8000; /* Orange color on hover */
        transform: scale(1.1); /* Slightly enlarge icon on hover */
    }
    .search-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .search-form .form-control {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #e1e4e8;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .search-form .form-control:focus {
        border-color: #ff8000; /* Orange color */
        box-shadow: 0 0 8px rgba(255, 128, 0, 0.3);
    }
    .search-form .btn {
        border-radius: 10px;
        padding: 10px 20px;
        background-color: #ff8000; /* Grey color */
        color: #ffffff;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .search-form .btn:hover {
        background-color: #ff4400; /* Orange color on hover */
        transform: scale(1.05);
    }
    .add-department-btn {
        margin-bottom: 20px;
    }

    .add-department-btn .btn:hover {
        background-color: #218838; /* Darker green on hover */
        transform: scale(1.05);
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <form action="{{ route('departments.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search departments..." value="{{ request('search') }}" class="form-control">
                <button type="submit" class="btn">Search</button>
            </form>
            @if(Auth::user()->role === 'admin')
            <div class="add-department-btn">
                <a href="{{ route('departments.create') }}" class="btn btn-success">Add Department</a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Name</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Cost Center</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Value Stream</th>
                            @if(Auth::user()->role === 'admin')
                            <th class="text-secondary opacity-7"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $department)
                        <tr>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $department->name }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $department->cost_center }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $department->valueStream->name ?? 'N/A' }}</p>
                            </td>
                            @if(Auth::user()->role === 'admin')
                            <td class="align-middle">
                                <div class="icon-actions">
                                    <a href="{{ route('departments.show', $department->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="View department">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('departments.edit', $department->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="Edit department">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-button" data-toggle="tooltip" data-original-title="Delete department">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this department?');
    }
</script>

@endsection
