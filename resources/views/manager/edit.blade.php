@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>

    <form action="{{ route('manager.employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $employee->lastname) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="te">TE</label>
            <input type="text" name="te" class="form-control" value="{{ old('te', $employee->te) }}">
        </div>

        <input type="hidden" name="department_id" value="{{ $employee->department_id }}">
        <input type="hidden" name="cost_center_id" value="{{ $employee->cost_center_id }}">
        <input type="hidden" name="manager_id" value="{{ $employee->manager_id }}">

        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>
@endsection
