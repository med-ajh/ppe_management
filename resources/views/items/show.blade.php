@extends('layouts.user_type.auth')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-body p-4">
                    <div class="text-center">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="img-fluid rounded shadow-sm">
                        @else
                            <img src="https://via.placeholder.com/600x400" alt="Placeholder Image" class="img-fluid rounded shadow-sm">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Item Details</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h3 class="text-primary">{{ $item->name }}</h3>
                    </div>

                    <div class="mb-3">
                        <strong>Status:</strong>
                        <div class="d-flex align-items-center">
                            <span class="status-icon
                                @if($item->status == 'available') status-available
                                @elseif($item->status == 'not available') status-not-available
                                @else status-pending @endif">
                            </span>
                            <p class="d-inline-block ms-2 text-muted">{{ ucfirst($item->status) }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="text-muted">{{ $item->description }}</p>
                    </div>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary mt-3">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .status-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }
    .status-available {
        background-color: #28a745;
    }
    .status-not-available {
        background-color: #dc3545;
    }
    .status-pending {
        background-color: #ffc107;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    .card-header {
        background-color: #007bff;
        color: #fff;
        border-bottom: none;
    }
    .card-body {
        padding: 2rem;
    }
    .shadow-lg {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
</style>
@endsection
