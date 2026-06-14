<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Support\PasscodeGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * SuperAdmin provisioning of new kindergarten admin tenants.
 *
 * Admin accounts authenticate via Supabase in production; the seeded email +
 * temporary password here are for local dev only. The created admin row also
 * receives a fresh subscription_due_at = +30 days (default monthly plan).
 */
class SuperadminAdminController extends Controller
{
    public function index(): View
    {
        $admins = User::role('admin')
            ->withCount([
                'tenantMembers as parents_count' => fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'parent')),
                'tenantMembers as educators_count' => fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'educateur')),
            ])
            ->orderBy('name')
            ->get();

        return view('superadmin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'billing_period' => ['required', Rule::in(['monthly', 'annual'])],
            'monthly_tuition_tnd' => ['nullable', 'numeric', 'min:0'],
        ]);

        $tempPassword = Str::random(12);

        $admin = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($tempPassword),
            'passcode' => PasscodeGenerator::generate(),
            'monthly_tuition_tnd' => $data['monthly_tuition_tnd'] ?? null,
            'subscription_status' => 'active',
            'billing_period' => $data['billing_period'],
            'subscription_started_at' => now(),
            'subscription_due_at' => $data['billing_period'] === 'annual'
                ? now()->addYear()
                : now()->addMonth(),
        ]);
        $admin->assignRole('admin');

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', 'Administrateur créé. Communiquez le mot de passe temporaire.')
            ->with('temp_password', [
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $tempPassword,
            ]);
    }

    public function destroy(User $admin): RedirectResponse
    {
        abort_unless($admin->hasRole('admin'), 422, 'Cet utilisateur n\'est pas un administrateur.');

        $admin->delete();

        return redirect()->route('superadmin.admins.index')->with('success', 'Administrateur supprimé.');
    }

    /**
     * Reveal the 6-digit passcodes for every parent and educator under a given
     * kindergarten admin. Used by the SaaS support team to recover credentials
     * when a parent/educator loses their code.
     */
    public function codes(User $admin): View
    {
        abort_unless($admin->hasRole('admin'), 422, 'Cet utilisateur n\'est pas un administrateur.');

        // Backfill the admin's own 6-digit code if one was never minted
        // (admins created before this feature existed don't have one yet).
        if (empty($admin->passcode)) {
            $admin->forceFill(['passcode' => PasscodeGenerator::generate()])->save();
        }

        $parents = User::role('parent')
            ->where('tenant_admin_id', $admin->id)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone', 'passcode']);

        $educators = User::role('educateur')
            ->where('tenant_admin_id', $admin->id)
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone', 'passcode']);

        return view('superadmin.admins.codes', compact('admin', 'parents', 'educators'));
    }
}
