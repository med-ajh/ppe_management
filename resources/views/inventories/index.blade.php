@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Departements</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('departements.create') }}" class="btn btn-primary mb-3">Create New Departement</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departements as $departement)
                        <tr>
                            <td>{{ $departement->name }}</td>
                            <td>
                                <a href="{{ route('departements.show', $departement) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('departements.edit', $departement) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('departements.destroy', $departement) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
