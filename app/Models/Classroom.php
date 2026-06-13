<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Represents a classroom or section in the kindergarten.
 */
class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'niveau', 'capacite', 'educator_id'];

    /**
     * Get the educator (teacher) assigned to this classroom.
     *
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'educator_id');
    }

    /**
     * Get the educator user assigned to this classroom.
     *
     * @return BelongsTo
     */
    public function educator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    /**
     * Get all children in this classroom.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }
}
