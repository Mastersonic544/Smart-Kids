<?php

namespace App\Repositories\Children;

use App\Models\Child;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository to handle database operations for Children.
 */
class ChildRepository implements ChildRepositoryInterface
{
    /**
     * Get all children.
     */
    public function getAll(): Collection
    {
        return Child::with(['parent', 'classroom'])->get();
    }

    /**
     * Find a child by ID.
     */
    public function findById(int $id): ?Child
    {
        return Child::with(['parent', 'classroom'])->find($id);
    }

    /**
     * Create a new child.
     */
    public function create(array $data): Child
    {
        return Child::create($data);
    }

    /**
     * Update an existing child.
     */
    public function update(int $id, array $data): ?Child
    {
        $child = Child::find($id);
        if ($child) {
            $child->update($data);

            return $child;
        }

        return null;
    }

    /**
     * Delete a child by ID.
     */
    public function delete(int $id): bool
    {
        $child = Child::find($id);
        if ($child) {
            return $child->delete();
        }

        return false;
    }

    /**
     * Assign child to a classroom.
     */
    public function assignToClassroom(int $childId, int $classroomId): ?Child
    {
        $child = Child::find($childId);
        if ($child) {
            $child->classroom_id = $classroomId;
            $child->save();

            return $child;
        }

        return null;
    }
}
