<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\StoreTeacherRequest;
use App\Http\Requests\Teachers\UpdateTeacherRequest;
use App\Services\Teachers\TeacherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// Controller managing educator profiles and classroom assignments.
class TeacherController extends Controller
{
    protected TeacherService $teacherService;

    /**
     * Inject TeacherService.
     */
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * Display a listing of the teachers.
     */
    public function index(): View
    {
        $teachers = $this->teacherService->getAllTeachers();

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create(): View
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        $this->teacherService->createTeacher($request->validated());

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant créé avec succès.');
    }

    /**
     * Display the specified teacher.
     */
    public function show(int $id): View
    {
        $teacher = $this->teacherService->getTeacherById($id);
        if (! $teacher) {
            abort(404);
        }

        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(int $id): View
    {
        $teacher = $this->teacherService->getTeacherById($id);
        if (! $teacher) {
            abort(404);
        }

        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(UpdateTeacherRequest $request, int $id): RedirectResponse
    {
        $this->teacherService->updateTeacher($id, $request->validated());

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->teacherService->deleteTeacher($id);

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
