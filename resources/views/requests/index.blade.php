<!-- resources/views/requests/index.blade.php -->

@extends('layouts.user_type.auth')


@section('content')
<div class="container">
    <h1>Available Items</h1>
    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" name="size" id="size" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
