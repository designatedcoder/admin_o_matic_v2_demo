<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
Route::post('/admin/permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
Route::patch('/admin/permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
Route::patch('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');




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
