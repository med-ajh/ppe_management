@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Requests History</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('requests.admin.history') }}" class="mb-4">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by Request ID, User Name or Email" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-3">
                <select name="status" class="form-control">
                    <option value="all">All Statuses</option>
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
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Request History Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Status</th>
                <th>Items</th>
                <th>Total Quantity</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($carts as $cart)
                <tr>
                    <td>{{ $cart->id }}</td>
                    <td>{{ $cart->user->name }} ({{ $cart->user->email }})</td>
                    <td>{{ ucfirst($cart->status) }}</td>
                    <td>
                        <ul>
                            @foreach ($cart->items as $item)
                                <li>{{ $item->name }} (Size: {{ $item->pivot->size }}, Quantity: {{ $item->pivot->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $cart->items->sum('pivot.quantity') }}</td>
                    <td>{{ $cart->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $carts->links() }}
</div>
@endsection
