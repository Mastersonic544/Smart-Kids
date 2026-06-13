<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('child')->orderByDesc('created_at')->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function edit(Payment $payment): View
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $data = $request->validated();

        if ($data['statut'] === 'payé' && $payment->statut !== 'payé') {
            $data['paye_le'] = now();
        }

        $payment->update($data);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement mis à jour.');
    }
}
