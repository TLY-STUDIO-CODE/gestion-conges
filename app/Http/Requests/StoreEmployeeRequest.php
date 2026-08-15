<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser l'action pour le moment
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'hire_date' => 'required|date',
            // Le solde de congés sera géré automatiquement à la création (par ex: 0 ou 25 par défaut)
        ];
    }
}
