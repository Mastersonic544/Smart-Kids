<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaasPayment;
use App\Support\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Admin self-service for the SaaS subscription.
 *
 * No payment gateway — the "pay" action just records a paid SaasPayment row
 * and pushes subscription_due_at forward by one cycle. The plan is hardcoded
 * via SubscriptionPlan support class.
 */
class SubscriptionController extends Controller
{
    public function show(): View
    {
        $admin = Auth::user();
        $receipts = SaasPayment::where('admin_id', $admin->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.subscription.show', [
            'admin' => $admin,
            'plan' => [
                'name' => SubscriptionPlan::NAME,
                'monthly_price' => SubscriptionPlan::MONTHLY_PRICE_TND,
                'annual_price' => SubscriptionPlan::annualPrice(),
                'annual_discount' => SubscriptionPlan::ANNUAL_DISCOUNT_RATIO * 100,
            ],
            'receipts' => $receipts,
        ]);
    }

    public function pay(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'billing_period' => ['required', Rule::in(['monthly', 'annual'])],
        ]);

        $admin = Auth::user();
        $price = SubscriptionPlan::priceFor($data['billing_period']);

        $start = $admin->subscription_due_at && $admin->subscription_due_at->isFuture()
            ? Carbon::parse($admin->subscription_due_at)
            : Carbon::now();
        $end = $data['billing_period'] === 'annual' ? (clone $start)->addYear() : (clone $start)->addMonth();

        SaasPayment::create([
            'admin_id' => $admin->id,
            'amount_tnd' => $price,
            'period' => $data['billing_period'],
            'period_start' => $start->toDateString(),
            'period_end' => $end->toDateString(),
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $admin->update([
            'billing_period' => $data['billing_period'],
            'subscription_status' => 'active',
            'subscription_started_at' => $admin->subscription_started_at ?? now(),
            'subscription_due_at' => $end,
            'frozen_at' => null,
        ]);

        return redirect()
            ->route('admin.subscription.show')
            ->with('success', 'Paiement enregistré. Échéance prolongée au '.$end->format('d M Y').'.');
    }
}
