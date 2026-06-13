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
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Teacher::with(['classroom'])->get();
    }

    /**
     * Find a teacher by ID.
     *
     * @param int $id
     * @return Teacher|null
     */
    public function findById(int $id): ?Teacher
    {
        return Teacher::with(['classroom'])->find($id);
    }

    /**
     * Create a new teacher.
     *
     * @param array $data
     * @return Teacher
     */
    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    /**
     * Update an existing teacher.
     *
     * @param int $id
     * @param array $data
     * @return Teacher|null
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
     *
     * @param int $id
     * @return bool
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
     *
     * @param int $teacherId
     * @param int $classroomId
     * @return Teacher|null
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
