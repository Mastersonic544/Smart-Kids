<?php

namespace App\Console\Commands;

use App\Models\SaasPayment;
use App\Models\User;
use App\Notifications\SubscriptionDueSoonNotification;
use App\Services\Messages\SystemMessenger;
use App\Support\SubscriptionPlan;
use Illuminate\Console\Command;

/**
 * Runs daily (kernel-scheduled in prod) to:
 *  - notify admins whose subscription is due within 7 days,
 *  - freeze admins whose subscription_due_at lapsed without payment,
 *  - mark related SaasPayment rows as overdue.
 *
 * Idempotent — safe to invoke manually.
 */
class ProcessSubscriptionLifecycle extends Command
{
    protected $signature = 'subscriptions:process';

    protected $description = 'Notify due-soon admins, freeze overdue tenants, mark SaaS payments overdue';

    public function handle(SystemMessenger $messenger): int
    {
        $now = now();

        // 1. Due within 7 days: send notification + SmartKids DM (once per due_at)
        $dueSoon = User::role('admin')
            ->where('subscription_status', 'active')
            ->whereBetween('subscription_due_at', [$now, $now->copy()->addDays(7)])
            ->get();

        foreach ($dueSoon as $admin) {
            $amount = SubscriptionPlan::priceFor($admin->billing_period ?? 'monthly');
            $admin->notify(new SubscriptionDueSoonNotification($admin->subscription_due_at, $amount));
            $messenger->send(
                $admin,
                "Rappel : votre abonnement SmartKids ({$admin->billing_period}) expire le "
                    .$admin->subscription_due_at->translatedFormat('d F Y').'. Réglez pour éviter le gel.'
            );
        }

        // 2. Already past due_at: freeze + mark related payments overdue
        $overdue = User::role('admin')
            ->where('subscription_status', '!=', 'frozen')
            ->whereNotNull('subscription_due_at')
            ->where('subscription_due_at', '<', $now)
            ->get();

        foreach ($overdue as $admin) {
            $admin->update([
                'subscription_status' => 'frozen',
                'frozen_at' => $now,
            ]);
            SaasPayment::where('admin_id', $admin->id)
                ->where('status', 'pending')
                ->update(['status' => 'overdue']);
            $messenger->send(
                $admin,
                'Compte gelé : l\'abonnement SmartKids n\'a pas été réglé à temps. Aucune écriture n\'est possible jusqu\'au paiement.'
            );
        }

        $this->info("Notified {$dueSoon->count()} due-soon admin(s); froze {$overdue->count()} overdue admin(s).");

        return self::SUCCESS;
    }
}
