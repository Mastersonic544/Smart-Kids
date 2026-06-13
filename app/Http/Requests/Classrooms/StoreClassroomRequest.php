<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
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
