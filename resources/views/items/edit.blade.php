@extends('layouts.user_type.auth')

@section('content')

<link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/soft-ui-dashboard.css.map') }}" rel="stylesheet" />

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Item</div>

                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="image">Upload Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" required>
                        </div>



                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" required>{{ $item->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="available" {{ $item->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="not available" {{ $item->status == 'not available' ? 'selected' : '' }}>Not Available</option>
                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Item</button>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add the necessary JS files manually -->
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>

@endsection
