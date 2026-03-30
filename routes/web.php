<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\LocalOfferController;
use App\Http\Controllers\Tenant\LocalController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\lessor\LessorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');
    Route::post('/tenant/locals', [LocalController::class, 'store'])->name('tenant.locals.store');
    Route::post('/tenant/locals/{local}/offers', [LocalOfferController::class, 'store'])->name('tenant.offers.store');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/{user}/ban', [DashboardController::class, 'banUser'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [DashboardController::class, 'unbanUser'])->name('admin.users.unban');
    Route::post('/admin/locals/{local}/ban', [DashboardController::class, 'banLocal'])->name('admin.locals.ban');
    Route::post('/admin/locals/{local}/unban', [DashboardController::class, 'unbanLocal'])->name('admin.locals.unban');
    Route::get('/lessor/dashboard', [LessorController::class, 'index'])->name('lessor.dashboard');
    Route::get('/lessor/apply/{availableOffer}', [LessorController::class, 'apply'])->name('lessor.apply');
    Route::get('/offer/details/{availableOffer}', [LessorController::class, 'viewDetails'])->name('offer.details');
});
