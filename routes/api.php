<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveRequestController;

Route::apiResource('employees', EmployeeController::class);
Route::apiResource('leave-requests', LeaveRequestController::class);
Route::patch('leave-requests/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus']);
