<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeWebController extends Controller
{
    /**
     * Affiche la page de gestion des employés avec Inertia et Vue.js.
     */
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'employees' => Employee::with('department')->latest()->get(),
            'departments' => Department::all(),
        ]);
    }
}
