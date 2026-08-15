<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Http\Requests\StoreLeaveRequestRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveRequestWebController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])->latest()->get();
        } else {
            $employee = $user->employee;
            $leaveRequests = $employee ? $employee->leaveRequests()->with(['employee', 'leaveType'])->latest()->get() : [];
        }

        return Inertia::render('LeaveRequests/Index', [
            'leaveRequests' => $leaveRequests,
        ]);
    }

    public function pending(Request $request)
    {
        $user = $request->user();

        $query = LeaveRequest::with(['employee', 'leaveType'])->where('status', 'en_attente');

        if (!$user->isAdmin()) {
            $employee = $user->employee;
            $query->where('employee_id', $employee ? $employee->id : null);
        }

        return Inertia::render('LeaveRequests/Pending', [
            'pendingRequests' => $query->latest()->get(),
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $employees = Employee::all();
        } else {
            $employees = $user->employee ? [$user->employee] : [];
        }

        return Inertia::render('LeaveRequests/Create', [
            'employees' => $employees,
            'leaveTypes' => LeaveType::all(),
        ]);
    }

    public function store(StoreLeaveRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        if (!$user->isAdmin()) {
            $employee = $user->employee;
            if (!$employee || $data['employee_id'] != $employee->id) {
                abort(403, 'Action non autorisée.');
            }
        }

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $period = CarbonPeriod::create($start, $end);

        $businessDays = 0;
        foreach ($period as $date) {
            if ($date->isWeekday()) {
                $businessDays++;
            }
        }

        LeaveRequest::create([
            'employee_id' => $data['employee_id'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days_count' => $businessDays,
            'status' => 'en_attente', // 'en_attente' est généralement accepté, sinon mettre 'pending'
            'reason' => $data['reason'] ?? null,
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Demande de congé soumise avec succès !');
    }

    public function approve(LeaveRequest $leaveRequest): RedirectResponse
    {
        // On vérifie avec la valeur en anglais acceptée par la contrainte SQL de la base de données
        if ($leaveRequest->status === 'approved' || $leaveRequest->status === 'approuvé') {
            return back()->with('error', 'Cette demande a déjà été approuvée.');
        }

        $employee = $leaveRequest->employee;
        $leaveType = $leaveRequest->leaveType;

        if ($leaveType && str_contains(strtolower($leaveType->name), 'payé')) {
            if ($employee->leave_balance < $leaveRequest->days_count) {
                return back()->with('error', "Impossible d'approuver : solde de congés insuffisant.");
            }
            $employee->decrement('leave_balance', $leaveRequest->days_count);
        }

        // Utilisation de 'approved' pour respecter la contrainte CHECK de PostgreSQL
        $leaveRequest->update(['status' => 'approved']);

        return back()->with('success', 'Demande approuvée et solde mis à jour avec succès.');
    }

    public function reject(LeaveRequest $leaveRequest): RedirectResponse
    {
        // Utilisation de 'rejected' pour respecter la contrainte CHECK de PostgreSQL
        $leaveRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Demande de congé rejetée.');
    }
}
