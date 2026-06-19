<?php

namespace App\Services\Admin;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Teacher;

/**
 * Service handling dashboard statistics and aggregations.
 */
class DashboardService
{
    /**
     * Get statistics for the dashboard, scoped to a single kindergarten tenant.
     *
     * @param  int|null  $tenantAdminId  the admin's own id; null for superadmin
     *                                   (or unauthenticated) which sees everything.
     * @return array<string, mixed>
     */
    public function getStats(?int $tenantAdminId = null): array
    {
        return [
            'total_children' => Child::query()
                ->when($tenantAdminId, fn ($q) => $q->whereHas('parent', fn ($p) => $p->where('tenant_admin_id', $tenantAdminId)))
                ->count(),

            'total_teachers' => Teacher::query()
                ->when($tenantAdminId, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantAdminId)))
                ->count(),

            'pending_enrollments' => Enrollment::query()
                ->where('statut', 'en attente')
                ->when($tenantAdminId, fn ($q) => $q->whereHas('child.parent', fn ($p) => $p->where('tenant_admin_id', $tenantAdminId)))
                ->count(),

            'overdue_payments' => Payment::query()
                ->where('statut', 'en attente')
                ->when($tenantAdminId, fn ($q) => $q->whereHas('child.parent', fn ($p) => $p->where('tenant_admin_id', $tenantAdminId)))
                ->count(),

            'classrooms' => Classroom::query()
                ->withCount('children')
                ->when($tenantAdminId, fn ($q) => $q->whereHas('teacher.user', fn ($u) => $u->where('tenant_admin_id', $tenantAdminId)))
                ->get(),
        ];
    }
}
