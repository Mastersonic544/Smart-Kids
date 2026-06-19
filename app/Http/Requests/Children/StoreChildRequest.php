<?php

namespace App\Http\Requests\Children;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChildRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize optional foreign keys before validation: an unselected dropdown
     * posts an empty string, and Postgres rejects '' for a bigint column
     * (SQLSTATE 22P02). Coerce blanks to null so the insert is valid on every
     * database, without relying on global middleware.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('classroom_id') === '') {
            $this->merge(['classroom_id' => null]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_naissance' => ['required', 'date', 'before:today'],
            'allergies' => ['nullable', 'string'],
            'parent_id' => ['required', 'exists:users,id'],
            'classroom_id' => ['nullable', 'exists:classrooms,id'],
        ];
    }
}
