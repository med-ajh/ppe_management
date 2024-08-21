@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Your Requests</h2>

    @if ($carts->isEmpty())
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Info:</strong> You have no requests at the moment.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @else
        @foreach ($carts->sortByDesc('created_at') as $cart)
            <div class="card mb-4 rounded-4 shadow-lg border-0 transition-transform hover:scale-105 hover:shadow-xl">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center p-3">
                    <h5 class="card-title mb-0">{{ __('Request #') . $cart->id }}</h5>
                    <span class="badge bg-primary rounded-pill">{{ ucfirst($cart->status) }}</span>
                </div>
                <div class="card-body p-4">
                    <!-- Status Progress Bar -->
                    @php
                        $statuses = ['pending', 'confirmed', 'reviewed', 'approved', 'processed', 'shipped', 'delivered', 'completed'];
                        $currentStatusIndex = array_search($cart->status, $statuses);
                        $totalStatuses = count($statuses);

                        // Ensure currentStatusIndex is valid
                        $currentStatusIndex = $currentStatusIndex === false ? 0 : $currentStatusIndex;

                        // Calculate progress percentage
                        $progressPercentage = ($currentStatusIndex + 1) * (100 / $totalStatuses);

                        // Calculate color based on the progress percentage
                        $colors = [
                            'red',       // 0-14.29%
                            'orange',    // 14.30-28.57%
                            'gold',      // 28.58-42.85%
                            'yellow',    // 42.86-57.14%
                            'greenyellow',// 57.15-71.42%
                            'limegreen', // 71.43-85.71%
                            'green'      // 85.72-100%
                        ];
                        $progressColor = $colors[min($currentStatusIndex, count($colors) - 1)];
                    @endphp
                    <div class="progress-bar-container">
                        <div class="progress-percentage">
                            <div class="percentage-bar" style="width: {{ $progressPercentage }}%; background-color: {{ $progressColor }};">
                                <span class="percentage-text">{{ round($progressPercentage) }}%</span>
                            </div>
                        </div>
                    </div>

                    <h6 class="card-subtitle mb-3 text-muted">Items in this Request</h6>
                    @if ($cart->items->isEmpty())
                        <p class="text-muted">No items in this request.</p>
                    @else
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-muted">Image</th>
                                    <th class="text-muted">Item</th>
                                    <th class="text-muted">Size</th>
                                    <th class="text-muted">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" class="item-image transition-transform hover:scale-110">
                                        </td>
                                        <td>{{ $item->item->name }}</td>
                                        <td>{{ $item->size }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="mt-3">
                        <h6 class="card-subtitle mb-2 text-muted">Additional Information</h6>
                        <p><strong>Value Stream:</strong> {{ $cart->department && $cart->department->valueStream ? $cart->department->valueStream->name : '-' }}</p>
                        <p><strong>Department:</strong> {{ $cart->department ? $cart->department->name : '-' }}</p>
                        <p><strong>Cost Center:</strong> {{ $cart->department ? $cart->department->cost_center : '-' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-light text-muted border-0 p-3">
                    Requested on: {{ $cart->created_at->format('d M Y, H:i') }}
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
        background-color: #f9f9f9;
    }

    .item-image {
        max-width: 100px;
        height: auto;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .item-image:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table td, .table th {
        padding: 12px;
        vertical-align: middle;
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .alert {
        border-radius: 12px;
        padding: 16px;
        font-size: 14px;
    }

    .btn-close {
        filter: brightness(0.8);
    }

    .btn-close:hover {
        filter: brightness(1);
    }

    .progress-bar-container {
        position: relative;
        margin-bottom: 20px;
    }

    .progress-percentage {
        position: relative;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 10px;
    }

    .percentage-bar {
        height: 100%;
        transition: width 0.5s ease, background-color 0.5s ease;
        position: relative;
    }

    .percentage-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        font-size: 14px;
        transition: opacity 0.5s ease;
    }
</style>
@endsection
