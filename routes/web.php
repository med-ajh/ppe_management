<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\EmployeeDashboardController;

// Routes for Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('employees', [AdminDashboardController::class, 'employees'])->name('admin.employees');
    Route::get('managers', [AdminDashboardController::class, 'managers'])->name('admin.managers');

    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/{user}', [AdminDashboardController::class, 'show'])->name('admin.users.show');


});

// Routes for Manager
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

    Route::get('/manager/employees', [ManagerDashboardController::class, 'employees'])->name('manager.employees.index');
    Route::get('/manager/employees/{id}', [ManagerDashboardController::class, 'show'])->name('manager.employees.show');
    Route::get('/manager/employees/create', [ManagerDashboardController::class, 'create'])->name('manager.employees.create');
    Route::post('/manager/employees', [ManagerDashboardController::class, 'store'])->name('manager.employees.store');
    Route::delete('/manager/employees/{id}', [ManagerDashboardController::class, 'destroy'])->name('manager.employees.destroy');


});



// Routes for Employee
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    // Add other employee routes here
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');
});



// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/session', [SessionsController::class, 'store']);

    Route::get('/login/forgot-password', [ResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetController::class, 'sendEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});
