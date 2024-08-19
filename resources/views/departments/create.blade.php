@extends('layouts.user_type.auth')

@section('content')

<style>
    .form-control {
        border-radius: 10px;
        padding: 10px;
    }
    .btn-primary {
        background-color: #6c757d; /* Grey color */
        border-color: #6c757d; /* Grey color */
        border-radius: 10px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #ff8000; /* Orange color on hover */
        border-color: #ff8000; /* Orange color on hover */
    }
    .btn-secondary {
        background-color: #ffffff;
        color: #ff8000; /* Grey color */
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
            <h4>Create New Department</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="cost_center">Cost Center</label>
                    <input type="number" name="cost_center" id="cost_center" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="value_stream_id">Value Stream</label>
                    <select name="value_stream_id" id="value_stream_id" class="form-control" required>
                        @foreach ($valueStreams as $valueStream)
                            <option value="{{ $valueStream->id }}">{{ $valueStream->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
