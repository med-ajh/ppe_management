@extends('layouts.user_type.auth')

@section('content')
<div class="container">
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
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
        transition: transform 0.3s ease;
    }

    .card-hover:hover .card-img-container img {
        transform: scale(1.05);
    }

    .form-range {
        appearance: none;
        background: #e9ecef;
        height: 8px;
        border-radius: 4px;
        cursor: pointer;
        margin-bottom: 8px;
    }

    .form-range::-webkit-slider-thumb {
        appearance: none;
        width: 24px;
        height: 24px;
        background: #ff6f00; /* Orange color */
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .form-range::-webkit-slider-thumb:hover {
        background: #e65c00; /* Darker orange color */
    }

    .form-output {
        display: block;
        font-size: 1.2em;
        margin-top: 5px;
        color: #ff6f00; /* Orange color */
    }

    .btn-primary {
        background-color: #ff6f00; /* Orange color */
        border-color: #ff6f00; /* Orange color */
    }

    .btn-primary:hover {
        background-color: #e65c00; /* Darker orange color */
        border-color: #e65c00; /* Darker orange color */
    }
</style>
@endsection
