<?php

namespace App\Repositories\Activities;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Activity;

/**
 * Interface for Activity repository.
 */
interface ActivityRepositoryInterface
{
    /**
     * Get all activities.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find an activity by ID.
     *
     * @param int $id
     * @return Activity|null
     */
    public function findById(int $id): ?Activity;

    /**
     * Create a new activity.
     *
     * @param array $data
     * @return Activity
     */
    public function create(array $data): Activity;

    /**
     * Update an existing activity.
     *
     * @param int $id
     * @param array $data
     * @return Activity|null
     */
    public function update(int $id, array $data): ?Activity;

    /**
     * Delete an activity by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Enroll a child in an activity.
     *
     * @param int $activityId
     * @param int $childId
     * @return void
     */
    public function enrollChild(int $activityId, int $childId): void;

    /**
     * Update attendance for multiple children.
     * 
     * @param int $activityId
     * @param array $childIds (array of child IDs that attended)
     * @return void
     */
    public function markAttendance(int $activityId, array $childIds): void;
}
