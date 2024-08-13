@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1 class="mb-4">Browse Items</h1>
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <a href="{{ route('requests.showItem', $item->id) }}" class="btn btn-primary">Select</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
