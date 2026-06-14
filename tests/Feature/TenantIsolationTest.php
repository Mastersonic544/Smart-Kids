<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_admin_only_sees_parents_in_own_tenant(): void
    {
        $adminA = User::factory()->create();
        $adminA->assignRole('admin');
        $adminB = User::factory()->create();
        $adminB->assignRole('admin');

        $parentInA = User::factory()->create(['tenant_admin_id' => $adminA->id]);
        $parentInA->assignRole('parent');
        $parentInB = User::factory()->create(['tenant_admin_id' => $adminB->id]);
        $parentInB->assignRole('parent');

        $this->actingAs($adminA)
            ->get(route('admin.parents.index'))
            ->assertOk()
            ->assertSee($parentInA->name)
            ->assertDontSee($parentInB->name);
    }

    public function test_parent_cannot_pay_another_familys_bill(): void
    {
        $parentA = User::factory()->create();
        $parentA->assignRole('parent');
        $parentB = User::factory()->create();
        $parentB->assignRole('parent');

        $childOfB = Child::factory()->create(['parent_id' => $parentB->id]);
        $payment = $childOfB->payments()->create([
            'montant' => 400,
            'statut' => 'en attente',
        ]);

        $this->actingAs($parentA)
            ->post(route('parent.payments.pay', $payment))
            ->assertForbidden();
    }

    public function test_admin_a_only_sees_own_children_on_index(): void
    {
        $adminA = User::factory()->create();
        $adminA->assignRole('admin');
        $adminB = User::factory()->create();
        $adminB->assignRole('admin');

        $parentA = User::factory()->create(['tenant_admin_id' => $adminA->id]);
        $parentA->assignRole('parent');
        $parentB = User::factory()->create(['tenant_admin_id' => $adminB->id]);
        $parentB->assignRole('parent');

        Child::factory()->create(['parent_id' => $parentA->id, 'nom' => 'TENANTA']);
        Child::factory()->create(['parent_id' => $parentB->id, 'nom' => 'TENANTB']);

        $this->actingAs($adminA)
            ->get(route('admin.children.index'))
            ->assertOk()
            ->assertSee('TENANTA')
            ->assertDontSee('TENANTB');
    }

    public function test_admin_cannot_open_another_tenants_child_edit(): void
    {
        $adminA = User::factory()->create();
        $adminA->assignRole('admin');
        $adminB = User::factory()->create();
        $adminB->assignRole('admin');

        $parentB = User::factory()->create(['tenant_admin_id' => $adminB->id]);
        $parentB->assignRole('parent');
        $childB = Child::factory()->create(['parent_id' => $parentB->id]);

        $this->actingAs($adminA)
            ->get(route('admin.children.edit', $childB))
            ->assertForbidden();
    }
}
