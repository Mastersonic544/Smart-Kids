<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Represents an authenticated user (SuperAdmin, Admin, Educator, Parent, or System).
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'passcode',
        'is_system',
        'monthly_tuition_tnd',
        'tenant_admin_id',
        'subscription_status',
        'billing_period',
        'subscription_started_at',
        'subscription_due_at',
        'frozen_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'passcode',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_system' => 'boolean',
            'monthly_tuition_tnd' => 'decimal:3',
            'subscription_started_at' => 'datetime',
            'subscription_due_at' => 'datetime',
            'frozen_at' => 'datetime',
        ];
    }

    /**
     * True when this user (or its tenant admin) is currently frozen because the
     * admin failed to pay the SaaS subscription on time. Frozen accounts cannot
     * write — see EnsureNotFrozen middleware.
     */
    public function isFrozen(): bool
    {
        if ($this->subscription_status === 'frozen') {
            return true;
        }

        if ($this->tenant_admin_id !== null) {
            return self::where('id', $this->tenant_admin_id)
                ->where('subscription_status', 'frozen')
                ->exists();
        }

        return false;
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * The admin who owns this user (SaaS tenant scope).
     * NULL for SuperAdmin, Admin, and System accounts.
     */
    public function tenantAdmin(): BelongsTo
    {
        return $this->belongsTo(self::class, 'tenant_admin_id');
    }

    /**
     * All users that belong to this admin's tenant (parents + educators).
     */
    public function tenantMembers(): HasMany
    {
        return $this->hasMany(self::class, 'tenant_admin_id');
    }
}
