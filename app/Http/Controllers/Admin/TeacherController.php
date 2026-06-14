<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\StoreTeacherRequest;
use App\Http\Requests\Teachers\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Services\Teachers\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TeacherController extends Controller
{
    use ScopesToTenant;

    protected TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $teachers = Teacher::query()
            ->with(['user', 'classroom'])
            ->when($tenantId, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        return view('admin.teachers.create');
    }

    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        $result = $this->teacherService->createTeacher($request->validated(), Auth::id());

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Enseignant créé avec succès.')
            ->with('educator_passcode', [
                'name' => $result['user']->name,
                'email' => $result['user']->email,
                'passcode' => $result['passcode'],
            ]);
    }

    public function show(int $id): View
    {
        $teacher = Teacher::with(['user', 'classroom', 'activities'])->findOrFail($id);
        $this->ensureTeacherInTenant($teacher);

        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(int $id): View
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $this->ensureTeacherInTenant($teacher);

        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(UpdateTeacherRequest $request, int $id): RedirectResponse
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $this->ensureTeacherInTenant($teacher);

        $this->teacherService->updateTeacher($id, $request->validated());

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $this->ensureTeacherInTenant($teacher);

        $this->teacherService->deleteTeacher($id);

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant supprimé avec succès.');
    }

    public function regeneratePasscode(Teacher $teacher): RedirectResponse
    {
        $this->ensureTeacherInTenant($teacher);
        $passcode = $this->teacherService->regeneratePasscode($teacher);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Nouveau code généré.')
            ->with('educator_passcode', [
                'name' => $teacher->user->name,
                'email' => $teacher->user->email,
                'passcode' => $passcode,
            ]);
    }

    private function ensureTeacherInTenant(Teacher $teacher): void
    {
        $this->ensureInTenant($teacher, fn (Teacher $t) => $t->user_id);
    }
}
