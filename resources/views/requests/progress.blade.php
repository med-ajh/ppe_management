@extends('layouts.user_type.auth')
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css.map') }}" rel="stylesheet" />
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Request Progress</h1>

    @if(!$cart)
        <div class="alert alert-info" role="alert">
            No request found. Please check your request history.
        </div>
    @else
        <div class="card shadow-lg border-light">
            <div class="card-body">
                <h5 class="card-title mb-4">Request Details</h5>

                <p><strong>Request ID:</strong> {{ $cart->id }}</p>
                <p><strong>Date:</strong> {{ $cart->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($cart->status) }}</p>

                <h6 class="mt-4 mb-3">Items in Request:</h6>
                <ul class="list-group mb-4">
                    @foreach ($cart->items as $cartItem)
                        @php
                            $item = $cartItem->item;
                        @endphp
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" style="width: 120px;">
                            <div class="ml-3">
                                <strong>{{ $item->name }}</strong> - Size: {{ $cartItem->size }} - Quantity: {{ $cartItem->quantity }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                <h6 class="mt-4 mb-3">Status Progress:</h6>
                <div class="progress-container">
                    @php
                        $steps = ['pending', 'reviewed', 'approved', 'processed', 'shipped', 'delivered', 'completed'];
                        $colors = [
                            'pending' => '#e0e0e0',
                            'reviewed' => '#e0e0e0',
                            'approved' => '#28a745',
                            'processed' => '#28a745',
                            'shipped' => '#28a745',
                            'delivered' => '#28a745',
                            'completed' => '#28a745'
                        ];
                        $currentIndex = array_search($cart->status, $steps);
                    @endphp

                    @foreach ($steps as $index => $step)
                        <div class="progress-step">
                            <div class="progress-bar {{ $index <= $currentIndex ? 'progress-bar-active' : '' }}" style="width: {{ (100 / count($steps)) * ($index + 1) }}%; background-color: {{ $colors[$step] }};">
                                {{ ucfirst($step) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    @if($cart->status == 'delivered')
                        <form action="{{ route('requests.confirmRequest', $cart->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Confirm Delivery</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .card-title {
        font-size: 2rem;
        font-weight: 600;
    }
    .list-group-item {
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    .img-thumbnail {
        border: 1px solid #ddd;
    }
    .progress-container {
        margin-top: 2rem;
        padding: 1rem;
        border-radius: 0.75rem;
        background-color: #f8f9fa;
    }
    .progress-step {
        position: relative;
        height: 3rem; /* Increase height for better visibility */
        margin-bottom: 1rem;
        background-color: #e0e0e0;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        font-size: 1.2rem; /* Increase font size for better visibility */
        font-weight: 600;
        line-height: 3rem; /* Align text vertically */
        text-align: center;
        color: #fff;
        transition: width 0.6s ease, background-color 0.6s ease;
        position: relative;
        white-space: nowrap;
    }
    .progress-bar-active {
        animation: progress-bar-slide 1s ease-in-out;
    }
    @keyframes progress-bar-slide {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@endpush
