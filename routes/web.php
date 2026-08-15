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

// Dashboard global (gère l'affichage Admin vs User dans le contrôleur DashboardController)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Routes accessibles UNIQUEMENT aux Administrateurs
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('employees', EmployeeWebController::class);
    Route::get('/leave-requests/pending', [LeaveRequestWebController::class, 'pending'])->name('leave-requests.pending');
    Route::patch('/leave-requests/{leaveRequest}/approve', [LeaveRequestWebController::class, 'approve'])->name('leave-requests.approve');
    Route::patch('/leave-requests/{leaveRequest}/reject', [LeaveRequestWebController::class, 'reject'])->name('leave-requests.reject');
});

// Routes partagées pour la gestion des congés (création, édition, suppression, index)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('leave-requests', LeaveRequestWebController::class)->except(['pending', 'approve', 'reject']);
});

// Gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
