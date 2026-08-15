<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            // Vue et données globales pour l'Administrateur / RH
            return Inertia::render('Dashboard/AdminDashboard', [
                'totalEmployees' => Employee::count(),
                'pendingRequestsCount' => LeaveRequest::where('status', 'en_attente')->count(),
                'recentRequests' => LeaveRequest::with(['employee', 'leaveType'])->latest()->take(5)->get(),
            ]);
        }

        // Vue et données personnelles pour l'Employé
        $employee = Employee::where('email', $user->email)->first();

        return Inertia::render('Dashboard/EmployeeDashboard', [
            'employee' => $employee,
            'myRequests' => $employee ? $employee->leaveRequests()->with('leaveType')->latest()->get() : [],
        ]);
    }
}
