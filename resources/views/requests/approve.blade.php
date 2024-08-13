@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1 class="mb-4">Approve Requests</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Item</th>
                    <th>Requested By</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Current Step</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->item->name }}</td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->size }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>Step {{ $request->step }}</td>
                        <td>
                            @if ($request->status === 'pending')
                                @if ($request->step < 7)
                                    <form action="{{ route('requests.approve', $request->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">Approve Step {{ $request->step }}</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary" disabled>Request Completed</button>
                                @endif
                                <form action="{{ route('requests.reject', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
