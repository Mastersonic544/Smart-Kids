<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parents\StoreParentRequest;
use App\Http\Requests\Parents\UpdateParentRequest;
use App\Models\User;
use App\Support\PasscodeGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function index(): View
    {
        $parents = User::role('parent')
            ->where('tenant_admin_id', Auth::id())
            ->withCount('children')
            ->get();

        return view('admin.parents.index', compact('parents'));
    }

    public function create(): View
    {
        return view('admin.parents.create');
    }

    public function store(StoreParentRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $passcode = PasscodeGenerator::generate();

        $parent = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            // Password kept for legacy fallback only; parents log in by passcode.
            'password' => Hash::make(Str::random(40)),
            'passcode' => $passcode,
            'tenant_admin_id' => Auth::id(),
        ]);

        $parent->assignRole('parent');

        // Flash the passcode so the admin can write it down / hand it to the parent once.
        return redirect()
            ->route('admin.parents.index')
            ->with('success', "Parent ajouté avec succès.")
            ->with('parent_passcode', [
                'name' => $parent->name,
                'email' => $parent->email,
                'passcode' => $passcode,
            ]);
    }

    public function edit(User $parent): View
    {
        $this->ensureSameTenant($parent);

        return view('admin.parents.edit', compact('parent'));
    }

    public function update(UpdateParentRequest $request, User $parent): RedirectResponse
    {
        $this->ensureSameTenant($parent);

        $data = $request->validated();
        $parent->name = $data['name'];
        $parent->email = $data['email'];
        $parent->phone = $data['phone'] ?? null;

        if (! empty($data['password'])) {
            $parent->password = Hash::make($data['password']);
        }

        $parent->save();

        return redirect()->route('admin.parents.index')->with('success', 'Parent mis à jour avec succès.');
    }

    public function destroy(User $parent): RedirectResponse
    {
        $this->ensureSameTenant($parent);

        if ($parent->children()->count() > 0) {
            return redirect()
                ->route('admin.parents.index')
                ->with('error', 'Impossible de supprimer un parent ayant des enfants inscrits.');
        }

        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Parent supprimé avec succès.');
    }

    public function regeneratePasscode(User $parent): RedirectResponse
    {
        $this->ensureSameTenant($parent);

        $passcode = PasscodeGenerator::generate();
        $parent->update(['passcode' => $passcode]);

        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Nouveau code généré.')
            ->with('parent_passcode', [
                'name' => $parent->name,
                'email' => $parent->email,
                'passcode' => $passcode,
            ]);
    }

    private function ensureSameTenant(User $parent): void
    {
        abort_unless(
            $parent->tenant_admin_id === Auth::id() || $parent->tenant_admin_id === null,
            403,
            'Ce parent appartient à un autre établissement.'
        );
    }
}
