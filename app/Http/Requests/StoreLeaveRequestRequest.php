<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class StoreLeaveRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ];
    }

    // Validation personnalisée après les règles de base
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $employeeId = $this->input('employee_id');
            $leaveTypeId = $this->input('leave_type_id');
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');

            if (!$employeeId || !$leaveTypeId || !$startDate || !$endDate) {
                return;
            }

            // 1. Calculer le nombre de jours ouvrés demandés
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            $businessDays = 0;
            foreach ($period as $date) {
                if ($date->isWeekday()) {
                    $businessDays++;
                }
            }

            // 2. Vérifier le type de congé (par exemple, si c'est un congé payé)
            $leaveType = LeaveType::find($leaveTypeId);
            $employee = Employee::find($employeeId);

            // Supposons que le type de congé payé exige un solde suffisant
            // (vous pouvez ajuster la condition selon le nom de votre type de congé en base)
            if ($leaveType && str_contains(strtolower($leaveType->name), 'payé')) {
                if ($employee->leave_balance < $businessDays) {
                    $validator->errors()->add(
                        'end_date',
                        "Solde insuffisant. L'employé demande {$businessDays} jours mais ne dispose que de {$employee->leave_balance} jours de congés payés."
                    );
                }
            }
        });
    }
}
