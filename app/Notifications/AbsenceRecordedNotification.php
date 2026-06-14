<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notification sent to parents when a child's absence is recorded.
 */
class AbsenceRecordedNotification extends Notification
{
    use Queueable;

    protected $child_name;

    protected $date;

    /**
     * Create a new notification instance.
     *
     * @param  string  $child_name
     * @param  string  $date
     * @return void
     */
    public function __construct($child_name, $date)
    {
        $this->child_name = $child_name;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'absence',
            'title' => 'Absence enregistrée',
            'message' => "L'absence de {$this->child_name} a été enregistrée le {$this->date}.",
            'child_name' => $this->child_name,
            'date' => $this->date,
        ];
    }
}
