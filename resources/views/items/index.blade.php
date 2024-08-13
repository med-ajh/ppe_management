@extends('layouts.user_type.auth')

@section('content')

<style>
    .small-avatar {
        max-width: 100px;
        height: auto;
        border-radius: 5px;
    }
    .icon-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .icon-button {
        border: none;
        background: none;
        cursor: pointer;
        color: #6c757d;
    }
    .icon-button i {
        font-size: 18px;
    }
    .icon-button:hover {
        color: #ff8000;
    }
    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .search-form .form-control {
        flex: 1;
        margin-right: 10px;
    }
    .search-form .btn {
        flex-shrink: 0;
        margin: 0;
    }
    .add-item-btn {
        margin-bottom: 15px;
        display: flex;
        justify-content: flex-end;
    }
    .status-icon {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }
    .status-available {
        background-color: green;
    }
    .status-not-available {
        background-color: red;
    }
    .status-pending {
        background-color: orange;
    }
    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
        font-size: 14px;
    }
    .table-responsive {
        margin-top: 20px;
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <form action="{{ route('items.index') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search items..." value="{{ request('search') }}" class="form-control">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="add-item-btn">
                <a href="{{ route('items.create') }}" class="btn btn-success">Add Item</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image" class="small-avatar">
                        @else
                            <p class="text-xs font-weight-bold mb-0">No Image</p>
                        @endif
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                    </td>

                    <td>
                        <span class="status-icon
                            @if($item->status == 'available') status-available
                            @elseif($item->status == 'not available') status-not-available
                            @else status-pending @endif">
                        </span>
                        <p class="text-xs font-weight-bold mb-0 d-inline-block">{{ ucfirst($item->status) }}</p>
                    </td>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $item->description }}</p>
                    </td>
                    <td class="align-middle">
                        <div class="icon-actions">
                            <a href="{{ route('items.show', $item->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="View item">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('items.edit', $item->id) }}" class="icon-button" data-toggle="tooltip" data-original-title="Edit item">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon-button" data-toggle="tooltip" data-original-title="Delete item">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $items->links() }}
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this item?');
    }
</script>

@endsection
