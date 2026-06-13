<?php

namespace App\Http\Requests\Enrollments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', 'in:en attente,approuvé,rejeté'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
