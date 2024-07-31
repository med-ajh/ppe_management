@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Details</h1>

    <div class="card">
        <div class="card-header">
            Details of {{ $employee->name }} {{ $employee->lastname }}
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>First Name:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->name }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Last Name:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->lastname }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Email:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->email }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Department:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->department ? $employee->department->name : 'N/A' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Cost Center:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->costCenter ? $employee->costCenter->name : 'N/A' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>TE:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->te }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Manager:</strong>
                </div>
                <div class="col-md-9">
                    {{ $employee->manager ? $employee->manager->name . ' ' . $employee->manager->lastname : 'N/A' }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex">
                <a href="{{ route('manager.employees.edit', $employee->id) }}" class="btn btn-warning mr-2">Edit Employee</a>
                <form action="{{ route('manager.employees.destroy', $employee->id) }}" method="POST" id="delete-form" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Employee</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection
