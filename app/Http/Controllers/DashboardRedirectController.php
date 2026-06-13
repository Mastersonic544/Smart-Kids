<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardRedirectController extends Controller
{
    public function __invoke(): RedirectResponse|View
    {
        $user = Auth::user();

        return match (true) {
            $user->hasRole('admin') => redirect()->route('admin.dashboard'),
            $user->hasRole('educateur') => redirect()->route('educateur.dashboard'),
            $user->hasRole('parent') => redirect()->route('parent.dashboard'),
            default => view('dashboard'),
        };
    }
}
