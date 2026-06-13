<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Notifications\TuitionChangedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Detect a tuition change BEFORE saving so we can broadcast.
        $oldTuition = $user->monthly_tuition_tnd ? (float) $user->monthly_tuition_tnd : null;
        $newTuition = array_key_exists('monthly_tuition_tnd', $validated) && $validated['monthly_tuition_tnd'] !== null
            ? (float) $validated['monthly_tuition_tnd']
            : $oldTuition;
        $tuitionChanged = $user->hasRole('admin')
            && $newTuition !== null
            && $oldTuition !== $newTuition;

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($tuitionChanged) {
            $parents = User::role('parent')
                ->where('tenant_admin_id', $user->id)
                ->get();
            if ($parents->isNotEmpty()) {
                Notification::send($parents, new TuitionChangedNotification(
                    oldAmount: $oldTuition,
                    newAmount: $newTuition,
                    kindergartenName: $user->name,
                ));
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
