<?php

namespace App\Enums;

enum ActivityStatus: string
{
    case PendingApproval = 'pending_approval';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PendingApproval => 'En attente d\'approbation',
            self::Approved => 'Approuvée',
            self::Rejected => 'Rejetée',
            self::Completed => 'Terminée',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PendingApproval => 'amber',
            self::Approved => 'teal',
            self::Rejected => 'rose',
            self::Completed => 'indigo',
        };
    }
}
