<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a weekly meal plan created by an administrator or staff.
 */
class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_start',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'created_by',
    ];

    protected $casts = [
        'week_start' => 'date',
        'monday' => 'array',
        'tuesday' => 'array',
        'wednesday' => 'array',
        'thursday' => 'array',
        'friday' => 'array',
    ];

    /**
     * Get the user who created the meal plan.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
