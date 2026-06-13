<?php

namespace App\Services\Children;

use App\Models\Child;
use App\Repositories\Children\ChildRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service to handle business logic for Children.
 */
class ChildService
{
    protected ChildRepositoryInterface $childRepository;

    /**
     * Inject ChildRepositoryInterface.
     */
    public function __construct(ChildRepositoryInterface $childRepository)
    {
        $this->childRepository = $childRepository;
    }

    /**
     * Get all children.
     */
    public function getAllChildren(): Collection
    {
        return $this->childRepository->getAll();
    }

    /**
     * Get a child by ID.
     */
    public function getChildById(int $id): ?Child
    {
        return $this->childRepository->findById($id);
    }

    /**
     * Create a new child.
     */
    public function createChild(array $data): Child
    {
        return $this->childRepository->create($data);
    }

    /**
     * Update an existing child.
     */
    public function updateChild(int $id, array $data): ?Child
    {
        return $this->childRepository->update($id, $data);
    }

    /**
     * Delete a child by ID.
     */
    public function deleteChild(int $id): bool
    {
        return $this->childRepository->delete($id);
    }

    /**
     * Assign a child to a classroom.
     */
    public function assignToClassroom(int $childId, int $classroomId): ?Child
    {
        return $this->childRepository->assignToClassroom($childId, $classroomId);
    }
}
