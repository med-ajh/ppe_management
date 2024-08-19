@extends('layouts.user_type.auth')
<!-- Add the necessary CSS files manually -->
<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css.map') }}" rel="stylesheet" />

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
            <h4>Edit Value Stream</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('valueStreams.update', $valueStream->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $valueStream->name }}" required>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('valueStreams.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
