<?php

namespace App\Services\Teachers;

use App\Models\Teacher;
use App\Repositories\Teachers\TeacherRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service to handle business logic for Teachers.
 */
class TeacherService
{
    protected TeacherRepositoryInterface $teacherRepository;

    /**
     * Inject TeacherRepositoryInterface.
     */
    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Get all teachers.
     */
    public function getAllTeachers(): Collection
    {
        return $this->teacherRepository->getAll();
    }

    /**
     * Get a teacher by ID.
     */
    public function getTeacherById(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    /**
     * Create a new teacher.
     */
    public function createTeacher(array $data): Teacher
    {
        return $this->teacherRepository->create($data);
    }

    /**
     * Update an existing teacher.
     */
    public function updateTeacher(int $id, array $data): ?Teacher
    {
        return $this->teacherRepository->update($id, $data);
    }

    /**
     * Delete a teacher by ID.
     */
    public function deleteTeacher(int $id): bool
    {
        return $this->teacherRepository->delete($id);
    }

    /**
     * Assign teacher to a classroom.
     */
    public function assignClassroom(int $teacherId, int $classroomId): ?Teacher
    {
        return $this->teacherRepository->assignClassroom($teacherId, $classroomId);
    }
}
