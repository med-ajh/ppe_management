@extends('layouts.user_type.auth')
<!-- resources/views/requests/admin/index.blade.php -->


@section('content')
<div class="container mt-5">
    <h1 class="mb-4">All Requests</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('requests.admin.history') }}">
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search requests" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- Display Requests -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>User</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $cart)
                <tr>
                    <td>{{ $cart->id }}</td>
                    <td>{{ $cart->user->name }}</td>
                    <td>{{ ucfirst($cart->status) }}</td>
                    <td>{{ $cart->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('requests.admin.show', $cart->id) }}" class="btn btn-info">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
</div>
@endsection
