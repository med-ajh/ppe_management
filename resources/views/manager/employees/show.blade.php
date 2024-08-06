@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Employee Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($user->role === 'manager')
                        <img src="{{ asset('assets/img/manager.png') }}" alt="Manager" class="img-fluid small-avatar">
                    @elseif($user->role === 'admin')
                        <img src="{{ asset('assets/img/admin.png') }}" alt="Admin" class="img-fluid small-avatar">
                    @elseif($user->role === 'employee')
                        <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="img-fluid small-avatar">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <p class="form-control-plaintext">{{ $user->name }} {{ $user->lastname }}</p>
                    </div>

                    <div class="form-group">
                        <label for="te">TE ID</label>
                        <p class="form-control-plaintext">{{ $user->te }}</p>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <p class="form-control-plaintext">{{ $user->email }}</p>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                    </div>

                    @if($user->role === 'employee')
                    <div class="form-group">
                        <label for="department">Department</label>
                        <p class="form-control-plaintext">{{ $user->departement->name ?? 'N/A' }}</p>
                    </div>

                    <div class="form-group">
                        <label for="cost_center">Cost Center</label>
                        <p class="form-control-plaintext">{{ $user->costCenter->name ?? 'N/A' }}</p>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="manager">Manager</label>
                        <p class="form-control-plaintext">
                            {{ $user->manager ? $user->manager->name . ' ' . $user->manager->lastname : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <a href="{{ route('manager.employees.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection
