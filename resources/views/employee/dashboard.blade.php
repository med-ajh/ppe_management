<!-- resources/views/manager/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees under {{ Auth::user()->name }}</h1>
