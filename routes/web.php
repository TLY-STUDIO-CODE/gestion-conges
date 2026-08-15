<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeWebController;
use App\Http\Controllers\LeaveRequestWebController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('employees', EmployeeWebController::class);
    // Route dédiée pour l'espace de validation RH
    Route::get('/leave-requests/pending', [LeaveRequestWebController::class, 'pending'])->name('leave-requests.pending');
    Route::resource('leave-requests', LeaveRequestWebController::class);
    // Routes spécifiques pour le workflow de validation RH
    Route::patch('/leave-requests/{leaveRequest}/approve', [LeaveRequestWebController::class, 'approve'])->name('leave-requests.approve');
    Route::patch('/leave-requests/{leaveRequest}/reject', [LeaveRequestWebController::class, 'reject'])->name('leave-requests.reject');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
