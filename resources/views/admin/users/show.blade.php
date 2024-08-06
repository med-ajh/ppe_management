@extends('layouts.user_type.auth')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">User Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="border rounded-circle p-3 mb-3 d-inline-block" style="border: 3px solid #f0f0f0; background-color: #fff;">
                        @if($user->role === 'manager')
                            <img src="{{ asset('assets/img/manager.png') }}" alt="Manager" class="img-fluid rounded-circle" style="max-width: 80px;">
                        @elseif($user->role === 'admin')
                            <img src="{{ asset('assets/img/admin.png') }}" alt="Admin" class="img-fluid rounded-circle" style="max-width: 80px;">
                        @elseif($user->role === 'employee')
                            <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="img-fluid rounded-circle" style="max-width: 80px;">
                        @endif
                    </div>
                    <h5 class="mb-0">{{ $user->name }} {{ $user->lastname }}</h5>
                    <p class="text-muted">
                        <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                    </p>
                    <p class="text-muted">
                        @if($user->role === 'manager')
                            <i class="fas fa-crown me-2"></i>Manager
                        @elseif($user->role === 'admin')
                            <i class="fas fa-user-shield me-2"></i>Admin
                        @elseif($user->role === 'employee')
                            <i class="fas fa-user me-2"></i>Employee
                        @endif
                    </p>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-id-card me-2"></i>TE ID:</strong>
                                    <span>{{ $user->te }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-building me-2"></i>Department:</strong>
                                    <span>{{ $user->departement->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        @if(!$user->isAdmin())
                            <div class="col-md-6 mb-3">
                                <div class="border p-2 rounded bg-light">
                                    <div class="d-flex justify-content-between">
                                        <strong><i class="fas fa-cogs me-2"></i>Cost Center:</strong>
                                        <span>{{ $user->costCenter->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($user->isEmployee())
                            <div class="col-md-6 mb-3">
                                <div class="border p-2 rounded bg-light">
                                    <div class="d-flex justify-content-between">
                                        <strong><i class="fas fa-user-tie me-2"></i>Manager:</strong>
                                        <span>{{ $user->manager ? $user->manager->name . ' ' . $user->manager->lastname : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group text-end mt-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection
