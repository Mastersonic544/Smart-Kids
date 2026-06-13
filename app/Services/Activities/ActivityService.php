<?php

namespace App\Services\Activities;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\ActivityApprovedNotification;
use App\Notifications\ActivityRejectedNotification;
use App\Repositories\Activities\ActivityRepositoryInterface;
use App\Services\Messages\SystemMessenger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class ActivityService
{
    protected ActivityRepositoryInterface $activityRepository;

    protected SystemMessenger $systemMessenger;

    public function __construct(ActivityRepositoryInterface $activityRepository, SystemMessenger $systemMessenger)
    {
        $this->activityRepository = $activityRepository;
        $this->systemMessenger = $systemMessenger;
    }

    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getAll();
    }

    public function getActivityById(int $id): ?Activity
    {
        return $this->activityRepository->findById($id);
    }

    /**
     * Admin-created activities skip the approval gate and start in 'approved'.
     */
    public function createActivity(array $data): Activity
    {
        return $this->activityRepository->create([
            ...$data,
            'status' => ActivityStatus::Approved->value,
            'approved_at' => now(),
        ]);
    }

    /**
     * Educator-submitted request — sits in pending_approval until admin acts.
     */
    public function requestActivity(User $educator, array $data): Activity
    {
        $teacher = Teacher::where('user_id', $educator->id)->firstOrFail();

        return $this->activityRepository->create([
            ...$data,
            'educator_id' => $teacher->id,
            'requested_by' => $educator->id,
            'status' => ActivityStatus::PendingApproval->value,
        ]);
    }

    public function updateActivity(int $id, array $data): ?Activity
    {
        return $this->activityRepository->update($id, $data);
    }

    public function deleteActivity(int $id): bool
    {
        return $this->activityRepository->delete($id);
    }

    public function approveActivity(Activity $activity, User $admin): Activity
    {
        $activity->update([
            'status' => ActivityStatus::Approved->value,
            'approved_by' => $admin->id,
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        // Notify every parent whose child is enrolled in this activity.
        $parentIds = $activity->children()->with('parent')->get()->pluck('parent.id')->filter()->unique();
        if ($parentIds->isNotEmpty()) {
            $parents = User::whereIn('id', $parentIds)->get();
            Notification::send($parents, new ActivityApprovedNotification($activity));
            $this->systemMessenger->broadcast(
                $parents,
                "Activité approuvée : « {$activity->name} » est confirmée pour le "
                    .$activity->scheduled_date->translatedFormat('d F Y').'.'
            );
        }

        return $activity->refresh();
    }

    public function rejectActivity(Activity $activity, User $admin, ?string $reason = null): Activity
    {
        $activity->update([
            'status' => ActivityStatus::Rejected->value,
            'approved_by' => $admin->id,
            'approved_at' => now(),
            'rejection_reason' => $reason,
        ]);

        if ($activity->requester) {
            $activity->requester->notify(new ActivityRejectedNotification($activity));
        }

        return $activity->refresh();
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
