@extends('layouts.user_type.auth')

@section('content')

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #e1e4e8;
        padding: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .btn-secondary {
        background-color: #ffffff;
        color: #6c757d; /* Grey color */
        border-radius: 10px;
        padding: 10px 20px;
        border: 1px solid #e1e4e8;
        transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Value Stream Details</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Name:</strong>
                <p>{{ $valueStream->name }}</p>
            </div>
            <a href="{{ route('valueStreams.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

@endsection
