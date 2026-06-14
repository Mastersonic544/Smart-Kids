<?php

namespace App\Services\Parent;

use App\Models\Child;
use App\Models\Meal;
use App\Models\Payment;
use App\Models\Teacher;
use App\Services\Meals\MealService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service to handle logic for the Parent Portal.
 */
class ParentDashboardService
{
    protected MealService $mealService;

    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    /**
     * Get children for a parent user.
     *
     * @return Collection
     */
    public function getChildData(int $parentId)
    {
        return Child::where('parent_id', $parentId)->with('classroom')->get();
    }

    /**
     * Get attendance count for a child this month.
     *
     * @return int
     */
    public function getAttendanceSummary(int $childId)
    {
        $child = Child::find($childId);
        if (! $child) {
            return 0;
        }

        $startOfMonth = Carbon::now()->startOfMonth();

        return $child->attendances()
            ->where('date', '>=', $startOfMonth)
            ->where('statut', 'present')
            ->count();
    }

    /**
     * Get payment history for a child.
     *
     * @return Collection
     */
    public function getPaymentHistory(int $childId)
    {
        return Payment::where('child_id', $childId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get next pending payment for a child.
     *
     * @return Payment|null
     */
    public function getNextPaymentDue(int $childId)
    {
        return Payment::where('child_id', $childId)
            ->where('statut', 'en attente')
            ->orderBy('created_at', 'asc')
            ->first();
    }

    /**
     * Get the menu for the current week.
     *
     * @return Meal|null
     */
    public function getCurrentMenu()
    {
        return $this->mealService->getCurrentWeekMenu();
    }

    /**
     * Aggregate dashboard data for all children of a parent.
     */
    public function getDashboardSummary(int $parentId): array
    {
        $children = $this->getChildData($parentId);
        $summary = [];

        foreach ($children as $child) {
            $summary[] = [
                'child' => $child,
                'attendance_count' => $this->getAttendanceSummary($child->id),
                'next_payment' => $this->getNextPaymentDue($child->id),
            ];
        }

        return $summary;
    }

    /**
     * Get activities for a child.
     *
     * @return Collection
     */
    public function getChildActivities(int $childId)
    {
        $child = Child::find($childId);
        if (! $child) {
            return collect();
        }

        return $child->activities()
            ->with('educator')
            ->orderBy('scheduled_date', 'desc')
            ->get();
    }

    /**
     * Get the teacher for a child's classroom.
     *
     * @return Teacher|null
     */
    public function getChildTeacher(Child $child)
    {
        if (! $child->classroom) {
            return null;
        }

        return $child->classroom->teacher;
    }

    /**
     * Process a simulated payment (mark as paid).
     */
    public function processPayment(Payment $payment): Payment
    {
        $payment->update([
            'statut' => 'payé',
            'paye_le' => Carbon::now(),
        ]);

        return $payment;
    }
}
