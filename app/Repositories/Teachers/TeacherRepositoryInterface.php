<?php

namespace App\Repositories\Teachers;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Teacher;

/**
 * Interface for Teacher repository.
 */
interface TeacherRepositoryInterface
{
    /**
     * Get all teachers.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a teacher by ID.
     *
     * @param int $id
     * @return Teacher|null
     */
    public function findById(int $id): ?Teacher;

    /**
     * Create a new teacher.
     *
     * @param array $data
     * @return Teacher
     */
    public function create(array $data): Teacher;

    /**
     * Update an existing teacher.
     *
     * @param int $id
     * @param array $data
     * @return Teacher|null
     */
    public function update(int $id, array $data): ?Teacher;

    /**
     * Delete a teacher by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Assign teacher to a classroom.
     *
     * @param int $teacherId
     * @param int $classroomId
     * @return Teacher|null
     */
    public function assignClassroom(int $teacherId, int $classroomId): ?Teacher;
}
