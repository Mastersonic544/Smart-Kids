<?php

namespace App\Repositories\Activities;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Activity repository.
 */
interface ActivityRepositoryInterface
{
    /**
     * Get all activities.
     */
    public function getAll(): Collection;

    /**
     * Find an activity by ID.
     */
    public function findById(int $id): ?Activity;

    /**
     * Create a new activity.
     */
    public function create(array $data): Activity;

    /**
     * Update an existing activity.
     */
    public function update(int $id, array $data): ?Activity;

    /**
     * Delete an activity by ID.
     */
    public function delete(int $id): bool;

    /**
     * Enroll a child in an activity.
     */
    public function enrollChild(int $activityId, int $childId): void;

    /**
     * Update attendance for multiple children.
     *
     * @param  array  $childIds  (array of child IDs that attended)
     */
    public function markAttendance(int $activityId, array $childIds): void;
}
