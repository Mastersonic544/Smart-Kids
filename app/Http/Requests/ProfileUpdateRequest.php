<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        // Admins can also update their kindergarten's monthly tuition price (TND).
        if ($this->user()?->hasRole('admin')) {
            $rules['monthly_tuition_tnd'] = ['nullable', 'numeric', 'min:0', 'max:99999.999'];
        }

        return $rules;
    }
}
