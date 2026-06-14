<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('educateur') ?? false;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'attendance' => ['required', 'array', 'min:1'],
            'attendance.*.child_id' => ['required', 'integer', 'exists:children,id'],
            'attendance.*.statut' => ['required', 'in:present,absent,en_retard'],
        ];
    }
}
