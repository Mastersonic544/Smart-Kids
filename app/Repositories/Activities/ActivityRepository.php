<?php

namespace App\Repositories\Activities;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository to handle database operations for Activities.
 */
class ActivityRepository implements ActivityRepositoryInterface
{
    /**
     * Get all activities
     */
    public function getAll(): Collection
    {
        return Activity::with('educator')->orderBy('scheduled_date', 'asc')->get();
    }

    /**
     * Find by ID
     */
    public function findById(int $id): ?Activity
    {
        return Activity::with(['educator', 'children'])->find($id);
    }

    /**
     * Create an activity
     */
    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    /**
     * Update an activity
     */
    public function update(int $id, array $data): ?Activity
    {
        $activity = Activity::find($id);
        if ($activity) {
            $activity->update($data);

            return $activity;
        }

        return null;
    }

    /**
     * Delete an activity
     */
    public function delete(int $id): bool
    {
        $activity = Activity::find($id);
        if ($activity) {
            return $activity->delete();
        }

        return false;
    }

    /**
     * Enroll a child (attach to pivot)
     */
    public function enrollChild(int $activityId, int $childId): void
    {
        $activity = Activity::find($activityId);
        if ($activity) {
            // Avoid duplicates
            $activity->children()->syncWithoutDetaching([$childId]);
        }
    }

    /**
     * Mark attendance for children
     */
    public function markAttendance(int $activityId, array $childIds): void
    {
        $activity = Activity::find($activityId);
        if ($activity) {
            // Unmark all children for this activity
            $activity->children()->updateExistingPivot(
                $activity->children()->pluck('children.id')->toArray(),
                ['attended' => false]
            );

            // Mark specified children as attended
            if (! empty($childIds)) {
                $activity->children()->updateExistingPivot($childIds, ['attended' => true]);
            }
        }
    }
}
