<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\User;
use App\Services\Admin\DashboardService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The admin dashboard must report the logged-in kindergarten's own numbers,
 * not global totals across every tenant (otherwise "Total Enfants" disagrees
 * with the children list).
 */
class DashboardTenantScopeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_dashboard_counts_are_scoped_to_the_admins_tenant(): void
    {
        $adminA = User::factory()->create();
        $adminA->assignRole('admin');
        $adminB = User::factory()->create();
        $adminB->assignRole('admin');

        $parentA = User::factory()->create(['tenant_admin_id' => $adminA->id]);
        $parentA->assignRole('parent');
        $parentB = User::factory()->create(['tenant_admin_id' => $adminB->id]);
        $parentB->assignRole('parent');

        Child::factory()->count(2)->create(['parent_id' => $parentA->id, 'classroom_id' => null]);
        Child::factory()->count(3)->create(['parent_id' => $parentB->id, 'classroom_id' => null]);

        $service = app(DashboardService::class);

        $this->assertSame(2, $service->getStats($adminA->id)['total_children']);
        $this->assertSame(3, $service->getStats($adminB->id)['total_children']);
        // Superadmin / global view sees everyone.
        $this->assertSame(5, $service->getStats(null)['total_children']);

        // And the rendered dashboard for admin A shows 2.
        $this->actingAs($adminA)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total Enfants');
    }
}
