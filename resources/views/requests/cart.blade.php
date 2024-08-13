@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1 class="mb-4">Your Cart</h1>

        @if($cart && !$cart->items->isEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $cartItem)
                        <tr>
                            <td>{{ $cartItem->item->name }}</td>
                            <td>{{ $cartItem->size }}</td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>
                                <!-- Actions can be added here if needed -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('cart.confirmRequest') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Confirm Request</button>
            </form>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
