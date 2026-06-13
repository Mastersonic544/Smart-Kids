<?php

namespace App\Http\Requests\Activities;

use Illuminate\Foundation\Http\FormRequest;

class RequestActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('educateur') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'max_participants' => ['nullable', 'integer', 'min:1', 'max:200'],
        ];
    }
}
