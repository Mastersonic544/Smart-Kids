<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'parent']);
    }

    public function view(User $user, Payment $payment): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('parent')) {
            return $payment->child?->parent_id === $user->id;
        }

        return false;
    }

    public function update(User $user, Payment $payment): bool
    {
        return $user->hasRole('admin');
    }

    public function pay(User $user, Payment $payment): bool
    {
        return $user->hasRole('parent')
            && $payment->child?->parent_id === $user->id
            && $payment->statut !== 'payé';
    }
}
