<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SaasPayment;
use App\Models\User;
use App\Support\SubscriptionPlan;
use Illuminate\View\View;

class SuperadminDashboardController extends Controller
{
    public function index(): View
    {
        // Per-role counts (excluding the system account)
        $userCounts = [
            'superadmin' => User::role('superadmin')->count(),
            'admin' => User::role('admin')->count(),
            'educateur' => User::role('educateur')->count(),
            'parent' => User::role('parent')->count(),
        ];

        // Active = subscription_status='active' and due in the future
        $activeAdminsCount = User::role('admin')
            ->where('subscription_status', 'active')
            ->where(function ($q) {
                $q->whereNull('subscription_due_at')->orWhere('subscription_due_at', '>=', now());
            })
            ->count();

        $frozenAdminsCount = User::role('admin')
            ->where('subscription_status', 'frozen')
            ->count();

        // Cumulative paid revenue (TND)
        $totalRevenue = (float) SaasPayment::where('status', 'paid')->sum('amount_tnd');

        // MRR estimate: active admins × current monthly plan price
        $mrrEstimate = $activeAdminsCount * SubscriptionPlan::MONTHLY_PRICE_TND;

        // Top kindergartens by parent count + tuition
        $topKindergartens = User::role('admin')
            ->withCount([
                'tenantMembers as parents_count' => fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'parent')),
                'tenantMembers as educators_count' => fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'educateur')),
            ])
            ->orderByDesc('parents_count')
            ->limit(10)
            ->get();

        return view('superadmin.dashboard', [
            'userCounts' => $userCounts,
            'activeAdminsCount' => $activeAdminsCount,
            'frozenAdminsCount' => $frozenAdminsCount,
            'totalRevenue' => $totalRevenue,
            'mrrEstimate' => $mrrEstimate,
            'topKindergartens' => $topKindergartens,
            'plan' => [
                'name' => SubscriptionPlan::NAME,
                'monthly_price' => SubscriptionPlan::MONTHLY_PRICE_TND,
                'annual_price' => SubscriptionPlan::annualPrice(),
                'annual_discount' => SubscriptionPlan::ANNUAL_DISCOUNT_RATIO * 100,
            ],
        ]);
    }
}
