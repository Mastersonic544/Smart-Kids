<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Controller for managing Payments from Admin portal.
 */
class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('child')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en attente,payé',
        ]);

        if ($validated['statut'] === 'payé' && $payment->statut !== 'payé') {
            $validated['paye_le'] = now();
        }

        $payment->update($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Paiement mis à jour.');
    }
}
