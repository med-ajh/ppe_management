@extends('layouts.user_type.auth')



@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="mb-0">Add New User</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">First Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" class="form-control" required>
                    @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="te" class="form-label">TE ID</label>
                    <input type="text" id="te" name="te" value="{{ old('te') }}" class="form-control" required>
                    @error('te')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="">Select Role</option>
                        <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="value_stream_id" class="form-label">Value Stream</label>
                    <select id="value_stream_id" name="value_stream_id" class="form-control" required>
                        <option value="">Select Value Stream</option>
                        @foreach ($valueStreams as $valueStream)
                            <option value="{{ $valueStream->id }}" {{ old('value_stream_id') == $valueStream->id ? 'selected' : '' }}>
                                {{ $valueStream->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('value_stream_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" class="form-control" required>
                        <option value="">Select Department</option>
                        <!-- Departments will be populated dynamically -->
                    </select>
                    @error('department_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manager_id" class="form-label">Manager</label>
                    <select id="manager_id" name="manager_id" class="form-control">
                        <option value="">Select Manager</option>
                        @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }} {{ $manager->lastname }}
                            </option>
                        @endforeach
                    </select>
                    @error('manager_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3" id="cost-center-container" style="display: none;">
                    <label for="cost_center" class="form-label">Cost Center</label>
                    <input type="text" id="cost_center" name="cost_center" class="form-control" readonly>
                    @error('cost_center')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Add User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departments = @json($departments);
    const valueStreams = @json($valueStreams);
    const managers = @json($managers);

    const departmentSelect = document.getElementById('department_id');
    const valueStreamSelect = document.getElementById('value_stream_id');
    const roleSelect = document.getElementById('role');
    const managerSelect = document.getElementById('manager_id');
    const costCenterInput = document.getElementById('cost_center');
    const costCenterContainer = document.getElementById('cost-center-container');
    const emailInput = document.getElementById('email');
    const teInput = document.getElementById('te');

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
    }

    // Role select change event
    roleSelect.addEventListener('change', function() {
        const role = roleSelect.value;

        if (role === 'employee' || role === 'admin') {
            costCenterContainer.style.display = 'block';
            if (role === 'employee') {
                managerSelect.style.display = 'block';
            } else {
                managerSelect.style.display = 'none';
            }
        } else if (role === 'manager') {
            costCenterContainer.style.display = 'block';
            departmentSelect.value = ''; // Reset department
            departmentSelect.innerHTML = '<option value="">Select Department</option>'; // Clear departments
            costCenterInput.value = ''; // Clear cost center
        } else {
            costCenterContainer.style.display = 'none';
            managerSelect.style.display = 'none';
            costCenterInput.value = ''; // Clear cost center
        }
    });

    // Value stream select change event
    valueStreamSelect.addEventListener('change', function() {
        const valueStreamId = parseInt(valueStreamSelect.value);
        populateDepartments(valueStreamId);
    });

    // Department select change event
    departmentSelect.addEventListener('change', function() {
        const departmentId = parseInt(departmentSelect.value);
        const selectedDepartment = departments.find(department => department.id === departmentId);
        if (selectedDepartment) {
            costCenterInput.value = selectedDepartment.cost_center;
        }
    });

    // Ensure TE input only allows 6 digits and adds TE prefix
    teInput.addEventListener('input', function() {
        const teValue = teInput.value.replace(/[^0-9]/g, '').slice(0, 6); // Remove non-digits and limit to 6 digits
        teInput.value = `TE${teValue}`;
    });

    // Ensure email input only allows username
    emailInput.addEventListener('input', function() {
        const emailValue = emailInput.value.split('@')[0]; // Only the part before '@'
        emailInput.value = `${emailValue}@te.com`;
    });
});
</script>
@endsection
