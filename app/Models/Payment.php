<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a payment record for a child.
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'montant',
        'statut',
        'pdf_path',
        'mois',
        'date_echeance',
        'paye_le',
    ];

    protected $casts = [
        'date_echeance' => 'date',
        'paye_le' => 'datetime',
    ];

    /**
     * Get the child this payment belongs to.
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }
}
