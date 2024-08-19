@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Available Items</h1>
    <div class="row g-4 justify-content-center">
        @foreach($items as $item)
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="card mb-4 shadow-sm" style="display: flex; flex-direction: column; height: 670px;">
                <div class="card-img-container" style="height: 500px; overflow: hidden; background-color: #f8f9fa;">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: contain; object-position: center;">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">{{ $item->name }}</h5>
                    <p class="card-text text-center">{{ $item->description }}</p>
                    <form action="{{ route('requests.store') }}" method="POST" class="mt-auto text-center">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div class="form-group mb-3">
                            <label for="quantity">Quantity</label>
                            <input type="range" name="quantity" id="quantity" class="form-range" min="1" max="50" step="1" value="1" style="width: 100%;">
                            <output id="quantityOutput">1</output>
                        </div>
                        <div class="form-group mb-3">
                            <label for="size">Size</label>
                            <input type="text" name="size" id="size" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.querySelectorAll('input[type="range"]').forEach(range => {
        const output = range.nextElementSibling;
        range.addEventListener('input', () => {
            output.textContent = range.value;
        });
        // Initialize the output value
        output.textContent = range.value;
    });
</script>
@endsection
