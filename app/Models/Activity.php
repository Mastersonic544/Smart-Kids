<?php

namespace App\Models;

use App\Enums\ActivityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A planned (or requested) activity in the kindergarten.
 *
 * Lifecycle: educator submits a request (status=pending_approval) ->
 * admin approves (status=approved) -> kids enrolled & attend ->
 * educator marks completed (status=completed). Rejected requests
 * stay visible to the educator with rejection_reason.
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
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'approved_at' => 'datetime',
        'status' => ActivityStatus::class,
    ];

    public function educator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'educator_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Child::class)->withPivot('attended');
    }
}
