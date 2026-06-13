<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Activity $activity) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Activité refusée',
            'message' => "Votre proposition « {$this->activity->name} » a été refusée."
                .($this->activity->rejection_reason ? ' Motif: '.$this->activity->rejection_reason : ''),
            'activity_id' => $this->activity->id,
            'route' => 'educateur.activities',
            'icon' => 'x-circle',
        ];
    }
}
