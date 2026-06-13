<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollments\UpdateEnrollmentRequest;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(): View
    {
        $enrollments = Enrollment::with('child')->orderByDesc('created_at')->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function edit(Enrollment $enrollment): View
    {
        return view('admin.enrollments.edit', compact('enrollment'));
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment): RedirectResponse
    {
        $enrollment->update($request->validated());

        return redirect()->route('admin.enrollments.index')->with('success', 'Inscription mise à jour.');
    }
}
