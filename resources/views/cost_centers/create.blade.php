@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Cost Center</h1>
    <form action="{{ route('cost_centers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Cost Center Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
