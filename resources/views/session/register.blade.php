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
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="TE Connectivity Id" name="te" id="te" aria-label="te" aria-describedby="te" value="{{ old('te') }}">
                                </div>
                                @error('te')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="employee">Employee</option>
                                    <option value="manager">Manager</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('role')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="manager-container" class="mb-3" style="display: none;">
                                <select id="manager_id" class="form-control @error('manager_id') is-invalid @enderror" name="manager_id">
                                    <option value="">Select Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}">
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('manager_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Lastname" name="lastname" id="lastname" aria-label="Lastname" aria-describedby="lastname" value="{{ old('lastname') }}">
                                @error('lastname')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Email" name="email" id="email" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">
                                    <span class="input-group-text">@te.com</span>
                                </div>
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password" aria-label="Password" aria-describedby="password-addon">
                                @error('password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" aria-label="Confirm Password" aria-describedby="password-confirmation-addon">
                                @error('password_confirmation')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select id="departement_id" class="form-control @error('departement_id') is-invalid @enderror" name="departement_id">
                                    <option value="">Select Department</option>
                                    @foreach($departements as $departement)
                                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                    @endforeach
                                </select>
                                @error('departement_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="cost-center-container" class="mb-3" style="display: none;">
                                <select id="cost_center_id" class="form-control @error('cost_center_id') is-invalid @enderror" name="cost_center_id">
                                    <option value="">Select Cost Center</option>
                                    <!-- Cost centers will be populated dynamically -->
                                </select>
                                @error('cost_center_id')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I agree to the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                </label>
                                @error('agreement')
                                    <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try to register again.</p>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign up</button>
                            </div>

                            <p class="text-sm mt-3 mb-0">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departments = @json($departements);
    const costCenters = @json($costCenters);
    const managers = @json($managers);

    const departmentSelect = document.getElementById('departement_id');
    const costCenterSelect = document.getElementById('cost_center_id');
    const roleSelect = document.getElementById('role');
    const managerSelect = document.getElementById('manager_id');
    const costCenterContainer = document.getElementById('cost-center-container');
    const managerContainer = document.getElementById('manager-container');
    const emailInput = document.getElementById('email');
    const registrationForm = document.querySelector('form');

    // Populate cost center based on department
    function populateCostCenters(departmentId) {
        costCenterSelect.innerHTML = '<option value="">Select Cost Center</option>';
        if (!departmentId) return;

        const filteredCostCenters = costCenters.filter(costCenter => costCenter.departement_id === departmentId);

        filteredCostCenters.forEach(costCenter => {
            const option = document.createElement('option');
            option.value = costCenter.id;
            option.textContent = costCenter.name;
            costCenterSelect.appendChild(option);
        });
    }

    // Role select change event
    roleSelect.addEventListener('change', function() {
        const role = roleSelect.value;

        if (role === 'employee') {
            costCenterContainer.style.display = 'block';
            managerContainer.style.display = 'block';
        } else if (role === 'manager') {
            costCenterContainer.style.display = 'block';
            managerContainer.style.display = 'none';
            departmentSelect.value = ''; // Reset department
            costCenterSelect.innerHTML = '<option value="">Select Cost Center</option>'; // Clear cost centers
        } else {
            costCenterContainer.style.display = 'none';
            managerContainer.style.display = 'none';
            costCenterSelect.innerHTML = '<option value="">Select Cost Center</option>'; // Clear cost centers
        }
    });

    // Department select change event
    departmentSelect.addEventListener('change', function() {
        const departmentId = parseInt(departmentSelect.value);
        populateCostCenters(departmentId);
    });

    // Manager select options
    managers.forEach(manager => {
        const option = document.createElement('option');
        option.value = manager.id;
        option.textContent = manager.name;
        managerSelect.appendChild(option);
    });

    // Email domain correction on form submission
    registrationForm.addEventListener('submit', function(event) {
        const email = emailInput.value.trim();
        if (email) {
            emailInput.value = `${email}@te.com`;
        }
    });
});
</script>
@endsection
