@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $item->name }}</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $item->image }}" class="img-fluid" alt="{{ $item->name }}">
            </div>
            <div class="col-md-6">
                <p>{{ $item->description }}</p>
                <form action="{{ route('requests.addToCart', $item->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="number" name="size" id="size" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
@endsection
