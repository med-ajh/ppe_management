@extends('layouts.user_type.guest')

@section('content')
<section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    <p class="text-lead text-white">Create a new account</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header text-center pt-4">
                        <h5>Register with</h5>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="TE Connectivity Id (6 digits)" name="te" id="te" aria-label="te" value="{{ old('te') }}" required>
                                @error('te')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="manager-container" class="mb-3" style="display: none;">
                                <select id="manager_id" class="form-control @error('manager_id') is-invalid @enderror" name="manager_id">
                                    <option value="">Select Manager</option>
                                    <!-- Manager options will be populated dynamically -->
                                </select>
                                @error('manager_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Lastname" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Email (username)" name="email" id="email" value="{{ old('email') }}" required>
                                    <span class="input-group-text">@te.com</span>
                                </div>
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                                @error('password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" required>
                                @error('password_confirmation')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
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

                            <div class="mb-3">
                                <select id="department_id" class="form-control @error('department_id') is-invalid @enderror" name="department_id" required>
                                    <option value="">Select Department</option>
                                    <!-- Departments will be populated dynamically based on the value stream selection -->
                                </select>
                                @error('department_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="cost-center-container" class="mb-3" style="display: none;">
                                <input type="text" class="form-control @error('cost_center') is-invalid @enderror" name="cost_center" id="cost_center" placeholder="Cost Center" readonly>
                                @error('cost_center')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    <i class="fa-solid fa-check-circle"></i> I agree to the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                </label>
                                @error('agreement')
                                    <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try to register again.</p>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign up</button>
                            </div>

                            <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Sign in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
    const managerContainer = document.getElementById('manager-container');
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

    // Populate managers select options
    function populateManagers() {
        managerSelect.innerHTML = '<option value="">Select Manager</option>';
        managers.forEach(manager => {
            const option = document.createElement('option');
            option.value = manager.id;
            option.textContent = manager.name;
            managerSelect.appendChild(option);
        });
    }

    // Role select change event
    roleSelect.addEventListener('change', function() {
        const role = roleSelect.value;

        if (role === 'employee' || role === 'admin') {
            costCenterContainer.style.display = 'block';
            managerContainer.style.display = role === 'employee' ? 'block' : 'none';
        } else if (role === 'manager') {
            costCenterContainer.style.display = 'block';
            managerContainer.style.display = 'none';
            departmentSelect.value = ''; // Reset department
            departmentSelect.innerHTML = '<option value="">Select Department</option>'; // Clear departments
            costCenterInput.value = ''; // Clear cost center
        } else {
            costCenterContainer.style.display = 'none';
            managerContainer.style.display = 'none';
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
        const emailValue = emailInput.value.split('@')[0]; // Only the part before @
        emailInput.value = emailValue;
    });

    // Initialize managers
    populateManagers();
});
</script>
@endsection
