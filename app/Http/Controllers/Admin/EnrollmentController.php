<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

/**
 * Controller for managing Enrollments from Admin portal.
 */
class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('child')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function edit(Enrollment $enrollment)
    {
        return view('admin.enrollments.edit', compact('enrollment'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en attente,approuvé,rejeté',
            'notes' => 'nullable|string'
        ]);

        $enrollment->update($validated);
        return redirect()->route('admin.enrollments.index')->with('success', 'Inscription mise à jour.');
    }
}
