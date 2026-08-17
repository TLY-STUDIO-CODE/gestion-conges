<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $adminEmployee = $user->employee;
            $adminLeaveBalance = $adminEmployee ? $adminEmployee->remaining_leave_days : 30;

            // Correction : Remplacez 'role' par le nom exact de votre colonne en base de données si nécessaire (ex: 'type', 'is_admin')
            $totalAdmins = User::where('role', 'admin')->count();

            return Inertia::render('Dashboard/AdminDashboard', [
                'totalEmployees' => Employee::count(),
                'pendingRequestsCount' => LeaveRequest::where('status', 'en_attente')->count(),
                'totalLeaveRequests' => LeaveRequest::count(),
                'approvedRequestsCount' => LeaveRequest::whereIn('status', ['approuvé', 'approved'])->count(),
                'rejectedRequestsCount' => LeaveRequest::whereIn('status', ['rejeté', 'rejected'])->count(),
                'adminLeaveBalance' => $adminLeaveBalance,
                'totalAdmins' => $totalAdmins,
                'recentRequests' => LeaveRequest::with(['employee', 'leaveType'])->latest()->take(5)->get(),
            ]);
        }

        $employee = $user->employee;

        return Inertia::render('Dashboard/EmployeeDashboard', [
            'employee' => $employee,
            'myRequests' => $employee ? $employee->leaveRequests()->with('leaveType')->latest()->get() : [],
        ]);
    }
}
