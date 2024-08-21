@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <h1 class="mb-4">Your Cart</h1>

    @if(isset($cart) && !$cart->items->isEmpty())
        <!-- Display Cart Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Items in Your Cart</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
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
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" width="100" height="100">
                            </td>
                            <td>{{ $item->item->name }}</td>
                            <td>
                                <form action="{{ route('cart.updateItem', $item->id) }}" method="POST" onsubmit="return confirmUpdate()">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="text" name="size" value="{{ $item->size }}" class="form-control" required>
                                    </div>
                            </td>
                            <td>
                                    <div class="form-group">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control" min="1" required>
                                    </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>
                                <form action="{{ route('cart.removeItem', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirmRemove()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Request Form -->
        <div class="card">
            <div class="card-header">
                <h5>Request Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cart.processRequest') }}" method="POST" onsubmit="return confirmRequest()">
                    @csrf

                    <!-- Value Stream Selection -->
                    <div class="mb-3">
                        <label for="value_stream_id">Value Stream</label>
                        <select id="value_stream_id" class="form-control @error('value_stream_id') is-invalid @enderror" name="value_stream_id" required>
                            <option value="">Select Value Stream</option>
                            @foreach($valueStreams as $valueStream)
                                <option value="{{ $valueStream->id }}" {{ old('value_stream_id') == $valueStream->id ? 'selected' : '' }}>
                                    {{ $valueStream->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('value_stream_id')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department Selection -->
                    <div class="mb-3">
                        <label for="department_id">Department</label>
                        <select id="department_id" class="form-control @error('department_id') is-invalid @enderror" name="department_id" required>
                            <option value="">Select Department</option>
                            <!-- Departments will be populated dynamically based on the value stream selection -->
                        </select>
                        @error('department_id')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cost Center Input -->
                    <div id="cost-center-container" class="mb-3" style="display: none;">
                        <label for="cost_center_id">Cost Center</label>
                        <input type="text" class="form-control @error('cost_center') is-invalid @enderror" name="cost_center" id="cost_center_id" placeholder="Cost Center" readonly>
                        @error('cost_center')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Confirm Request</button>
                        <button type="button" class="btn btn-secondary" onclick="confirmCancel()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p>Your cart is empty.</p>
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

    // Populate departments based on the selected value stream
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

        // Trigger change event to update cost center visibility
        departmentSelect.dispatchEvent(new Event('change'));
    }

    // Set cost center value based on the selected department
    function setCostCenter(departmentId) {
        const selectedDepartment = departments.find(department => department.id === departmentId);
        if (selectedDepartment) {
            costCenterInput.value = selectedDepartment.cost_center;
        } else {
            costCenterInput.value = '';
        }
    }

    // Value stream select change event
    valueStreamSelect.addEventListener('change', function() {
        const valueStreamId = parseInt(valueStreamSelect.value);
        populateDepartments(valueStreamId);
    });

    // Department select change event
    departmentSelect.addEventListener('change', function() {
        const departmentId = parseInt(departmentSelect.value);
        setCostCenter(departmentId);
        costCenterContainer.style.display = departmentId ? 'block' : 'none';
    });

    // Initialize departments and cost center
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
@endsection
