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
     * Get statistics for the dashboard.
     *
     * @return array<string, mixed>
     */
    public function getStats(): array
    {
        return [
            'total_children' => Child::count(),
            'total_teachers' => Teacher::count(),
            'pending_enrollments' => Enrollment::where('statut', 'en attente')->count(),
            'overdue_payments' => Payment::where('statut', 'en attente')->count(),
            'classrooms' => Classroom::withCount('children')->get(),
        ];
    }
}
