<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Liste toutes les demandes de congés.
     */
    public function index()
    {
        return response()->json(LeaveRequest::with(['employee', 'leaveType'])->get(), 200);
    }

    /**
     * Soumet une nouvelle demande de congé.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ]);

        $validated['status'] = 'pending'; // Statut par défaut

        $leaveRequest = LeaveRequest::create($validated);

        return response()->json([
            'message' => 'Demande de congé soumise avec succès.',
            'data' => $leaveRequest
        ], 201);
    }

    /**
     * Affiche une demande spécifique.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        return response()->json($leaveRequest->load(['employee', 'leaveType']), 200);
    }

    /**
     * Valide ou refuse une demande de congé (Action Manager/RH).
     */
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Statut de la demande mis à jour avec succès.',
            'data' => $leaveRequest
        ], 200);
    }

    /**
     * Supprime une demande.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();

        return response()->json([
            'message' => 'Demande de congé supprimée.'
        ], 200);
    }
}
