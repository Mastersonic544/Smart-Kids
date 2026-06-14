<?php

namespace App\Services\Educateur;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\User;
use Carbon\Carbon;

/**
 * Service handling all educator portal business logic.
 */
class EducateurDashboardService
{
    /**
     * Get dashboard data for an educator user.
     */
    public function getDashboardData(User $user): array
    {
        $teacher = $user->teacher;
        $classroom = $teacher ? $teacher->classroom : null;
        $studentCount = $classroom ? $classroom->children()->count() : 0;
        $todayDate = Carbon::today()->format('Y-m-d');

        $todayAttendance = [];
        if ($classroom) {
            $childIds = $classroom->children()->pluck('id');
            $presentCount = Attendance::whereIn('child_id', $childIds)
                ->where('date', $todayDate)
                ->where('statut', 'present')
                ->count();
            $absentCount = Attendance::whereIn('child_id', $childIds)
                ->where('date', $todayDate)
                ->where('statut', 'absent')
                ->count();
            $todayAttendance = [
                'present' => $presentCount,
                'absent' => $absentCount,
                'not_marked' => $studentCount - $presentCount - $absentCount,
            ];
        }

        $upcomingActivities = $teacher
            ? $teacher->activities()->where('scheduled_date', '>=', Carbon::today())->orderBy('scheduled_date')->take(5)->get()
            : collect();

        return [
            'teacher' => $teacher,
            'classroom' => $classroom,
            'studentCount' => $studentCount,
            'todayAttendance' => $todayAttendance,
            'upcomingActivities' => $upcomingActivities,
        ];
    }

    /**
     * Get students in the educator's assigned classroom.
     */
    public function getClassStudents(User $user): array
    {
        $teacher = $user->teacher;
        $classroom = $teacher ? $teacher->classroom : null;
        $students = $classroom ? $classroom->children()->with('parent')->get() : collect();

        return [
            'classroom' => $classroom,
            'students' => $students,
        ];
    }

    /**
     * Get attendance records for a specific date.
     */
    public function getAttendanceForDate(User $user, string $date): array
    {
        $teacher = $user->teacher;
        $classroom = $teacher ? $teacher->classroom : null;
        $students = $classroom ? $classroom->children()->get() : collect();

        $existingAttendance = [];
        if ($classroom) {
            $records = Attendance::whereIn('child_id', $students->pluck('id'))
                ->where('date', $date)
                ->get()
                ->keyBy('child_id');
            $existingAttendance = $records;
        }

        return [
            'classroom' => $classroom,
            'students' => $students,
            'date' => $date,
            'existingAttendance' => $existingAttendance,
        ];
    }

    /**
     * Save attendance records for a day.
     */
    public function saveAttendance(string $date, array $attendanceData): void
    {
        foreach ($attendanceData as $record) {
            Attendance::updateOrCreate(
                [
                    'child_id' => $record['child_id'],
                    'date' => $date,
                ],
                [
                    'statut' => $record['statut'],
                    'motif' => $record['motif'] ?? null,
                ]
            );
        }
    }

    /**
     * Get activities managed by this educator.
     */
    public function getEducatorActivities(User $user): array
    {
        $teacher = $user->teacher;
        $activities = $teacher
            ? $teacher->activities()->with('children')->orderBy('scheduled_date', 'desc')->get()
            : collect();

        return [
            'activities' => $activities,
        ];
    }
}
