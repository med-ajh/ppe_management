@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Request Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Request ID: {{ $cart->id }}</h5>
            <p class="card-text">
                <strong>User:</strong> {{ $cart->user->name }} ({{ $cart->user->email }})<br>
                <strong>Status:</strong> <span class="badge {{ getStatusBadgeClass($cart->status) }}">{{ ucfirst($cart->status) }}</span><br>
                <strong>Created At:</strong> {{ $cart->created_at->format('M d, Y H:i') }}
            </p>

            <h5 class="mt-4">Items</h5>
            @if($cart->items->isEmpty())
                <div class="alert alert-info" role="alert">
                    No items found in this request.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                            <tr>
                                <td>{{ $item->item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->size }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endpush
