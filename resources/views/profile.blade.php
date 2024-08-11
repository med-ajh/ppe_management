@extends('layouts.user_type.auth')

@section('content')

<div>
    <!-- Page Header -->
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/te.jpg'); background-size: cover; background-position: center;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>

        <!-- User Info Card -->
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4 align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        @if($user->role === 'manager')
                            <img src="{{ asset('../assets/img/manager.png') }}" alt="Manager" class="img-fluid rounded-circle border border-2 border-light" style="max-width: 200px;">
                        @elseif($user->role === 'admin')
                            <img src="{{ asset('../assets/img/admin.png') }}" alt="Admin" class="img-fluid rounded-circle border border-2 border-light" style="max-width: 200px;">
                        @elseif($user->role === 'employee')
                            <img src="{{ asset('../assets/img/employee.png') }}" alt="Employee" class="img-fluid rounded-circle border border-2 border-light" style="max-width: 200px;">
                        @endif
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1" style="font-family: 'Helvetica Neue', sans-serif; color: #333;">
                            {{ $user->name }} {{ $user->lastname }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm" style="font-family: 'Helvetica Neue', sans-serif; color: #666;">
                            {{ $user->role }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="card card-body blur shadow-blur mx-4 mt-4">
            <div class="card-header" style="border: none; background: none; text-align: left;">
                <h2 class="mb-0" style="font-family: 'Helvetica Neue', sans-serif;">
                    {{ __('Personal Information') }}
                </h2>
            </div>
            <br>
            <div class="card-body pt-4 p-4">
                <form action="/user-profile" method="POST" role="form text-left">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-text">{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Personal Information Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                <i class="fa fa-id-badge fa-lg me-3 text-secondary"></i>
                                <div>
                                    <strong class="d-block mb-1">TE Connectivity ID:</strong>
                                    <p class="mb-0 text-muted">{{ $user->te }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                <i class="fa fa-envelope fa-lg me-3 text-secondary"></i>
                                <div>
                                    <strong class="d-block mb-1">Email:</strong>
                                    <p class="mb-0 text-muted">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                <i class="fa fa-stream fa-lg me-3 text-secondary"></i>
                                <div>
                                    <strong class="d-block mb-1">Value Stream:</strong>
                                    <p class="mb-0 text-muted">{{ $user->valueStream ? $user->valueStream->name : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                <i class="fa fa-building fa-lg me-3 text-secondary"></i>
                                <div>
                                    <strong class="d-block mb-1">Department:</strong>
                                    <p class="mb-0 text-muted">{{ $user->department ? $user->department->name : 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                <i class="fa fa-cogs fa-lg me-3 text-secondary"></i>
                                <div>
                                    <strong class="d-block mb-1">Cost Center:</strong>
                                    <p class="mb-0 text-muted">{{ $user->cost_center ?: 'N/A' }}</p>
                                </div>
                            </div>

                            @if($user->role === 'employee')
                                <div class="d-flex align-items-center mb-4" style="font-size: 1rem; font-family: 'Helvetica Neue', sans-serif; color: #333;">
                                    <i class="fa fa-user-tie fa-lg me-3 text-secondary"></i>
                                    <div>
                                        <strong class="d-block mb-1">Manager:</strong>
                                        <p class="mb-0 text-muted">{{ $user->manager ? $user->manager->name : 'N/A' }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.min.js"></script>
@endsection
