<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Guards the MySQL->Postgres portability fix: an unselected "Classe" dropdown
 * posts classroom_id='', which Postgres rejects for a bigint column. The form
 * request must coerce it to null so the child is created on any database.
 */
class ChildClassroomNullableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_child_is_created_when_classroom_left_blank(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $parent = User::factory()->create(['tenant_admin_id' => $admin->id]);
        $parent->assignRole('parent');

        $this->actingAs($admin)
            ->post(route('admin.children.store'), [
                'nom' => 'Blankroom',
                'prenom' => 'Kid',
                'date_naissance' => '2021-01-01',
                'parent_id' => $parent->id,
                'classroom_id' => '', // unselected dropdown
            ])
            ->assertRedirect(route('admin.children.index'))
            ->assertSessionHasNoErrors();

        $child = Child::where('nom', 'Blankroom')->first();
        $this->assertNotNull($child, 'Child should be created even with no classroom');
        $this->assertNull($child->classroom_id, 'Blank classroom_id must persist as null, not ""');
    }
}
