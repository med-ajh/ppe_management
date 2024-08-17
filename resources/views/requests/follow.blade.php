@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">My Active Requests</h1>

    @if($carts->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            You have no active requests.
        </div>
    @else
        <div class="row">
            @foreach($carts as $cart)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Request ID: {{ $cart->id }}</h5>
                            <p class="card-text text-muted mb-3">
                                <strong>Date:</strong> {{ $cart->created_at->format('M d, Y h:i A') }}<br>
                                <strong>Status:</strong>
                            </p>
                            <!-- Progress Bar -->
                            <div class="progress mb-3 custom-progress-bar">
                                <div class="progress-bar {{ getProgressBarClass($cart->status) }}"
                                     role="progressbar"
                                     style="width: {{ getStatusPercentage($cart->status) }}%;"
                                     aria-valuenow="{{ getStatusPercentage($cart->status) }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    <span class="progress-bar-text">
                                        {{ getStatusPercentage($cart->status) }}%
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('requests.showRequestProgress', $cart->id) }}" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@php
function getStatusPercentage($status) {
    $percentages = [
        'pending' => 14,
        'reviewed' => 28,
        'approved' => 42,
        'processed' => 57,
        'shipped' => 71,
        'delivered' => 85,
        'completed' => 100
    ];

    return $percentages[$status] ?? 0;
}

function getProgressBarClass($status) {
    $classes = [
        'pending' => 'bg-warning',
        'reviewed' => 'bg-warning',
        'approved' => 'bg-warning',
        'processed' => 'bg-warning',
        'shipped' => 'bg-warning',
        'delivered' => 'bg-warning',
        'completed' => 'bg-success'
    ];

    return $classes[$status] ?? 'bg-light';
}
@endphp
