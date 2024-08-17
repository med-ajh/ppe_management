@extends('layouts.user_type.auth')
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css.map') }}" rel="stylesheet" />

@section('content')
<div class="container">
    <h1>Edit Item</h1>

    <form action="{{ route('requests.updateItem', $cartItem->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ $cartItem->size }}">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ $cartItem->quantity }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection
