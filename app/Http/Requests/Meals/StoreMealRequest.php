<?php

namespace App\Http\Requests\Meals;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'week_start' => ['required', 'date'],
            'monday.breakfast' => ['nullable', 'string'],
            'monday.lunch' => ['nullable', 'string'],
            'monday.snack' => ['nullable', 'string'],
            'tuesday.breakfast' => ['nullable', 'string'],
            'tuesday.lunch' => ['nullable', 'string'],
            'tuesday.snack' => ['nullable', 'string'],
            'wednesday.breakfast' => ['nullable', 'string'],
            'wednesday.lunch' => ['nullable', 'string'],
            'wednesday.snack' => ['nullable', 'string'],
            'thursday.breakfast' => ['nullable', 'string'],
            'thursday.lunch' => ['nullable', 'string'],
            'thursday.snack' => ['nullable', 'string'],
            'friday.breakfast' => ['nullable', 'string'],
            'friday.lunch' => ['nullable', 'string'],
            'friday.snack' => ['nullable', 'string'],
        ];
    }
}
