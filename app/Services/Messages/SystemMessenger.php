<?php

namespace App\Services\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Sends DMs from the "SmartKids" system account.
 *
 * Notifications written via Notifiable::notify() land in the bell dropdown
 * (database channel). The same message is mirrored as an actual DM here so
 * the parent / educator sees it in their messaging tab as a thread from the
 * SmartKids logo — per the vision spec.
 */
class SystemMessenger
{
    public function systemUser(): ?User
    {
        return User::where('is_system', true)->first();
    }

    public function send(User $recipient, string $body): ?Message
    {
        $system = $this->systemUser();
        if (! $system) {
            return null;
        }

        return Message::create([
            'sender_id' => $system->id,
            'receiver_id' => $recipient->id,
            'body' => $body,
        ]);
    }

    public function broadcast(Collection $recipients, string $body): void
    {
        $system = $this->systemUser();
        if (! $system || $recipients->isEmpty()) {
            return;
        }

        $now = now();
        $rows = $recipients->map(fn (User $r) => [
            'sender_id' => $system->id,
            'receiver_id' => $r->id,
            'body' => $body,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        Message::insert($rows);
    }
}
