<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Classrooms\StoreClassroomRequest;
use App\Http\Requests\Classrooms\UpdateClassroomRequest;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    use ScopesToTenant;

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $classrooms = Classroom::query()
            ->withCount('children')
            ->with('teacher.user')
            ->when($tenantId, fn ($q) => $q->whereHas('teacher.user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create(): View
    {
        $teachers = $this->tenantTeachers();

        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(StoreClassroomRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->ensureTeacherInTenant($data['educator_id'] ?? null);

        Classroom::create($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classroom $classroom): View
    {
        $this->ensureClassroomInTenant($classroom);
        $teachers = $this->tenantTeachers();

        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(UpdateClassroomRequest $request, Classroom $classroom): RedirectResponse
    {
        $this->ensureClassroomInTenant($classroom);
        $data = $request->validated();
        $this->ensureTeacherInTenant($data['educator_id'] ?? null);

        $classroom->update($data);

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe mise à jour.');
    }

    public function destroy(Classroom $classroom): RedirectResponse
    {
        $this->ensureClassroomInTenant($classroom);
        $classroom->delete();

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe supprimée.');
    }

    private function tenantTeachers()
    {
        $tenantId = $this->currentTenantAdminId();

        return Teacher::query()
            ->when($tenantId, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();
    }

    private function ensureClassroomInTenant(Classroom $classroom): void
    {
        $this->ensureInTenant($classroom, fn (Classroom $c) => $c->teacher?->user_id);
    }

    private function ensureTeacherInTenant(?int $teacherId): void
    {
        if (! $teacherId) {
            return;
        }
        $tenantId = $this->currentTenantAdminId();
        if ($tenantId === null) {
            return;
        }
        $teacher = Teacher::with('user')->find($teacherId);
        abort_unless($teacher && $teacher->user && $teacher->user->tenant_admin_id === $tenantId, 403, 'Cet éducateur appartient à un autre établissement.');
    }
}
