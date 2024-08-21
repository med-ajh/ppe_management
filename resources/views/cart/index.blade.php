@extends('layouts.user_type.auth')

@section('content')
<div class="container mt-5">
    <h1 class="text-center font-weight-bold mb-4">Your Cart</h1>

    @if(isset($cart) && !$cart->items->isEmpty())
        <!-- Display Cart Items -->
        <div class="card card-elevated mb-5">
            <div class="card-header">
                <h5 class="font-weight-bold text-muted">Items in Your Cart</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Item</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                        <tr class="item-row">
                            <td>
                                <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" class="item-image">
                            </td>
                            <td>{{ $item->item->name }}</td>
                            <td>
                                <form action="{{ route('cart.updateItem', $item->id) }}" method="POST" onsubmit="return confirmUpdate()">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="size" value="{{ $item->size }}" class="form-control input-custom" required>
                            </td>
                            <td>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control input-custom" min="1" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                                <form action="{{ route('cart.removeItem', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirmRemove()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Request Form -->
        <div class="card card-elevated">
            <div class="card-header">
                <h5 class="font-weight-bold text-muted">Request Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cart.processRequest') }}" method="POST" onsubmit="return confirmRequest()">
                    @csrf

                    <!-- Value Stream Selection -->
                    <div class="mb-3">
                        <label for="value_stream_id" class="form-label">Value Stream</label>
                        <select id="value_stream_id" class="form-control input-custom" name="value_stream_id" required>
                            <option value="">Select Value Stream</option>
                            @foreach($valueStreams as $valueStream)
                                <option value="{{ $valueStream->id }}" {{ old('value_stream_id') == $valueStream->id ? 'selected' : '' }}>
                                    {{ $valueStream->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('value_stream_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department Selection -->
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select id="department_id" class="form-control input-custom" name="department_id" required>
                            <option value="">Select Department</option>
                        </select>
                        @error('department_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Cost Center Input -->
                    <div id="cost-center-container" class="mb-3" style="display: none;">
                        <label for="cost_center_id" class="form-label">Cost Center</label>
                        <input type="text" class="form-control input-custom" name="cost_center" id="cost_center_id" placeholder="Cost Center" readonly>
                        @error('cost_center')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Confirm Request</button>
                        <button type="button" class="btn btn-secondary" onclick="confirmCancel()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p class="mt-4 text-center text-muted">Your cart is empty.</p>
    @endif
</div>

<!-- Hidden cancel form -->
<form id="cancel-form" action="{{ route('cart.cancelRequest') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departments = @json($departments);
    const valueStreams = @json($valueStreams);

    const departmentSelect = document.getElementById('department_id');
    const valueStreamSelect = document.getElementById('value_stream_id');
    const costCenterInput = document.getElementById('cost_center_id');
    const costCenterContainer = document.getElementById('cost-center-container');

    function populateDepartments(valueStreamId) {
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        if (!valueStreamId) return;

        const filteredDepartments = departments.filter(department => department.value_stream_id === valueStreamId);

        filteredDepartments.forEach(department => {
            const option = document.createElement('option');
            option.value = department.id;
            option.textContent = department.name;
            departmentSelect.appendChild(option);
        });

        departmentSelect.dispatchEvent(new Event('change'));
    }

    function setCostCenter(departmentId) {
        const selectedDepartment = departments.find(department => department.id === departmentId);
        costCenterInput.value = selectedDepartment ? selectedDepartment.cost_center : '';
    }

    valueStreamSelect.addEventListener('change', function() {
        const valueStreamId = parseInt(valueStreamSelect.value);
        populateDepartments(valueStreamId);
    });

    departmentSelect.addEventListener('change', function() {
        const departmentId = parseInt(departmentSelect.value);
        setCostCenter(departmentId);
        costCenterContainer.style.display = departmentId ? 'block' : 'none';
    });

    populateDepartments(valueStreamSelect.value);
    setCostCenter(departmentSelect.value);
});

function confirmUpdate() {
    return confirm('Are you sure you want to update this item?');
}

function confirmRemove() {
    return confirm('Are you sure you want to remove this item from the cart?');
}

function confirmRequest() {
    return confirm('Are you sure you want to confirm this request?');
}

function confirmCancel() {
    if (confirm('Are you sure you want to cancel the request and clear the cart?')) {
        document.getElementById('cancel-form').submit();
    }
}
</script>

<style>
    body {
        font-family: 'San Francisco', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 1rem;
    }

    .card {
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .card-elevated:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }

    .card-header {
        background: #ffffff;
        padding: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-body {
        padding: 1rem;
        background: #ffffff;
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .item-image:hover {
        transform: scale(1.05);
        filter: brightness(0.9);
    }

    .btn-primary {
        background-color: #007aff;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0051a2;
        transform: scale(1.02);
    }

    .btn-danger {
        background-color: #ff3b30;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #d92d21;
        transform: scale(1.02);
    }

    .btn-success {
        background-color: #34c759;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-success:hover {
        background-color: #28a745;
        transform: scale(1.02);
    }

    .btn-secondary {
        background-color: #6e6e6e;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #5a5a5a;
        transform: scale(1.02);
    }

    .input-custom {
        border-radius: 8px;
        border: 1px solid #d0d0d0;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .input-custom:focus {
        border-color: #007aff;
        box-shadow: 0 0 0 0.2rem rgba(0, 122, 255, 0.25);
    }

    .item-row {
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .item-row:hover {
        background-color: #f5f5f5;
        transform: translateY(-1px);
    }

    .loader {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top: 4px solid #007aff;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection
