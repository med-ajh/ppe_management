@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recent Activities of Your Employees</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>User</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->description }}</td>
                <td>{{ $activity->user->name }}</td>
                <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $activities->links() }}
</div>
@endsection
