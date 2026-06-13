<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Represents a teacher or educator in the system.
 */
class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'telephone',
        'document_contractuel',
    ];

    /**
     * Get the user account associated with this teacher.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activities this teacher is responsible for.
     *
     * @return HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'educator_id');
    }

    /**
     * Get the classroom this teacher is assigned to.
     *
     * @return HasOne
     */
    public function classroom(): HasOne
    {
        return $this->hasOne(Classroom::class, 'educator_id');
    }

    /**
     * Get the teacher's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }
}
