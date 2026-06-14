<?php

namespace App\Repositories\Children;

use App\Models\Child;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Child repository.
 */
interface ChildRepositoryInterface
{
    /**
     * Get all children.
     */
    public function getAll(): Collection;

    /**
     * Find a child by ID.
     */
    public function findById(int $id): ?Child;

    /**
     * Create a new child.
     */
    public function create(array $data): Child;

    /**
     * Update an existing child.
     */
    public function update(int $id, array $data): ?Child;

    /**
     * Delete a child by ID.
     */
    public function delete(int $id): bool;

    /**
     * Assign child to a classroom.
     */
    public function assignToClassroom(int $childId, int $classroomId): ?Child;
}
