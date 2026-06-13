<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classrooms\StoreClassroomRequest;
use App\Http\Requests\Classrooms\UpdateClassroomRequest;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    public function index(): View
    {
        $classrooms = Classroom::withCount('children')->with('teacher')->get();

        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create(): View
    {
        $teachers = Teacher::all();

        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(StoreClassroomRequest $request): RedirectResponse
    {
        Classroom::create($request->validated());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classroom $classroom): View
    {
        $teachers = Teacher::all();

        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(UpdateClassroomRequest $request, Classroom $classroom): RedirectResponse
    {
        $classroom->update($request->validated());

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe mise à jour.');
    }

    public function destroy(Classroom $classroom): RedirectResponse
    {
        $classroom->delete();

        return redirect()->route('admin.classrooms.index')->with('success', 'Classe supprimée.');
    }
}
