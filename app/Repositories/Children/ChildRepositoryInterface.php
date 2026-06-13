<?php

namespace App\Repositories\Children;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Child;

/**
 * Interface for Child repository.
 */
interface ChildRepositoryInterface
{
    /**
     * Get all children.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a child by ID.
     *
     * @param int $id
     * @return Child|null
     */
    public function findById(int $id): ?Child;

    /**
     * Create a new child.
     *
     * @param array $data
     * @return Child
     */
    public function create(array $data): Child;

    /**
     * Update an existing child.
     *
     * @param int $id
     * @param array $data
     * @return Child|null
     */
    public function update(int $id, array $data): ?Child;

    /**
     * Delete a child by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Assign child to a classroom.
     *
     * @param int $childId
     * @param int $classroomId
     * @return Child|null
     */
    public function assignToClassroom(int $childId, int $classroomId): ?Child;
}
