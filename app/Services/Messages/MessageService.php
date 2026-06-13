<?php

namespace App\Services\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Service to handle Messenger-clone messaging logic.
 */
class MessageService
{
    /**
     * Get all conversations for a user (inbox), with latest message per contact.
     *
     * @param  int  $userId
     * @return Collection
     */
    public function getInbox($userId)
    {
        return Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($conversation) {
                return $conversation->first();
            });
    }

    /**
     * Get the conversation between two users.
     *
     * @param  int  $userId
     * @param  int  $otherUserId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConversation($userId, $otherUserId)
    {
        return Message::where(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $userId)->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($userId, $otherUserId) {
            $query->where('sender_id', $otherUserId)->where('receiver_id', $userId);
        })->with(['sender'])->orderBy('created_at', 'asc')->get();
    }

    /**
     * Send a message from one user to another.
     *
     * @param  int  $senderId
     * @param  int  $receiverId
     * @param  string  $body
     * @return Message
     */
    public function sendMessage($senderId, $receiverId, $body)
    {
        return Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $body,
        ]);
    }

    /**
     * Mark all messages from a user as read.
     */
    public function markConversationAsRead(int $currentUserId, int $otherUserId): void
    {
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Get new messages after a given message ID (for polling).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNewMessages(int $userId, int $otherUserId, int $afterId)
    {
        return Message::where('id', '>', $afterId)
            ->where(function ($query) use ($userId, $otherUserId) {
                $query->where(function ($q) use ($userId, $otherUserId) {
                    $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
                })->orWhere(function ($q) use ($userId, $otherUserId) {
                    $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
                });
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get users that the current user can message (role-aware).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getContactableUsers(User $user)
    {
        return User::where('id', '!=', $user->id)->orderBy('name')->get();
    }

    /**
     * Search users by name for conversation picker.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchUsers(User $currentUser, string $query)
    {
        return User::where('id', '!=', $currentUser->id)
            ->where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();
    }

    /**
     * Get unread message count for a user.
     */
    public function getUnreadCount(int $userId): int
    {
        return Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
