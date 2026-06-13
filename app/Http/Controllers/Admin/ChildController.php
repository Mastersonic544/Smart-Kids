<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Children\StoreChildRequest;
use App\Http\Requests\Children\UpdateChildRequest;
use App\Models\Classroom;
use App\Models\User;
use App\Services\Children\ChildService;
// Note: Fetching related objects like Users(parents) might require a UserRepository, but for simplicity we can use Models here to populate dropdowns or pass it through another service.
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// Controller managing children registration and profiles.
class ChildController extends Controller
{
    protected ChildService $childService;

    /**
     * Inject ChildService.
     */
    public function __construct(ChildService $childService)
    {
        $this->childService = $childService;
    }

    /**
     * Display a listing of the children.
     */
    public function index(): View
    {
        $children = $this->childService->getAllChildren();

        return view('admin.children.index', compact('children'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create(): View
    {
        // Ideally this comes from a UserService or ParentService
        $parents = User::role('parent')->get();
        $classrooms = Classroom::all();

        return view('admin.children.create', compact('parents', 'classrooms'));
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(StoreChildRequest $request): RedirectResponse
    {
        $this->childService->createChild($request->validated());

        return redirect()->route('admin.children.index')->with('success', 'Enfant créé avec succès.');
    }

    /**
     * Display the specified child.
     */
    public function show(int $id): View
    {
        $child = $this->childService->getChildById($id);
        if (! $child) {
            abort(404);
        }

        return view('admin.children.show', compact('child'));
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(int $id): View
    {
        $child = $this->childService->getChildById($id);
        if (! $child) {
            abort(404);
        }
        $parents = User::role('parent')->get();
        $classrooms = Classroom::all();

        return view('admin.children.edit', compact('child', 'parents', 'classrooms'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(UpdateChildRequest $request, int $id): RedirectResponse
    {
        $this->childService->updateChild($id, $request->validated());

        return redirect()->route('admin.children.index')->with('success', 'Enfant mis à jour avec succès.');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->childService->deleteChild($id);

        return redirect()->route('admin.children.index')->with('success', 'Enfant supprimé avec succès.');
    }
}
