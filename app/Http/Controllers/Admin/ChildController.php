<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\ScopesToTenant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Children\StoreChildRequest;
use App\Http\Requests\Children\UpdateChildRequest;
use App\Models\Child;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChildController extends Controller
{
    use ScopesToTenant;

    public function index(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $children = Child::query()
            ->with(['parent', 'classroom'])
            ->when($tenantId, fn ($q) => $q->whereHas('parent', fn ($p) => $p->where('tenant_admin_id', $tenantId)))
            ->get();

        return view('admin.children.index', compact('children'));
    }

    public function create(): View
    {
        $tenantId = $this->currentTenantAdminId();

        $parents = User::role('parent')
            ->when($tenantId, fn ($q) => $q->where('tenant_admin_id', $tenantId))
            ->get();
        $classrooms = $this->tenantClassrooms($tenantId);

        return view('admin.children.create', compact('parents', 'classrooms'));
    }

    public function store(StoreChildRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->ensureParentInTenant((int) $data['parent_id']);

        Child::create($data);

        return redirect()->route('admin.children.index')->with('success', 'Enfant créé avec succès.');
    }

    public function show(int $id): View
    {
        $child = Child::with(['parent', 'classroom', 'activities', 'attendances'])->findOrFail($id);
        $this->ensureInTenant($child, fn (Child $c) => $c->parent_id);

        return view('admin.children.show', compact('child'));
    }

    public function edit(int $id): View
    {
        $child = Child::findOrFail($id);
        $this->ensureInTenant($child, fn (Child $c) => $c->parent_id);

        $tenantId = $this->currentTenantAdminId();
        $parents = User::role('parent')
            ->when($tenantId, fn ($q) => $q->where('tenant_admin_id', $tenantId))
            ->get();
        $classrooms = $this->tenantClassrooms($tenantId);

        return view('admin.children.edit', compact('child', 'parents', 'classrooms'));
    }

    public function update(UpdateChildRequest $request, int $id): RedirectResponse
    {
        $child = Child::findOrFail($id);
        $this->ensureInTenant($child, fn (Child $c) => $c->parent_id);

        $data = $request->validated();
        $this->ensureParentInTenant((int) $data['parent_id']);

        $child->update($data);

        return redirect()->route('admin.children.index')->with('success', 'Enfant mis à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $child = Child::findOrFail($id);
        $this->ensureInTenant($child, fn (Child $c) => $c->parent_id);

        $child->delete();

        return redirect()->route('admin.children.index')->with('success', 'Enfant supprimé avec succès.');
    }

    private function tenantClassrooms(?int $tenantId)
    {
        return Classroom::query()
            ->when($tenantId, fn ($q) => $q->whereHas('teacher.user', fn ($u) => $u->where('tenant_admin_id', $tenantId)))
            ->get();
    }

    private function ensureParentInTenant(int $parentId): void
    {
        $tenantId = $this->currentTenantAdminId();
        if ($tenantId === null) {
            return;
        }
        $parent = User::find($parentId);
        abort_unless($parent && $parent->tenant_admin_id === $tenantId, 403, 'Ce parent appartient à un autre établissement.');
    }
}
