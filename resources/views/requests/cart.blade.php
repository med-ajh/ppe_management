@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>My Cart</h1>

    @if($cart->items->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" width="100" height="100">
                    </td>
                    <td>{{ $item->item->name }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <form action="{{ route('requests.removeItem', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                        <a href="{{ route('requests.editItem', $item->id) }}" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('requests.confirmRequests') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Confirm Requests</button>
        </form>
    @endif
</div>
@endsection
