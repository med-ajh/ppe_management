@extends('layouts.user_type.auth')

@section('content')

<div class="card">
    <div class="card-header">
        <h2 class="mb-0">User Details</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h5>Full Name</h5>
                <p>{{ $user->name }} {{ $user->lastname }}</p>
            </div>
            <div class="col-md-4">
                <h5>Email</h5>
                <p>{{ $user->email }}</p>
            </div>
            <div class="col-md-4">
                <h5>TE ID</h5>
                <p>{{ $user->te }}</p>
            </div>
            <div class="col-md-4">
                <h5>Role</h5>
                <p>{{ ucfirst($user->role) }}</p>
            </div>
            <div class="col-md-4">
                <h5>Value Stream</h5>
                <p>{{ $user->valueStream->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <h5>Department</h5>
                <p>{{ $user->departement->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-4">
                <h5>Manager</h5>
                <p>{{ $user->manager ? $user->manager->name . ' ' . $user->manager->lastname : 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection
