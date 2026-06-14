<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Helpers used by Admin\* controllers to keep one kindergarten's data invisible
 * to another. An admin's tenant_admin_id is their own user id. Parents and
 * educators have tenant_admin_id pointing at their admin.
 *
 * SuperAdmin sees everything (the scope returns false from currentTenantAdminId).
 */
trait ScopesToTenant
{
    protected function currentTenantAdminId(): ?int
    {
        $user = Auth::user();
        if (! $user || $user->hasRole('superadmin')) {
            return null;
        }

        // Admin's own id is the tenant boundary; for educators/parents it's tenant_admin_id.
        return $user->hasRole('admin') ? $user->id : $user->tenant_admin_id;
    }

    /**
     * Apply a whereHas('parent', ...) scope by tenant on a query that has a `parent` relation.
     */
    protected function scopeByParentTenant(Builder $query): Builder
    {
        $tenantId = $this->currentTenantAdminId();
        if ($tenantId === null) {
            return $query;
        }

        return $query->whereHas('parent', fn ($q) => $q->where('tenant_admin_id', $tenantId));
    }

    /**
     * For models with an educator chain: educator (Teacher) -> user -> tenant.
     */
    protected function scopeByEducatorTenant(Builder $query, string $relation = 'educator'): Builder
    {
        $tenantId = $this->currentTenantAdminId();
        if ($tenantId === null) {
            return $query;
        }

        return $query->whereHas($relation, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('tenant_admin_id', $tenantId)));
    }

    /**
     * Guard for route-model-bound entities: aborts 403 if the entity is not in the
     * current admin's tenant. $resolver is a closure returning the owning user_id
     * (parent_id for a Child/Payment, teacher.user.id for an Activity, etc).
     */
    protected function ensureInTenant(Model $entity, \Closure $ownerResolver): void
    {
        $tenantId = $this->currentTenantAdminId();
        if ($tenantId === null) {
            return; // superadmin or unauthenticated context — no filter applied
        }

        $ownerUserId = $ownerResolver($entity);
        if ($ownerUserId === null) {
            return; // Shared/global entity (e.g. weekly meal) — let it through.
        }

        $owningUser = \App\Models\User::find($ownerUserId);
        if (! $owningUser) {
            abort(404);
        }

        $ownerTenant = $owningUser->hasRole('admin') ? $owningUser->id : $owningUser->tenant_admin_id;
        abort_unless($ownerTenant === $tenantId, 403, 'Cet enregistrement appartient à un autre établissement.');
    }
}
