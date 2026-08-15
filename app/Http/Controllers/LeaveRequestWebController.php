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

    // Affiche uniquement les demandes en attente pour les RH
    public function pending()
    {
        return Inertia::render('LeaveRequests/Pending', [
            'pendingRequests' => LeaveRequest::with(['employee', 'leaveType'])
                ->where('status', 'en_attente')
                ->latest()
                ->get(),
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

    // Approuver une demande de congé et déduire le solde
    public function approve(LeaveRequest $leaveRequest): RedirectResponse
    {
        // Empêcher de re-valider une demande déjà approuvée
        if ($leaveRequest->status === 'approuvé') {
            return back()->with('error', 'Cette demande a déjà été approuvée.');
        }

        $employee = $leaveRequest->employee;
        $leaveType = $leaveRequest->leaveType;

        // Si c'est un congé payé, on déduit le solde
        if ($leaveType && str_contains(strtolower($leaveType->name), 'payé')) {
            if ($employee->leave_balance < $leaveRequest->days_count) {
                return back()->with('error', "Impossible d'approuver : solde de congés insuffisant.");
            }

            // Déduction du solde
            $employee->decrement('leave_balance', $leaveRequest->days_count);
        }

        // Mettre à jour le statut de la demande
        $leaveRequest->update(['status' => 'approuvé']);

        return back()->with('success', 'Demande approuvée et solde mis à jour avec succès.');
    }

    // Rejeter une demande de congé
    public function reject(LeaveRequest $leaveRequest): RedirectResponse
    {
        $leaveRequest->update(['status' => 'rejeté']);

        return back()->with('success', 'Demande de congé rejetée.');
    }
}
