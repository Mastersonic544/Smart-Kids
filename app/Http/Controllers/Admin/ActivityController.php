<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Requests\Activities\EnrollChildActivityRequest;
use App\Http\Requests\Activities\StoreActivityRequest;
use App\Http\Requests\Activities\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Child;
use App\Models\Teacher;
use App\Services\Activities\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ActivityController extends Controller
{
    use ScopesToTenant;

    protected ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $activities = Activity::query()
            ->with(['educator.user', 'children', 'requester'])
            ->when($tenantId, fn ($q) => $q->whereHas('educator.user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->orderByDesc('scheduled_date')
            ->get();

        return view('admin.activities.index', compact('activities'));
    }

    public function create(): View
    {
        $tenantId = $this->currentTenantAdminId();
        $teachers = Teacher::query()
            ->when($tenantId, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.activities.create', compact('teachers'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->createActivity($request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activité créée avec succès.');
    }

    public function show(int $id): View
    {
        $activity = Activity::with(['educator.user', 'children.parent'])->findOrFail($id);
        $this->ensureActivityInTenant($activity);

        $report = $this->activityService->getActivityReport($id);

        $tenantId = $this->currentTenantAdminId();
        $allChildren = Child::query()
            ->when($tenantId, fn ($q) => $q->whereHas('parent', fn ($p) => $p->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.activities.show', compact('activity', 'report', 'allChildren'));
    }

    public function edit(int $id): View
    {
        $activity = Activity::with('educator.user')->findOrFail($id);
        $this->ensureActivityInTenant($activity);

        $tenantId = $this->currentTenantAdminId();
        $teachers = Teacher::query()
            ->when($tenantId, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.activities.edit', compact('activity', 'teachers'));
    }

    public function update(UpdateActivityRequest $request, int $id): RedirectResponse
    {
        $activity = Activity::with('educator.user')->findOrFail($id);
        $this->ensureActivityInTenant($activity);

        $this->activityService->updateActivity($id, $request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activité mise à jour.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $activity = Activity::with('educator.user')->findOrFail($id);
        $this->ensureActivityInTenant($activity);

        $this->activityService->deleteActivity($id);

        return redirect()->route('admin.activities.index')->with('success', 'Activité supprimée.');
    }

    public function enrollChild(EnrollChildActivityRequest $request, int $activityId): RedirectResponse
    {
        $activity = Activity::with('educator.user')->findOrFail($activityId);
        $this->ensureActivityInTenant($activity);

        $this->activityService->enrollChild($activityId, $request->validated()['child_id']);

        return redirect()->route('admin.activities.show', $activityId)->with('success', 'Enfant inscrit avec succès.');
    }

    public function markAttendance(Request $request, int $activityId): RedirectResponse
    {
        $activity = Activity::with('educator.user')->findOrFail($activityId);
        $this->ensureActivityInTenant($activity);

        $childIds = $request->input('attended_children', []);
        $this->activityService->markAttendance($activityId, $childIds);

        return redirect()->route('admin.activities.show', $activityId)->with('success', 'Présences mises à jour.');
    }

    public function approve(Activity $activity): RedirectResponse
    {
        $this->ensureActivityInTenant($activity);
        $this->activityService->approveActivity($activity, Auth::user());

        return redirect()->route('admin.activities.index')->with('success', 'Activité approuvée et parents notifiés.');
    }

    public function reject(Request $request, Activity $activity): RedirectResponse
    {
        $this->ensureActivityInTenant($activity);

        $data = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $this->activityService->rejectActivity($activity, Auth::user(), $data['rejection_reason'] ?? null);

        return redirect()->route('admin.activities.index')->with('success', 'Activité refusée.');
    }

    private function ensureActivityInTenant(Activity $activity): void
    {
        $this->ensureInTenant($activity, fn (Activity $a) => $a->educator?->user_id);
    }
}
