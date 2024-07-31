@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Employee</h1>

    <form action="{{ route('manager.employees.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="te">TE</label>
            <input type="text" name="te" class="form-control">
        </div>

        <input type="hidden" name="role" value="employee">

        <button type="submit" class="btn btn-primary">Add Employee</button>
    </form>
</div>
@endsection
