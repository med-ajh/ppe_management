<!-- resources/views/manager/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees under {{ Auth::user()->name }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->department }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
