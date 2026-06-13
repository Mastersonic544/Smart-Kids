<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

/**
 * Controller for managing Classrooms from Admin portal.
 */
class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('children')->with('teacher')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'educator_id' => 'nullable|exists:teachers,id',
        ]);

        Classroom::create($validated);
        return redirect()->route('admin.classrooms.index')->with('success', 'Classe créée avec succès.');
    }

    public function edit(Classroom $classroom)
    {
        $teachers = Teacher::all();
        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'educator_id' => 'nullable|exists:teachers,id',
        ]);

        $classroom->update($validated);
        return redirect()->route('admin.classrooms.index')->with('success', 'Classe mise à jour.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Classe supprimée.');
    }
}
