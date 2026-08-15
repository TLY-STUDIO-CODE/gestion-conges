<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Http\Requests\StoreLeaveRequestRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveRequestWebController extends Controller
{
    public function index()
    {
        return Inertia::render('LeaveRequests/Index', [
            'leaveRequests' => LeaveRequest::with(['employee', 'leaveType'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('LeaveRequests/Create', [
            'employees' => Employee::all(),
            'leaveTypes' => LeaveType::all(),
        ]);
    }

    public function store(StoreLeaveRequestRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Calcul automatique des jours ouvrés (hors weekends)
        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $period = CarbonPeriod::create($start, $end);

        $businessDays = 0;
        foreach ($period as $date) {
            // 0 = Dimanche, 6 = Samedi (on ne compte que du lundi au vendredi)
            if ($date->isWeekday()) {
                $businessDays++;
            }
        }

        // Enregistrement de la demande avec le statut initial "en_attente"
        LeaveRequest::create([
            'employee_id' => $data['employee_id'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days_count' => $businessDays,
            'status' => 'en_attente', // Statut initial standard
            'reason' => $data['reason'] ?? null,
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'Demande de congé soumise avec succès !');
    }
}
