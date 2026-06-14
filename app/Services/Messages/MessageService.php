<?php

namespace App\Services\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class MessageService
{
    public function getInbox(int $userId): SupportCollection
    {
        return Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn (Message $m) => $m->sender_id === $userId ? $m->receiver_id : $m->sender_id)
            ->map(fn (SupportCollection $conversation) => $conversation->first());
    }

    public function getConversation(int $userId, int $otherUserId): Collection
    {
        return Message::where(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
        })->orWhere(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
        })->with('sender')->orderBy('created_at')->get();
    }

    public function sendMessage(int $senderId, int $receiverId, string $body): Message
    {
        return Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $body,
        ]);
    }

    public function markConversationAsRead(int $currentUserId, int $otherUserId): void
    {
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function getNewMessages(int $userId, int $otherUserId, int $afterId): Collection
    {
        return Message::where('id', '>', $afterId)
            ->where(function ($q) use ($userId, $otherUserId) {
                $q->where(function ($inner) use ($userId, $otherUserId) {
                    $inner->where('sender_id', $userId)->where('receiver_id', $otherUserId);
                })->orWhere(function ($inner) use ($userId, $otherUserId) {
                    $inner->where('sender_id', $otherUserId)->where('receiver_id', $userId);
                });
            })
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Build a contact list ordered per the SmartKids spec:
     *
     *   1. SmartKids system account (if exists)
     *   2. Tenant admin (always at the top of the human contacts)
     *   3. Educators in this tenant (or parents, if the current user is an educator)
     *   4. Other parents in this tenant (if the current user is a parent)
     *
     * Tenancy is determined by the current user's tenant_admin_id (parents/educators)
     * or by their own id (admins).
     */
    public function getContactableUsers(User $user): SupportCollection
    {
        $tenantAdminId = $user->hasRole('admin') ? $user->id : $user->tenant_admin_id;

        $contacts = collect();

        // 1. System account
        $system = User::where('is_system', true)->first();
        if ($system) {
            $contacts->push($system);
        }

        if ($tenantAdminId === null) {
            // No tenant scope known (e.g. superadmin) — fall back to all non-self users.
            return $contacts->merge(
                User::where('id', '!=', $user->id)
                    ->where('is_system', false)
                    ->orderBy('name')
                    ->get()
            )->unique('id')->values();
        }

        // 2. The tenant admin (skip if I am the admin)
        if (! $user->hasRole('admin')) {
            $admin = User::find($tenantAdminId);
            if ($admin && $admin->id !== $user->id) {
                $contacts->push($admin);
            }
        }

        // 3+4. Other tenant members, ordered: educateurs first, then parents
        $others = User::where('id', '!=', $user->id)
            ->where('is_system', false)
            ->where(function ($q) use ($tenantAdminId) {
                $q->where('tenant_admin_id', $tenantAdminId)
                    ->orWhere('id', $tenantAdminId);
            })
            ->whereDoesntHave('roles', fn ($q) => $q->where('name', 'admin'))
            ->with('roles')
            ->orderBy('name')
            ->get()
            ->sortBy(fn (User $u) => $u->hasRole('educateur') ? 0 : 1)
            ->values();

        return $contacts->merge($others)->unique('id')->values();
    }

    public function searchUsers(User $currentUser, string $query): SupportCollection
    {
        return $this->getContactableUsers($currentUser)
            ->filter(fn (User $u) => str_contains(strtolower($u->name), strtolower($query)))
            ->take(10)
            ->values()
            ->map(fn (User $u) => [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'is_system' => (bool) $u->is_system,
            ]);
    }

    public function getUnreadCount(int $userId): int
    {
        return Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
