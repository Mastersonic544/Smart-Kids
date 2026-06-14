<?php

namespace App\Repositories\Teachers;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository to handle database operations for Teachers.
 */
class TeacherRepository implements TeacherRepositoryInterface
{
    /**
     * Get all teachers.
     */
    public function getAll(): Collection
    {
        return Teacher::with(['classroom'])->get();
    }

    /**
     * Find a teacher by ID.
     */
    public function findById(int $id): ?Teacher
    {
        return Teacher::with(['classroom'])->find($id);
    }

    /**
     * Create a new teacher.
     */
    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    /**
     * Update an existing teacher.
     */
    public function update(int $id, array $data): ?Teacher
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher->update($data);

            return $teacher;
        }

        return null;
    }

    /**
     * Delete a teacher by ID.
     */
    public function delete(int $id): bool
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            return $teacher->delete();
        }

        return false;
    }

    /**
     * Assign teacher to a classroom.
     */
    public function assignClassroom(int $teacherId, int $classroomId): ?Teacher
    {
        $teacher = Teacher::find($teacherId);
        if ($teacher) {
            // Depending on architecture, a teacher might have classroom_id on teachers table
            $teacher->classroom_id = $classroomId;
            $teacher->save();

            return $teacher;
        }

        return null;
    }
}
