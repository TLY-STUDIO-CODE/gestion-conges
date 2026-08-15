<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeWebController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::with(['department', 'user'])->latest()->get(),
            'departments' => Department::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employees/Create', [
            'departments' => Department::all(),
        ]);
    }

    // Sauvegarde et création automatique du compte utilisateur lié
    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $validatedData = $request->validated();

            // 1. Création automatique du compte utilisateur pour la connexion
            $user = User::create([
                'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make('password123'), // Mot de passe par défaut modifiable
                'role' => 'employee',
            ]);

            // 2. Association du profil employé avec le compte utilisateur créé
            $validatedData['user_id'] = $user->id;
            $validatedData['leave_balance'] = 25; // Solde initial par défaut

            Employee::create($validatedData);
        });

        return redirect()->route('employees.index')->with('success', 'Employé et son compte de connexion créés avec succès !');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'departments' => Department::all(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        // Met à jour aussi l'email du compte utilisateur si l'employé est lié
        if ($employee->user) {
            $employee->user->update([
                'email' => $employee->email,
                'name' => $employee->first_name . ' ' . $employee->last_name,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employé mis à jour avec succès !');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        DB::transaction(function () use ($employee) {
            // Supprime le compte utilisateur associé s'il existe
            if ($employee->user) {
                $employee->user->delete();
            }
            $employee->delete();
        });

        return redirect()->route('employees.index')->with('success', 'Employé et son compte supprimés avec succès !');
    }
}
