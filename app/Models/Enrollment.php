<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents an enrollment application for a child.
 */
class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'statut',
        'documents_soumis',
        'notes',
    ];

    protected $casts = [
        'documents_soumis' => 'array',
    ];

    /**
     * Get the child this enrollment belongs to.
     *
     * @return BelongsTo
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }
}
