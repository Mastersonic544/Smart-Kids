<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent to parents when a payment is overdue.
 */
class PaymentOverdueNotification extends Notification
{
    use Queueable;

    protected $amount;
    protected $due_date;

    /**
     * Create a new notification instance.
     *
     * @param float $amount
     * @param string $due_date
     * @return void
     */
    public function __construct($amount, $due_date)
    {
        $this->amount = $amount;
        $this->due_date = $due_date;
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
            'type' => 'payment_overdue',
            'title' => 'Paiement en retard',
            'message' => "Un paiement de {$this->amount} DT est en retard depuis le {$this->due_date}.",
            'amount' => $this->amount,
            'due_date' => $this->due_date,
        ];
    }
}
