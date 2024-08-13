@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1 class="mb-4">My Requests</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Item</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->item->name }}</td>
                        <td>{{ $request->size }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>{{ $request->requested_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
