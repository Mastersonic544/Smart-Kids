<?php

namespace App\Services\Teachers;

use App\Repositories\Teachers\TeacherRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Teacher;

/**
 * Service to handle business logic for Teachers.
 */
class TeacherService
{
    protected TeacherRepositoryInterface $teacherRepository;

    /**
     * Inject TeacherRepositoryInterface.
     *
     * @param TeacherRepositoryInterface $teacherRepository
     */
    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Get all teachers.
     *
     * @return Collection
     */
    public function getAllTeachers(): Collection
    {
        return $this->teacherRepository->getAll();
    }

    /**
     * Get a teacher by ID.
     *
     * @param int $id
     * @return Teacher|null
     */
    public function getTeacherById(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    /**
     * Create a new teacher.
     *
     * @param array $data
     * @return Teacher
     */
    public function createTeacher(array $data): Teacher
    {
        return $this->teacherRepository->create($data);
    }

    /**
     * Update an existing teacher.
     *
     * @param int $id
     * @param array $data
     * @return Teacher|null
     */
    public function updateTeacher(int $id, array $data): ?Teacher
    {
        return $this->teacherRepository->update($id, $data);
    }

    /**
     * Delete a teacher by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteTeacher(int $id): bool
    {
        return $this->teacherRepository->delete($id);
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
        return $this->teacherRepository->assignClassroom($teacherId, $classroomId);
    }
}
