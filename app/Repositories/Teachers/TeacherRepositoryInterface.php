<?php

namespace App\Repositories\Teachers;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Teacher repository.
 */
interface TeacherRepositoryInterface
{
    /**
     * Get all teachers.
     */
    public function getAll(): Collection;

    /**
     * Find a teacher by ID.
     */
    public function findById(int $id): ?Teacher;

    /**
     * Create a new teacher.
     */
    public function create(array $data): Teacher;

    /**
     * Update an existing teacher.
     */
    public function update(int $id, array $data): ?Teacher;

    /**
     * Delete a teacher by ID.
     */
    public function delete(int $id): bool;

    /**
     * Assign teacher to a classroom.
     */
    public function assignClassroom(int $teacherId, int $classroomId): ?Teacher;
}
