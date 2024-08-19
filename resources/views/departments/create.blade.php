@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Create Departement</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('departements.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group text-end">
                    <a href="{{ route('departements.index') }}" class="btn btn-secondary">Back to List</a>
                    <button type="submit" class="btn btn-primary">Create Departement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
