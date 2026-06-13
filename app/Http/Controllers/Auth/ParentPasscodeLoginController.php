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
 * Lightweight passcode auth for parents.
 *
 * Parents do NOT pick their own password; the admin mints a 6-digit
 * memorable passcode at creation time. They sign in here with that
 * passcode (no email needed — the passcode is the credential, scoped
 * unique across users).
 */
class ParentPasscodeLoginController extends Controller
{
    public function show(): View
    {
        return view('auth.parent-passcode-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'passcode' => ['required', 'string', 'digits:6'],
        ]);

        $parent = User::role('parent')
            ->where('passcode', $data['passcode'])
            ->first();

        if (! $parent) {
            throw ValidationException::withMessages([
                'passcode' => 'Code invalide. Vérifiez les 6 chiffres avec votre établissement.',
            ]);
        }

        Auth::login($parent, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('parent.dashboard'));
    }
}
