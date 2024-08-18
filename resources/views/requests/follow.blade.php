@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Your Requests</h2>

    @if ($carts->isEmpty())
        <div class="alert alert-info">You have no requests at the moment.</div>
    @else
        @foreach ($carts->sortByDesc('created_at') as $cart)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Request #{{ $cart->id }}</h5>
                    <p class="card-title">Status : {{ ucfirst($cart->status) }}</p>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Items in this Request</h6>
                    @if ($cart->items->isEmpty())
                        <p>No items in this request.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" style="width: 100px; height: auto; border-radius: 8px;">
                                        </td>
                                        <td>{{ $item->item->name }}</td>
                                        <td>{{ $item->size }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer text-muted">
                    Requested on: {{ $cart->created_at->format('d M Y, H:i') }}
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
