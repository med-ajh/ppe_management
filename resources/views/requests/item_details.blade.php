@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>{{ $item->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $item->image }}" class="img-fluid" alt="{{ $item->name }}">
        </div>
        <div class="col-md-6">
            <p>{{ $item->description }}</p>
            <p><strong>Status:</strong> {{ $item->status }}</p>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                </div>

                <div class="form-group mt-2">
                    <label for="size">Size (Optional)</label>
                    <input type="text" name="size" id="size" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
            </form>
        </div>
    </div>
    <a href="{{ route('requests.create') }}" class="btn btn-secondary mt-3">Back to Items</a>
</div>
@endsection
