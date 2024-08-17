@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">Request History</h1>

    @if($carts->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            You have no past requests.
        </div>
    @else
        <div class="row">
            @foreach($carts as $cart)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary mb-3">Request ID: {{ $cart->id }}</h5>
                            <p class="card-text text-muted mb-3">
                                <strong>Date:</strong> {{ $cart->created_at->format('M d, Y h:i A') }}<br>
                                <strong>Status:</strong>
                                <span class="badge {{ getStatusBadgeClass($cart->status) }}">{{ ucfirst($cart->status) }}</span>
                            </p>
                            <a href="{{ route('requests.showRequestProgress', $cart->id) }}" class="btn btn-info mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
    }
    .card-text {
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    .badge {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        transition: background-color 0.3s ease;
    }
    .btn-info:hover {
        background-color: #117a8b;
        border-color: #10707f;
    }
</style>
@endpush
