<?php

namespace App\Services\Admin;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\Child;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Aggregates ERP-style metrics for the admin: tuition collection, outstanding
 * receivables, per-classroom revenue, plus the Employee-of-the-Month score
 * derived from activities led + attendance work hours.
 */
class ErpService
{
    public function tuitionLedger(int $tenantAdminId): array
    {
        $childIds = Child::whereHas('parent', fn ($q) => $q->where('tenant_admin_id', $tenantAdminId))
            ->pluck('id');

        $payments = Payment::whereIn('child_id', $childIds)->get();
        $paid = (float) $payments->where('statut', 'payé')->sum('montant');
        $outstanding = (float) $payments->where('statut', '!=', 'payé')->sum('montant');

        $collectionRate = ($paid + $outstanding) > 0
            ? round(($paid / ($paid + $outstanding)) * 100, 1)
            : 0;

        return [
            'paid' => $paid,
            'outstanding' => $outstanding,
            'collection_rate' => $collectionRate,
            'payments_count' => $payments->count(),
            'overdue_count' => $payments->where('statut', '!=', 'payé')
                ->filter(fn ($p) => $p->date_echeance && $p->date_echeance->isPast())
                ->count(),
        ];
    }

    public function revenueByClassroom(int $tenantAdminId): Collection
    {
        return Child::with(['classroom', 'payments'])
            ->whereHas('parent', fn ($q) => $q->where('tenant_admin_id', $tenantAdminId))
            ->get()
            ->groupBy(fn (Child $c) => $c->classroom?->nom ?? 'Sans classe')
            ->map(fn (Collection $children) => [
                'classroom' => $children->first()->classroom?->nom ?? 'Sans classe',
                'children_count' => $children->count(),
                'revenue' => (float) $children->flatMap->payments->where('statut', 'payé')->sum('montant'),
                'outstanding' => (float) $children->flatMap->payments->where('statut', '!=', 'payé')->sum('montant'),
            ])
            ->values();
    }

    public function monthlyRevenueSeries(int $tenantAdminId, int $months = 6): Collection
    {
        $childIds = Child::whereHas('parent', fn ($q) => $q->where('tenant_admin_id', $tenantAdminId))
            ->pluck('id');

        $start = Carbon::now()->subMonths($months - 1)->startOfMonth();

        $payments = Payment::whereIn('child_id', $childIds)
            ->where('statut', 'payé')
            ->where('paye_le', '>=', $start)
            ->get();

        return collect(range(0, $months - 1))->map(function ($offset) use ($start, $payments) {
            $month = (clone $start)->addMonths($offset);

            return [
                'label' => $month->translatedFormat('M Y'),
                'revenue' => (float) $payments->filter(fn ($p) => $p->paye_le && $p->paye_le->format('Y-m') === $month->format('Y-m'))->sum('montant'),
            ];
        });
    }

    /**
     * Score each educator for the current month:
     *   approved + completed activities led * 10
     * + present attendance entries (~work-hours proxy) for their classroom * 1
     * Winner = top score.
     */
    public function employeeOfTheMonth(int $tenantAdminId): ?array
    {
        $educators = User::role('educateur')
            ->where('tenant_admin_id', $tenantAdminId)
            ->with('teacher.classroom')
            ->get();

        if ($educators->isEmpty()) {
            return null;
        }

        $startOfMonth = Carbon::now()->startOfMonth();

        $scoreboard = $educators->map(function (User $educator) use ($startOfMonth) {
            $teacher = $educator->teacher;
            if (! $teacher) {
                return ['educator' => $educator, 'activities' => 0, 'work_hours' => 0, 'score' => 0];
            }

            $activitiesLed = Activity::where('educator_id', $teacher->id)
                ->whereIn('status', [ActivityStatus::Approved->value, ActivityStatus::Completed->value])
                ->where('scheduled_date', '>=', $startOfMonth)
                ->count();

            $workHours = $teacher->classroom
                ? $teacher->classroom->children()
                    ->withCount(['attendances' => fn ($q) => $q
                        ->where('statut', 'present')
                        ->where('date', '>=', $startOfMonth)])
                    ->get()
                    ->sum('attendances_count')
                : 0;

            return [
                'educator' => $educator,
                'activities' => $activitiesLed,
                'work_hours' => $workHours,
                'score' => $activitiesLed * 10 + $workHours,
            ];
        })->sortByDesc('score')->values();

        $winner = $scoreboard->first();

        return $winner['score'] > 0 ? [
            'winner' => $winner,
            'leaderboard' => $scoreboard->take(5),
        ] : null;
    }
}
