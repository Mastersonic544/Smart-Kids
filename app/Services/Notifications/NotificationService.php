<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Models\Child;
use App\Models\Payment;
use App\Notifications\AbsenceRecordedNotification;
use App\Notifications\PaymentOverdueNotification;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Service to handle notification logic across the system.
 */
class NotificationService
{
    /**
     * Notify parent of a child's absence.
     *
     * @param int $childId
     * @param string $date
     * @return void
     */
    public function notifyParentOfAbsence($childId, $date)
    {
        $child = Child::with('parent')->find($childId);
        if ($child && $child->parent) {
            $child->parent->notify(new AbsenceRecordedNotification("{$child->prenom} {$child->nom}", $date));
        }
    }

    /**
     * Notify parent of an overdue payment.
     *
     * @param int $paymentId
     * @return void
     */
    public function notifyParentOfOverduePayment($paymentId)
    {
        $payment = Payment::with('child.parent')->find($paymentId);
        if ($payment && $payment->child && $payment->child->parent) {
            $payment->child->parent->notify(new PaymentOverdueNotification($payment->montant, $payment->created_at->format('Y-m-d')));
        }
    }

    /**
     * Broadcast an announcement to all users with a specific role.
     *
     * @param string $title
     * @param string $message
     * @param string $targetRole
     * @return void
     */
    public function broadcastAnnouncement($title, $message, $targetRole)
    {
        $users = User::role($targetRole)->get();
        Notification::send($users, new NewAnnouncementNotification($title, $message));
    }

    /**
     * Get unread notifications for a user.
     *
     * @param int $userId
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function getUnreadNotifications($userId)
    {
        $user = User::find($userId);
        return $user ? $user->unreadNotifications : collect();
    }

    /**
     * Mark all notifications as read for a user.
     *
     * @param int $userId
     * @return void
     */
    public function markAllAsRead($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }
}
