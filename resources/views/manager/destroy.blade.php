@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Delete Employee</h1>

    <div class="card">
        <div class="card-header">
            Confirm Deletion
        </div>
        <div class="card-body">
            <p>Are you sure you want to delete the employee <strong>{{ $employee->name }} {{ $employee->lastname }}</strong>? This action cannot be undone.</p>

            <div class="d-flex">
                <!-- Form to delete the employee -->
                <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" class="mr-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Employee</button>
                </form>

                <!-- Back to employee details -->
                <a href="{{ route('manager.employees.show', $employee->id) }}" class="btn btn-secondary">Back to Details</a>
            </div>
        </div>
    </div>
</div>
@endsection
