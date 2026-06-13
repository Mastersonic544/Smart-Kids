<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Parent\ParentDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller managing the parent portal and child overview.
 */
class ParentDashboardController extends Controller
{
    protected ParentDashboardService $parentDashboardService;

    public function __construct(ParentDashboardService $parentDashboardService)
    {
        $this->parentDashboardService = $parentDashboardService;
    }

    /**
     * Show parent dashboard with children summary.
     *
     * @return View
     */
    public function index(): View
    {
        $dashboardData = $this->parentDashboardService->getDashboardSummary(auth()->id());
        $currentMenu = $this->parentDashboardService->getCurrentMenu();

        return view('parent.dashboard', compact('dashboardData', 'currentMenu'));
    }

    /**
     * Show weekly meals menu.
     *
     * @return View
     */
    public function meals(): View
    {
        $meal = $this->parentDashboardService->getCurrentMenu();
        return view('parent.meals.index', compact('meal'));
    }

    /**
     * Show payment history for parent's children.
     *
     * @return View
     */
    public function payments(): View
    {
        $user = auth()->user();
        $children = $this->parentDashboardService->getChildData($user->id);

        $paymentsByChild = [];
        foreach ($children as $child) {
            $paymentsByChild[$child->id] = [
                'child' => $child,
                'payments' => $this->parentDashboardService->getPaymentHistory($child->id)
            ];
        }

        return view('parent.payments.index', compact('paymentsByChild'));
    }

    /**
     * Process a simulated payment.
     *
     * @param Request $request
     * @param Payment $payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payNow(Request $request, Payment $payment)
    {
        // Verify the payment belongs to one of the parent's children
        $childIds = auth()->user()->children()->pluck('id');
        if (!$childIds->contains($payment->child_id)) {
            abort(403);
        }

        $this->parentDashboardService->processPayment($payment);

        return redirect()->route('parent.payments')
            ->with('success', 'Paiement effectué avec succès !');
    }

    /**
     * Show children's activities.
     *
     * @return View
     */
    public function activities(): View
    {
        $children = $this->parentDashboardService->getChildData(auth()->id());
        $activitiesByChild = [];

        foreach ($children as $child) {
            $activitiesByChild[$child->id] = [
                'child' => $child,
                'activities' => $this->parentDashboardService->getChildActivities($child->id),
            ];
        }

        return view('parent.activities.index', compact('activitiesByChild'));
    }

    /**
     * Show children's teachers.
     *
     * @return View
     */
    public function teachers(): View
    {
        $children = $this->parentDashboardService->getChildData(auth()->id());
        $teachersByChild = [];

        foreach ($children as $child) {
            $teachersByChild[$child->id] = [
                'child' => $child,
                'teacher' => $this->parentDashboardService->getChildTeacher($child),
            ];
        }

        return view('parent.teachers.index', compact('teachersByChild'));
    }
}
