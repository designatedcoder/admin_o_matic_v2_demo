<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('admin')->name('admin.')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function() {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('/permissions', PermissionController::class)
        ->except(['create', 'show', 'edit']);

    // Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    // Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    // Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    // Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::resource('/roles', RoleController::class)
        ->except(['create', 'show', 'edit']);

    // Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    // Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    // Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    // Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::resource('/users', UserController::class)
        ->only(['index', 'update']);

    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::resource('/admins', AdminController::class)
        ->parameters(['admins' => 'user'])
        ->only(['index', 'update']);

    // Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    // Route::patch('/admins/{user}', [AdminController::class, 'update'])->name('admins.update');
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
