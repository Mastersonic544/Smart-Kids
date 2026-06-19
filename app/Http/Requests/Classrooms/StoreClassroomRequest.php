<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    /**
     * An unselected educator dropdown posts '' — Postgres rejects '' for the
     * bigint educator_id (SQLSTATE 22P02). Coerce blanks to null pre-validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('educator_id') === '') {
            $this->merge(['educator_id' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'niveau' => ['required', 'string', 'max:255'],
            'capacite' => ['required', 'integer', 'min:1'],
            'educator_id' => ['nullable', 'exists:teachers,id'],
        ];
    }
}
