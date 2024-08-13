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
/*
//request routes
    Route::prefix('requests')->group(function () {
        Route::get('create', [RequestController::class, 'listItems'])->name('requests.listItems');
        Route::post('add-to-cart/{item}', [RequestController::class, 'addToCart'])->name('requests.addToCart');
        Route::get('follow', [RequestController::class, 'follow'])->name('requests.follow');
        Route::get('approve', [RequestController::class, 'approve'])->name('requests.approve');
        Route::get('history', [RequestController::class, 'history'])->name('requests.history');
    });
*/




Route::get('/requests/create', [CartController::class, 'create'])->name('requests.create');

// Route to show details of a selected item
Route::get('/requests/items/{id}', [CartController::class, 'showItemDetails'])->name('requests.items.show');

// Route to handle adding an item to the cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');





//cart request
    Route::prefix('cart')->group(function () {
        Route::get('view', [CartController::class, 'view'])->name('cart.view');
        Route::post('confirm', [CartController::class, 'confirmRequest'])->name('cart.confirmRequest');
    });
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
