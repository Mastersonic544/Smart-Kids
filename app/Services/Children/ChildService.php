<?php

namespace App\Services\Children;

use App\Repositories\Children\ChildRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Child;

/**
 * Service to handle business logic for Children.
 */
class ChildService
{
    protected ChildRepositoryInterface $childRepository;

    /**
     * Inject ChildRepositoryInterface.
     *
     * @param ChildRepositoryInterface $childRepository
     */
    public function __construct(ChildRepositoryInterface $childRepository)
    {
        $this->childRepository = $childRepository;
    }

    /**
     * Get all children.
     *
     * @return Collection
     */
    public function getAllChildren(): Collection
    {
        return $this->childRepository->getAll();
    }

    /**
     * Get a child by ID.
     *
     * @param int $id
     * @return Child|null
     */
    public function getChildById(int $id): ?Child
    {
        return $this->childRepository->findById($id);
    }

    /**
     * Create a new child.
     *
     * @param array $data
     * @return Child
     */
    public function createChild(array $data): Child
    {
        return $this->childRepository->create($data);
    }

    /**
     * Update an existing child.
     *
     * @param int $id
     * @param array $data
     * @return Child|null
     */
    public function updateChild(int $id, array $data): ?Child
    {
        return $this->childRepository->update($id, $data);
    }

    /**
     * Delete a child by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteChild(int $id): bool
    {
        return $this->childRepository->delete($id);
    }

    /**
     * Assign a child to a classroom.
     *
     * @param int $childId
     * @param int $classroomId
     * @return Child|null
     */
    public function assignToClassroom(int $childId, int $classroomId): ?Child
    {
        return $this->childRepository->assignToClassroom($childId, $classroomId);
    }
}
