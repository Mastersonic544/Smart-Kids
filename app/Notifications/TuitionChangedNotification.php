<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TuitionChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ?float $oldAmount,
        public float $newAmount,
        public string $kindergartenName
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $direction = $this->oldAmount !== null && $this->newAmount > $this->oldAmount ? 'augmentation' : 'mise à jour';

        return [
            'title' => 'Frais de scolarité mis à jour',
            'message' => "{$this->kindergartenName} a effectué une {$direction} : le nouveau montant mensuel est de "
                .number_format($this->newAmount, 3, ',', ' ').' TND.',
            'old_amount' => $this->oldAmount,
            'new_amount' => $this->newAmount,
            'kindergarten' => $this->kindergartenName,
            'route' => 'parent.payments',
            'icon' => 'banknote',
        ];
    }
}
