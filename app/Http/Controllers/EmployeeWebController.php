<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class EmployeeWebController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::with('department')->latest()->get(),
            'departments' => Department::all(),
        ]);
    }

    // Affiche le formulaire de création
    public function create()
    {
        return Inertia::render('Employees/Create', [
            'departments' => Department::all(),
        ]);
    }

    // Sauvegarde le nouvel employé en base de données
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // On donne un solde de congé initial (ex: 25 jours) par défaut
        $validatedData['leave_balance'] = 25;

        Employee::create($validatedData);

        return redirect()->route('employees.index')->with('success', 'Employé créé avec succès !');
    }

    // Affiche le formulaire de modification
    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'departments' => Department::all(),
        ]);
    }

    // Met à jour l'employé en base de données
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()->route('employees.index')->with('success', 'Employé mis à jour avec succès !');
    }

    // Supprime l'employé
    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employé supprimé avec succès !');
    }
}
