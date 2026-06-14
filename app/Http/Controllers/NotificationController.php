<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Controller handling notification read/unread actions.
 */
class NotificationController extends Controller
{
    /**
     * Mark a single notification as read.
     *
     * @return JsonResponse
     */
    public function markAsRead(string $id)
    {
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     *
     * @return RedirectResponse
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Toutes les notifications marquées comme lues.');
    }
}
