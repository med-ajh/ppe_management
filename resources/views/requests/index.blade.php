@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Available Items</h1>
    <div class="row g-4 justify-content-center">
        @foreach($items as $item)
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="card mb-4 shadow-sm card-hover" style="display: flex; flex-direction: column; height: 670px;">
                <div class="card-img-container">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}">
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
                            <output id="quantityOutput" class="form-output">1</output>
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

<style>
    .card-hover {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .card-hover:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }

    .card-img-container {
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .card-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease, filter 0.4s ease;
        filter: grayscale(100%);
    }

    .card-hover:hover .card-img-container img {
        transform: scale(1.1);
        filter: grayscale(0%);
    }

    .form-range {
        appearance: none;
        background: #e9ecef;
        height: 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 8px;
    }

    .form-range::-webkit-slider-thumb {
        appearance: none;
        width: 30px;
        height: 30px;
        background: #ff8000; /* Orange color */
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.4s ease, transform 0.4s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .form-range::-webkit-slider-thumb:hover {
        background: #e67300; /* Darker orange color */
        transform: scale(1.2);
    }

    .form-output {
        display: block;
        font-size: 1.2em;
        margin-top: 5px;
        color: #ff8000; /* Orange color */
    }

    .btn-primary {
        background-color: #ff8000; /* Orange color */
        border-color: #ff8000; /* Orange color */
        transition: background-color 0.4s ease, box-shadow 0.4s ease;
    }

    .btn-primary:hover {
        background-color: #e67300; /* Darker orange color */
        border-color: #e67300; /* Darker orange color */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection
