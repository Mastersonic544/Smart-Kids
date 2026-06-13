<?php

namespace App\Http\Controllers\Educateur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendances\StoreAttendanceRequest;
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

    /**
     * Inject EducateurDashboardService.
     *
     * @param EducateurDashboardService $educateurService
     */
    public function __construct(EducateurDashboardService $educateurService)
    {
        $this->educateurService = $educateurService;
    }

    /**
     * Show educator dashboard with class overview.
     *
     * @return View
     */
    public function index(): View
    {
        $data = $this->educateurService->getDashboardData(auth()->user());
        return view('educateur.dashboard', $data);
    }

    /**
     * Show students in the educator's assigned classroom.
     *
     * @return View
     */
    public function students(): View
    {
        $data = $this->educateurService->getClassStudents(auth()->user());
        return view('educateur.students.index', $data);
    }

    /**
     * Show attendance management form.
     *
     * @param Request $request
     * @return View
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @return View
     */
    public function activities(): View
    {
        $data = $this->educateurService->getEducatorActivities(auth()->user());
        return view('educateur.activities.index', $data);
    }
}
