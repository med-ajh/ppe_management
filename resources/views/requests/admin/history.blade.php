@extends('layouts.user_type.auth')


@section('content')
<div class="container">
    <h1>Request History</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('requests.admin.history') }}">
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
        <select name="status">
            <option value="all">All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <!-- Add other statuses as needed -->
        </select>
        <button type="submit">Search</button>
    </form>

    <!-- Display Cart Data -->
    @if($carts->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carts as $cart)
                    <tr>
                        <td>{{ $cart->id }}</td>
                        <td>{{ $cart->user->name ?? 'N/A' }}</td>
                        <td>{{ $cart->status }}</td>
                        <td>{{ $cart->created_at }}</td>
                        <td>
                            <a href="{{ route('requests.admin.show', $cart->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $carts->links() }}
    @else
        <p>No requests found.</p>
    @endif
</div>
@endsection
