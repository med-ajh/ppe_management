@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Cost Center</h1>
    <form action="{{ route('cost_centers.update', $costCenter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Cost Center Name</label>
            <input type="text" name="name" class="form-control" value="{{ $costCenter->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
