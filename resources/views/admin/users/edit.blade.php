@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit User</h1>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-body">

                <!-- TE -->
                <div class="mb-3">
                    <label for="te" class="form-label">TE</label>
                    <input type="text" id="te" name="te" class="form-control @error('te') is-invalid @enderror" value="{{ old('te', $user->te) }}" required>
                    @error('te')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input type="text" id="lastname" name="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname', $user->lastname) }}" required>
                    @error('lastname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>

                <!-- Role -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cost_center_id" class="form-label">Cost Center</label>
                    <select id="cost_center_id" name="cost_center_id" class="form-control @error('cost_center_id') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach($costCenters as $costCenter)
                            <option value="{{ $costCenter->id }}" {{ $user->cost_center_id == $costCenter->id ? 'selected' : '' }}>
                                {{ $costCenter->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_center_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var departmentSelect = document.getElementById('department_id');
        var costCenterSelect = document.getElementById('cost_center_id');

        function updateCostCenters() {
            var departmentId = departmentSelect.value;
            fetch(`/api/cost-centers/${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    costCenterSelect.innerHTML = '<option value="">None</option>';
                    data.forEach(costCenter => {
                        costCenterSelect.innerHTML += `<option value="${costCenter.id}">${costCenter.name}</option>`;
                    });
                });
        }

        departmentSelect.addEventListener('change', updateCostCenters);

        // Initialize cost centers based on the current department
        updateCostCenters();
    });
</script>
@endsection
