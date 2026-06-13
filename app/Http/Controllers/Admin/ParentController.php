<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parents\StoreParentRequest;
use App\Http\Requests\Parents\UpdateParentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function index(): View
    {
        $parents = User::role('parent')->withCount('children')->get();

        return view('admin.parents.index', compact('parents'));
    }

    public function create(): View
    {
        return view('admin.parents.create');
    }

    public function store(StoreParentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $parent = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        $parent->assignRole('parent');

        return redirect()->route('admin.parents.index')->with('success', 'Parent ajouté avec succès.');
    }

    public function edit(User $parent): View
    {
        return view('admin.parents.edit', compact('parent'));
    }

    public function update(UpdateParentRequest $request, User $parent): RedirectResponse
    {
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
        if ($parent->children()->count() > 0) {
            return redirect()
                ->route('admin.parents.index')
                ->with('error', 'Impossible de supprimer un parent ayant des enfants inscrits.');
        }

        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Parent supprimé avec succès.');
    }
}
