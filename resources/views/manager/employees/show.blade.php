@extends('layouts.user_type.auth')
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css.map') }}" rel="stylesheet" />

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Employee Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="border rounded-circle p-3 mb-3 d-inline-block" style="border: 3px solid #f0f0f0; background-color: #fff;">
                        <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="img-fluid rounded-circle" style="max-width: 80px;">
                    </div>
                    <h5 class="mb-0">{{ $employee->name }} {{ $employee->lastname }}</h5>
                    <p class="text-muted">
                        <i class="fas fa-envelope me-2"></i>{{ $employee->email }}
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-user me-2"></i>{{ $employee->role }}
                    </p>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <!-- Employee ID -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-id-card me-2"></i>Employee ID:</strong>
                                    <span>{{ $employee->te }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Department -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-building me-2"></i>Department:</strong>
                                    <span>{{ $employee->department->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Cost Center -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-cogs me-2"></i>Cost Center:</strong>
                                    <span>{{ $employee->cost_center ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Value Stream -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-stream me-2"></i>Value Stream:</strong>
                                    <span>{{ $employee->valueStream->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Manager -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-user-tie me-2"></i>Manager:</strong>
                                    <span>{{ $employee->manager ? $employee->manager->name . ' ' . $employee->manager->lastname : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- TE ID -->

                        <!-- Created At -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-calendar me-2"></i>Created At:</strong>
                                    <span>{{ $employee->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Updated At -->
                        <div class="col-md-6 mb-3">
                            <div class="border p-2 rounded bg-light">
                                <div class="d-flex justify-content-between">
                                    <strong><i class="fas fa-calendar-day me-2"></i>Updated At:</strong>
                                    <span>{{ $employee->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-end mt-3">
                <a href="{{ route('manager.employees.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

@endsection
