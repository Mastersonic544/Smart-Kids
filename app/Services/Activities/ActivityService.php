<?php

namespace App\Services\Activities;

use App\Models\Activity;
use App\Repositories\Activities\ActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service to handle business logic for Activities.
 */
class ActivityService
{
    protected ActivityRepositoryInterface $activityRepository;

    /**
     * Inject ActivityRepositoryInterface.
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getAll();
    }

    public function getActivityById(int $id): ?Activity
    {
        return $this->activityRepository->findById($id);
    }

    public function createActivity(array $data): Activity
    {
        return $this->activityRepository->create($data);
    }

    public function updateActivity(int $id, array $data): ?Activity
    {
        return $this->activityRepository->update($id, $data);
    }

    public function deleteActivity(int $id): bool
    {
        return $this->activityRepository->delete($id);
    }

    public function enrollChild(int $activityId, int $childId): void
    {
        $this->activityRepository->enrollChild($activityId, $childId);
    }

    public function markAttendance(int $activityId, array $childIds): void
    {
        $this->activityRepository->markAttendance($activityId, $childIds);
    }

    public function getActivityReport(int $activityId): array
    {
        $activity = $this->activityRepository->findById($activityId);
        if (! $activity) {
            return [];
        }

        $totalEnrolled = $activity->children->count();
        $attended = $activity->children->where('pivot.attended', true)->count();

        return [
            'activity_name' => $activity->name,
            'scheduled_date' => $activity->scheduled_date,
            'total_enrolled' => $totalEnrolled,
            'attended' => $attended,
            'attendance_rate' => $totalEnrolled > 0 ? round(($attended / $totalEnrolled) * 100, 2) : 0,
        ];
    }
}
