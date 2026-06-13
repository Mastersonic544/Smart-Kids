<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notification sent when a new announcement is broadcasted.
 */
class NewAnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement_title;

    protected $announcement_body;

    /**
     * Create a new notification instance.
     *
     * @param  string  $announcement_title
     * @param  string  $announcement_body
     * @return void
     */
    public function __construct($announcement_title, $announcement_body)
    {
        $this->announcement_title = $announcement_title;
        $this->announcement_body = $announcement_body;
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
            'type' => 'announcement',
            'title' => $this->announcement_title,
            'message' => $this->announcement_body,
        ];
    }
}
