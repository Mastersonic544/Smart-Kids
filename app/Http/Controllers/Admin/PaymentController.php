<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    use ScopesToTenant;

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $payments = Payment::query()
            ->with('child.parent')
            ->when($tenantId, fn ($q) => $q->whereHas('child.parent', fn ($p) => $p->where('tenant_admin_id', $tenantId)))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function edit(Payment $payment): View
    {
        $this->ensurePaymentInTenant($payment);

        return view('admin.payments.edit', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $this->ensurePaymentInTenant($payment);
        $data = $request->validated();

        if ($data['statut'] === 'payé' && $payment->statut !== 'payé') {
            $data['paye_le'] = now();
        }

        $payment->update($data);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement mis à jour.');
    }

    private function ensurePaymentInTenant(Payment $payment): void
    {
        $this->ensureInTenant($payment, fn (Payment $p) => $p->child?->parent_id);
    }
}
