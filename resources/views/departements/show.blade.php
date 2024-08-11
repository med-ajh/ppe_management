@extends('layouts.user_type.auth')


@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Departement Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="border p-2 rounded bg-light">
                        <strong>Name:</strong>
                        <p>{{ $departement->name }}</p>
                    </div>
                </div>
            </div>
            <div class="form-group text-end mt-3">
                <a href="{{ route('departements.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('departements.edit', $departement) }}" class="btn btn-warning">Edit Departement</a>
            </div>
        </div>
    </div>
</div>
@endsection

