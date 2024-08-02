@extends('layouts.user_type.guest')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
            <p class="text-lead text-white">create a new account</p>
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
              <form role="form text-left" method="POST" action="/register">
                @csrf




                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="TE Connectivity Id" name="te" id="te" aria-label="te" aria-describedby="te" value="{{ old('te') }}">
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
                  <input type="text" class="form-control" placeholder="Telephone" name="telephone" id="telephone" aria-label="Telephone" aria-describedby="telephone" value="{{ old('telephone') }}">
                  @error('telephone')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" id="email" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">
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
                  <input type="number" class="form-control" placeholder="Department ID" name="departement_id" id="departement_id" aria-label="Department ID" aria-describedby="departement_id" value="{{ old('departement_id') }}">
                  @error('departement_id')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control" placeholder="Cost Center ID" name="cost_center_id" id="cost_center_id" aria-label="Cost Center ID" aria-describedby="cost_center_id" value="{{ old('cost_center_id') }}">
                  @error('cost_center_id')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="number" class="form-control" placeholder="Manager ID" name="manager_id" id="manager_id" aria-label="Manager ID" aria-describedby="manager_id" value="{{ old('manager_id') }}">
                  @error('manager_id')
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
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign in</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
