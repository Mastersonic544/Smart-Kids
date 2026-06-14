<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollments\UpdateEnrollmentRequest;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    use ScopesToTenant;

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $enrollments = Enrollment::query()
            ->with('child.parent')
            ->when($tenantId, fn ($q) => $q->whereHas('child.parent', fn ($p) => $p->where('tenant_admin_id', $tenantId)))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function edit(Enrollment $enrollment): View
    {
        $this->ensureEnrollmentInTenant($enrollment);

        return view('admin.enrollments.edit', compact('enrollment'));
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment): RedirectResponse
    {
        $this->ensureEnrollmentInTenant($enrollment);
        $enrollment->update($request->validated());

        return redirect()->route('admin.enrollments.index')->with('success', 'Inscription mise à jour.');
    }

    private function ensureEnrollmentInTenant(Enrollment $enrollment): void
    {
        $this->ensureInTenant($enrollment, fn (Enrollment $e) => $e->child?->parent_id);
    }
}
