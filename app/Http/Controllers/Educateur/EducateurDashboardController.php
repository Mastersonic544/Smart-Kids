<?php

namespace App\Http\Controllers\Educateur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activities\RequestActivityRequest;
use App\Http\Requests\Attendances\StoreAttendanceRequest;
use App\Services\Activities\ActivityService;
use App\Services\Educateur\EducateurDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller managing the educator portal: dashboard, students, attendance, activities.
 */
class EducateurDashboardController extends Controller
{
    protected EducateurDashboardService $educateurService;

    protected ActivityService $activityService;

    public function __construct(EducateurDashboardService $educateurService, ActivityService $activityService)
    {
        $this->educateurService = $educateurService;
        $this->activityService = $activityService;
    }

    /**
     * Show educator dashboard with class overview.
     */
    public function index(): View
    {
        $data = $this->educateurService->getDashboardData(auth()->user());

        return view('educateur.dashboard', $data);
    }

    /**
     * Show students in the educator's assigned classroom.
     */
    public function students(): View
    {
        $data = $this->educateurService->getClassStudents(auth()->user());

        return view('educateur.students.index', $data);
    }

    /**
     * Show attendance management form.
     */
    public function attendance(Request $request): View
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $data = $this->educateurService->getAttendanceForDate(auth()->user(), $date);

        return view('educateur.attendance.index', $data);
    }

    /**
     * Store attendance records for a given day.
     *
     * @param  Request  $request
     */
    public function storeAttendance(StoreAttendanceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->educateurService->saveAttendance($data['date'], $data['attendance']);

        return redirect()->route('educateur.attendance', ['date' => $data['date']])
            ->with('success', 'Présences enregistrées avec succès !');
    }

    /**
     * Show activities managed by this educator.
     */
    public function activities(): View
    {
        $data = $this->educateurService->getEducatorActivities(auth()->user());

        return view('educateur.activities.index', $data);
    }

    public function requestActivityForm(): View
    {
        return view('educateur.activities.request');
    }

    public function submitActivityRequest(RequestActivityRequest $request): RedirectResponse
    {
        $this->activityService->requestActivity(auth()->user(), $request->validated());

        return redirect()
            ->route('educateur.activities')
            ->with('success', 'Demande d\'activité envoyée à l\'administration pour approbation.');
    }
}
