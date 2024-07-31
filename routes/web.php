<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; // Ensure this is imported
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CostCenterController;
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/departments', DepartmentController::class);
    Route::resource('/cost_centers', CostCenterController::class);
    Route::resource('/users', UserController::class); // Ensure this line is present
});





Route::prefix('manager')->middleware('auth')->group(function () {
    Route::get('dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('employees/create', [ManagerController::class, 'create'])->name('manager.create');
    Route::post('employees', [ManagerController::class, 'store'])->name('manager.employees.store');
    Route::get('employees/{employee}/edit', [ManagerController::class, 'edit'])->name('manager.employees.edit');
    Route::put('employees/{employee}', [ManagerController::class, 'update'])->name('manager.employees.update');
    Route::delete('/manager/employees/{employee}', [ManagerController::class, 'destroy'])->name('manager.employees.destroy');
    Route::get('activities', [ManagerController::class, 'activities'])->name('manager.activities');
    Route::get('/manager/employees/{employee}', [ManagerController::class, 'show'])->name('manager.employees.show');
});





// Employee Routes
Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
});

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/api/cost-centers/{department}', [UserController::class, 'getCostCenters']);
