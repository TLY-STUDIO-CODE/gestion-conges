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
        if (!$user->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        $pendingRequests = LeaveRequest::with(['employee', 'leaveType'])
            ->where('status', 'en_attente')
            ->latest()
            ->get();

        return Inertia::render('LeaveRequests/Pending', [
            'pendingRequests' => $pendingRequests,
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

        $businessDays = $this->calculateBusinessDays($data['start_date'], $data['end_date']);

        LeaveRequest::create([
            'employee_id' => $data['employee_id'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days_count' => $businessDays,
            'status' => 'en_attente',
            'reason' => $data['reason'] ?? null,
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Demande de congé soumise avec succès !');
    }

    public function edit(Request $request, LeaveRequest $leaveRequest)
    {
        $user = $request->user();

        // Vérification des droits de modification
        if (!$user->isAdmin()) {
            $employee = $user->employee;
            if (!$employee || $leaveRequest->employee_id !== $employee->id || $leaveRequest->status !== 'en_attente') {
                abort(403, 'Action non autorisée ou demande déjà traitée.');
            }
            $employees = [$employee];
        } else {
            $employees = Employee::all();
        }

        return Inertia::render('LeaveRequests/Edit', [
            'leaveRequest' => $leaveRequest,
            'employees' => $employees,
            'leaveTypes' => LeaveType::all(),
        ]);
    }

    public function update(StoreLeaveRequestRequest $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            $employee = $user->employee;
            if (!$employee || $leaveRequest->employee_id !== $employee->id || $leaveRequest->status !== 'en_attente') {
                abort(403, 'Action non autorisée.');
            }
        }

        $data = $request->validated();
        $businessDays = $this->calculateBusinessDays($data['start_date'], $data['end_date']);

        $leaveRequest->update([
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days_count' => $businessDays,
            'reason' => $data['reason'] ?? $leaveRequest->reason,
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Demande de congé mise à jour avec succès !');
    }

    public function destroy(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            $employee = $user->employee;
            if (!$employee || $leaveRequest->employee_id !== $employee->id || $leaveRequest->status !== 'en_attente') {
                abort(403, 'Action non autorisée ou demande déjà traitée.');
            }
        }

        $leaveRequest->delete();

        return back()->with('success', 'Demande de congé supprimée avec succès.');
    }

    public function approve(LeaveRequest $leaveRequest): RedirectResponse
    {
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

        $leaveRequest->update(['status' => 'approved']);

        return back()->with('success', 'Demande approuvée et solde mis à jour avec succès.');
    }

    public function reject(LeaveRequest $leaveRequest): RedirectResponse
    {
        $leaveRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Demande de congé rejetée.');
    }

    private function calculateBusinessDays($startDate, $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $period = CarbonPeriod::create($start, $end);

        $businessDays = 0;
        foreach ($period as $date) {
            if ($date->isWeekday()) {
                $businessDays++;
            }
        }
        return $businessDays;
    }
}
