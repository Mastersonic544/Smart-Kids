<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Blocks write actions for users whose tenant admin failed to pay the SaaS
 * subscription. SuperAdmin and admin's own /admin/subscription routes are
 * exempt so the admin can settle their bill and lift the freeze.
 */
class EnsureNotFrozen
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isFrozen()) {
            return $next($request);
        }

        // SuperAdmin can always operate.
        if ($user->hasRole('superadmin')) {
            return $next($request);
        }

        // Admin can still reach the subscription self-service to unfreeze themselves.
        if ($user->hasRole('admin') && $request->routeIs('admin.subscription.*')) {
            return $next($request);
        }

        // Read-only verbs are tolerated so the user can still browse data.
        if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $next($request);
        }

        abort(423, 'Compte gelé. L\'établissement doit régler son abonnement SmartKids pour réactiver les modifications.');
    }
}
