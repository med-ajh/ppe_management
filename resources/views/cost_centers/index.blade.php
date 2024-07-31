@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cost Centers</h1>
    <a href="{{ route('cost_centers.create') }}" class="btn btn-primary mb-3">Add Cost Center</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($costCenters as $costCenter)
            <tr>
                <td>{{ $costCenter->name }}</td>
                <td>
                    <a href="{{ route('cost_centers.edit', $costCenter->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('cost_centers.destroy', $costCenter->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
