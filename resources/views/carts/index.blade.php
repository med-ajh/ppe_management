<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Complete Your Request</h2>

    @if ($cart)
        <form action="{{ route('cart.complete') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="value_stream">Select Value Stream</label>
                <select name="value_stream_id" id="value_stream" class="form-control">
                    @foreach ($valueStreams as $valueStream)
                        <option value="{{ $valueStream->id }}">{{ $valueStream->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="department">Select Department</label>
                <select name="department_id" id="department" class="form-control">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Complete Request</button>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
