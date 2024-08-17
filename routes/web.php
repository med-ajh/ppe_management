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
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ValueStreamController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\CartController;

// Routes for Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('employees', [AdminDashboardController::class, 'employees'])->name('admin.employees');
    Route::get('managers', [AdminDashboardController::class, 'managers'])->name('admin.managers');

    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [AdminDashboardController::class, 'createUser'])->name('admin.users.create'); // Route to show the form for creating a new user
    Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store'); // Route to store a newly created user
    Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/users/{user}', [AdminDashboardController::class, 'show'])->name('admin.users.show');

    Route::resource('items', ItemController::class);

    Route::get('/admin/requests', [RequestController::class, 'adminIndex'])->name('requests.admin.index');
    Route::get('/admin/requests/{cartId}', [RequestController::class, 'show'])->name('requests.admin.show');
    Route::get('/admin/requests/history', [RequestController::class, 'requestHistory'])->name('requests.admin.history');
});



// Routes for Manager

Route::middleware(['auth', 'role:manager'])->group(function () {
    // Manager dashboard
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

    // Employee management
    Route::prefix('manager/employees')->name('manager.employees.')->group(function () {
        Route::get('/', [ManagerDashboardController::class, 'employees'])->name('index');
        Route::get('/create', [ManagerDashboardController::class, 'create'])->name('create');
        Route::post('/', [ManagerDashboardController::class, 'store'])->name('store');
        Route::get('/{id}', [ManagerDashboardController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ManagerDashboardController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ManagerDashboardController::class, 'update'])->name('update');
        Route::delete('/{id}', [ManagerDashboardController::class, 'destroy'])->name('destroy');
    });





});

// Routes for Employee
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
    // Add other employee routes here
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');



    Route::resource('valuestreams', ValueStreamController::class);
    Route::resource('departments', DepartmentController::class);

// User routes
Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
Route::post('/cart/store', [RequestController::class, 'store'])->name('requests.store');
Route::get('/cart', [RequestController::class, 'showCart'])->name('requests.cart');
Route::post('/cart/confirm', [RequestController::class, 'confirmRequests'])->name('requests.confirmRequests');
Route::get('/requests/follow', [RequestController::class, 'followRequest'])->name('requests.followRequest');
Route::get('/requests/progress/{cartId}', [RequestController::class, 'showRequestProgress'])->name('requests.showRequestProgress');
Route::delete('/cart/item/{cartItem}', [RequestController::class, 'removeItem'])->name('requests.removeItem');
Route::get('/cart/item/edit/{cartItem}', [RequestController::class, 'editItem'])->name('requests.editItem');
Route::post('/cart/item/update/{cartItem}', [RequestController::class, 'updateItem'])->name('requests.updateItem');
Route::get('/history', [RequestController::class, 'History'])->name('requests.History');



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
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // or wherever you want to redirect after logout
})->name('logout');
