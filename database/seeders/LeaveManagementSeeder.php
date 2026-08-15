<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Models\Department;

class LeaveManagementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Récupérer un département existant pour respecter la contrainte NOT NULL
        $department = Department::first();

        // 2. Récupérer ou s'assurer que les types de congés existent
        $type1 = LeaveType::firstOrCreate(['name' => 'Congé Annuel']);
        $type2 = LeaveType::firstOrCreate(['name' => 'Congé Maladie']);

        // 3. Créer des employés en incluant department_id et hire_date
        $emp1 = Employee::create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'hire_date' => '2024-01-15',
            'department_id' => $department ? $department->id : 1,
        ]);

        $emp2 = Employee::create([
            'first_name' => 'Marie',
            'last_name' => 'Curie',
            'email' => 'marie.curie@example.com',
            'hire_date' => '2023-06-01',
            'department_id' => $department ? $department->id : 1,
        ]);

        // 4. Créer des demandes de congés de test
        LeaveRequest::create([
            'employee_id' => $emp1->id,
            'leave_type_id' => $type1->id,
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-05',
            'status' => 'pending',
        ]);

        LeaveRequest::create([
            'employee_id' => $emp2->id,
            'leave_type_id' => $type2->id,
            'start_date' => '2026-08-20',
            'end_date' => '2026-08-22',
            'status' => 'approved',
        ]);
    }
}
