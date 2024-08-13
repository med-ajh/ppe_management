@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1>Make a Request</h1>
    <div class="row">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                    <a href="{{ route('requests.items.show', $item->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
