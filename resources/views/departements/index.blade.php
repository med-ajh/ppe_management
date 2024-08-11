@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Departments</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Create New Department</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>
                                <a href="{{ route('departments.show', $department) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline;">
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
