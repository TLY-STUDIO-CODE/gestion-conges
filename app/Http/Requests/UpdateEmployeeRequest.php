<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Passage à true pour autoriser la requête
    }

    public function rules(): array
    {
        // On récupère l'employé via la route (route model binding)
        $employee = $this->route('employee');

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'department_id' => 'required|exists:departments,id',
            'hire_date' => 'required|date',
            'leave_balance' => 'required|integer|min:0',
        ];
    }
}
