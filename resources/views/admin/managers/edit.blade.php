@extends('layouts.user_type.auth')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit User</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Last Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
                        @error('lastname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- TE ID -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="te">TE ID</label>
                        <input type="text" id="te" name="te" class="form-control" value="{{ old('te', $user->te) }}" required>
                        @error('te')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Department -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="departement_id">Department</label>
                        <select id="departement_id" name="departement_id" class="form-control" required>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" {{ old('departement_id', $user->departement_id) == $departement->id ? 'selected' : '' }}>
                                    {{ $departement->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('departement_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Cost Center -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_center_id">Cost Center</label>
                        <select id="cost_center_id" name="cost_center_id" class="form-control">
                            <option value="">None</option>
                            @foreach($costCenters as $costCenter)
                                <option value="{{ $costCenter->id }}" {{ old('cost_center_id', $user->cost_center_id) == $costCenter->id ? 'selected' : '' }}>
                                    {{ $costCenter->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('cost_center_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Manager -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="manager_id">Manager</label>
                        <select id="manager_id" name="manager_id" class="form-control">
                            <option value="">None</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id', $user->manager_id) == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }} {{ $manager->lastname }}
                                </option>
                            @endforeach
                        </select>
                        @error('manager_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
