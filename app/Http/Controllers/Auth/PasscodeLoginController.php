<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Six-digit passcode auth for parents AND educators.
 *
 * Admins do NOT log in here — admin accounts are provisioned by the SuperAdmin
 * and authenticate via Supabase. The passcode is the sole credential, scoped
 * unique across all users; the role determines which dashboard the user lands on.
 */
class PasscodeLoginController extends Controller
{
    public function show(): View
    {
        return view('auth.passcode-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'passcode' => ['required', 'string', 'digits:6'],
        ]);

        $user = User::query()
            ->where('passcode', $data['passcode'])
            ->whereHas('roles', fn ($q) => $q->whereIn('name', ['parent', 'educateur']))
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'passcode' => 'Code invalide. Vérifiez les 6 chiffres avec votre établissement.',
            ]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
