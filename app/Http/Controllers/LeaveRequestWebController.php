<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeaveRequestWebController extends Controller
{
    /**
     * Affiche la liste des demandes de congés.
     */
    public function index()
    {
        return Inertia::render('LeaveRequests/Index', [
            'leaveRequests' => LeaveRequest::with(['employee', 'leaveType'])->latest()->get(),
            'employees' => Employee::all(),
            'leaveTypes' => LeaveType::all(),
        ]);
    }
}
