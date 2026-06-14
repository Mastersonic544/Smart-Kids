<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    /**
     * Inject DashboardService.
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = $this->dashboardService->getStats();

        return view('admin.dashboard', compact('stats'));
    }
}
