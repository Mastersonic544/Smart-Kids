<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    /**
     * Display a listing of the parents.
     */
    public function index()
    {
        $parents = User::role('parent')->withCount('children')->get();
        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new parent.
     */
    public function create()
    {
        return view('admin.parents.create');
    }

    /**
     * Store a newly created parent in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $parent = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        
        $parent->assignRole('parent');

        return redirect()->route('admin.parents.index')->with('success', 'Parent ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified parent.
     */
    public function edit(User $parent)
    {
        return view('admin.parents.edit', compact('parent'));
    }

    /**
     * Update the specified parent in storage.
     */
    public function update(Request $request, User $parent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($parent->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $parent->name = $request->name;
        $parent->email = $request->email;
        $parent->phone = $request->phone;

        if ($request->filled('password')) {
            $parent->password = Hash::make($request->password);
        }

        $parent->save();

        return redirect()->route('admin.parents.index')->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Remove the specified parent from storage.
     */
    public function destroy(User $parent)
    {
        if ($parent->children()->count() > 0) {
            return redirect()->route('admin.parents.index')->with('error', 'Impossible de supprimer un parent ayant des enfants inscrits.');
        }

        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Parent supprimé avec succès.');
    }
}
