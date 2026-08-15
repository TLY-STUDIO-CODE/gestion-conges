<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Liste tous les employés avec leur département.
     */
    public function index()
    {
        return response()->json(Employee::with('department')->get(), 200);
    }

    /**
     * Enregistre un nouvel employé.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'leave_balance' => 'integer|min:0',
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'message' => 'Employé créé avec succès.',
            'data' => $employee
        ], 201);
    }

    /**
     * Affiche un employé spécifique.
     */
    public function show(Employee $employee)
    {
        return response()->json($employee->load('department', 'leaveRequests'), 200);
    }

    /**
     * Met à jour un employé.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'sometimes|date',
            'department_id' => 'sometimes|exists:departments,id',
            'leave_balance' => 'sometimes|integer|min:0',
        ]);

        $employee->update($validated);

        return response()->json([
            'message' => 'Employé mis à jour avec succès.',
            'data' => $employee
        ], 200);
    }

    /**
     * Supprime un employé.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'message' => 'Employé supprimé avec succès.'
        ], 200);
    }
}
