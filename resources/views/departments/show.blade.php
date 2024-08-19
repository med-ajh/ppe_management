@extends('layouts.user_type.auth')

@section('content')

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e1e4e8;
        padding: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .btn {
        border-radius: 10px;
        padding: 10px 20px;
        background-color: #6c757d; /* Grey color */
        color: #ffffff;
        border: none;
        transition: background-color 0.3s ease;
    }
    .btn:hover {
        background-color: #ff8000; /* Orange color on hover */
    }
    .user-list {
        margin-top: 20px;
    }
    .user-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #e1e4e8;
    }
    .user-item img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        object-fit: cover;
        margin-right: 10px;
    }
    .user-item h6 {
        margin: 0;
        font-size: 16px;
    }
    .user-item p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
    }
    .back-button {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $department->name }}</h3>
                @if(Auth::user()->role === 'admin')
                <div class="d-flex">
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn me-2">Edit</a>
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirmDelete();" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn">Delete</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Details</h5>
            <p><strong>Cost Center:</strong> {{ $department->cost_center }}</p>
            <p><strong>Value Stream:</strong> {{ $department->valueStream->name }}</p>

            @if($department->users->isNotEmpty())
            <div class="user-list">
                <h5 class="mb-3">Users in this Department</h5>
                @foreach($department->users as $user)
                <div class="user-item">
                        @if($user->role === 'manager')
                            <img src="{{ asset('assets/img/manager.png') }}" alt="Manager" class="small-avatar">
                        @elseif($user->role === 'admin')
                            <img src="{{ asset('assets/img/admin.png') }}" alt="Admin" class="small-avatar">
                        @elseif($user->role === 'employee')
                            <img src="{{ asset('assets/img/employee.png') }}" alt="Employee" class="small-avatar">
                        @endif
                    <div>
                        <h6>{{ $user->name }}  {{ $user->lastname }}</h6>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="back-button">
                <a href="{{ route('departments.index') }}" class="btn">Back to List</a>
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
