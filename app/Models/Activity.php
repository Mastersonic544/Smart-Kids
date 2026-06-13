<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Represents a planned activity in the kindergarten.
 */
class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'scheduled_date',
        'scheduled_time',
        'educator_id',
        'max_participants',
    ];

    /**
     * Get the educator (teacher) responsible for this activity.
     *
     * @return BelongsTo
     */
    public function educator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'educator_id');
    }

    /**
     * Get the children attending this activity.
     *
     * @return BelongsToMany
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)
            ->withPivot('attended');
    }
}
