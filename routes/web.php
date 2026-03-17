<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FuelLogController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Auth
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Shared
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:approver')->group(function () {
        Route::resource('approvals', ApprovalController::class)
            ->only(['index', 'show', 'update']);
    });

    // Admin
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        Route::resource('bookings', BookingController::class);
        Route::post('bookings/{booking}/complete', [BookingController::class, 'complete'])
            ->name('bookings.complete');

        Route::resource('vehicles', VehicleController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('fuel-logs', FuelLogController::class)->except(['show']);

        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');

        Route::get('activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
    });
});