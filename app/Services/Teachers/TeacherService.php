<?php

namespace App\Services\Teachers;

use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Teachers\TeacherRepositoryInterface;
use App\Support\PasscodeGenerator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherService
{
    protected TeacherRepositoryInterface $teacherRepository;

    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function getAllTeachers(): Collection
    {
        return $this->teacherRepository->getAll();
    }

    public function getTeacherById(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    /**
     * Create a Teacher row AND the linked educator User account (with a freshly
     * minted 6-digit passcode), inside a transaction.
     *
     * Returns the Teacher with the User attached for caller convenience; the raw
     * passcode is flashed back via the controller so the admin can hand it off.
     */
    public function createTeacher(array $data, ?int $tenantAdminId = null): array
    {
        return DB::transaction(function () use ($data, $tenantAdminId) {
            $passcode = PasscodeGenerator::generate();

            $user = User::create([
                'name' => trim(($data['prenom'] ?? '').' '.($data['nom'] ?? '')),
                'email' => $data['email'],
                'phone' => $data['telephone'] ?? null,
                // Passcode is the real credential; password kept random for legacy guard.
                'password' => Hash::make(Str::random(40)),
                'passcode' => $passcode,
                'tenant_admin_id' => $tenantAdminId,
            ]);
            $user->assignRole('educateur');

            $teacher = $this->teacherRepository->create([
                ...$data,
                'user_id' => $user->id,
            ]);

            return ['teacher' => $teacher, 'user' => $user, 'passcode' => $passcode];
        });
    }

    public function updateTeacher(int $id, array $data): ?Teacher
    {
        return $this->teacherRepository->update($id, $data);
    }

    public function deleteTeacher(int $id): bool
    {
        return $this->teacherRepository->delete($id);
    }

    public function assignClassroom(int $teacherId, int $classroomId): ?Teacher
    {
        return $this->teacherRepository->assignClassroom($teacherId, $classroomId);
    }

    public function regeneratePasscode(Teacher $teacher): string
    {
        abort_unless($teacher->user, 422, 'Cet éducateur n\'a pas de compte utilisateur lié.');

        $passcode = PasscodeGenerator::generate();
        $teacher->user->update(['passcode' => $passcode]);

        return $passcode;
    }
}
