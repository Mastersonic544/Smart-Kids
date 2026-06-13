<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activities\EnrollChildActivityRequest;
use App\Http\Requests\Activities\StoreActivityRequest;
use App\Http\Requests\Activities\UpdateActivityRequest;
use App\Models\Child;
use App\Models\Teacher;
use App\Services\Activities\ActivityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    protected ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(): View
    {
        $activities = $this->activityService->getAllActivities();

        return view('admin.activities.index', compact('activities'));
    }

    public function create(): View
    {
        $teachers = Teacher::all();

        return view('admin.activities.create', compact('teachers'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $this->activityService->createActivity($request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activité créée avec succès.');
    }

    public function show(int $id): View
    {
        $activity = $this->activityService->getActivityById($id);
        if (! $activity) {
            abort(404);
        }

        $report = $this->activityService->getActivityReport($id);

        // Children array for selection to enroll
        $allChildren = Child::all();

        return view('admin.activities.show', compact('activity', 'report', 'allChildren'));
    }

    public function edit(int $id): View
    {
        $activity = $this->activityService->getActivityById($id);
        if (! $activity) {
            abort(404);
        }

        $teachers = Teacher::all();

        return view('admin.activities.edit', compact('activity', 'teachers'));
    }

    public function update(UpdateActivityRequest $request, int $id): RedirectResponse
    {
        $this->activityService->updateActivity($id, $request->validated());

        return redirect()->route('admin.activities.index')->with('success', 'Activité mise à jour.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->activityService->deleteActivity($id);

        return redirect()->route('admin.activities.index')->with('success', 'Activité supprimée.');
    }

    public function enrollChild(EnrollChildActivityRequest $request, int $activityId): RedirectResponse
    {
        $this->activityService->enrollChild($activityId, $request->validated()['child_id']);

        return redirect()->route('admin.activities.show', $activityId)->with('success', 'Enfant inscrit avec succès.');
    }

    public function markAttendance(Request $request, int $activityId): RedirectResponse
    {
        $childIds = $request->input('attended_children', []);
        $this->activityService->markAttendance($activityId, $childIds);

        return redirect()->route('admin.activities.show', $activityId)->with('success', 'Présences mises à jour.');
    }
}
