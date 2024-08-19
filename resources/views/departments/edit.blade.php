@extends('layouts.user_type.auth')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Departement</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('departements.update', $departement) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $departement->name }}" required>
                </div>
                <div class="form-group text-end mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('departements.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
