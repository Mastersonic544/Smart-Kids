<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ActivityApprovedNotification extends Notification
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
            'title' => 'Nouvelle activité approuvée',
            'message' => "L'activité « {$this->activity->name} » est confirmée pour le "
                .$this->activity->scheduled_date->translatedFormat('d F Y').'.',
            'activity_id' => $this->activity->id,
            'route' => 'parent.activities',
            'icon' => 'calendar',
        ];
    }
}
