<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionDueSoonNotification extends Notification
{
    use Queueable;

    public function __construct(public Carbon $dueAt, public float $amount) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Abonnement SmartKids à renouveler',
            'message' => 'Votre abonnement expire le '.$this->dueAt->translatedFormat('d F Y')
                .' ('.number_format($this->amount, 0, ',', ' ').' TND). Réglez sous 7 jours pour éviter le gel du compte.',
            'route' => 'admin.subscription.show',
            'icon' => 'clock',
        ];
    }
}
