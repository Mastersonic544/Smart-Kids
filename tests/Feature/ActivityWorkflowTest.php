<?php

namespace Tests\Feature;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\Child;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\ActivityApprovedNotification;
use App\Notifications\ActivityRejectedNotification;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ActivityWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_educator_can_request_activity_in_pending_approval(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $educator = User::factory()->create(['tenant_admin_id' => $admin->id]);
        $educator->assignRole('educateur');

        Teacher::create([
            'user_id' => $educator->id,
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'email' => $educator->email,
        ]);

        $this->actingAs($educator)
            ->post(route('educateur.activities.requestSubmit'), [
                'name' => 'Sortie aquarium',
                'description' => 'Visite éducative',
                'scheduled_date' => now()->addDays(10)->toDateString(),
                'scheduled_time' => '10:00',
                'max_participants' => 20,
            ])
            ->assertRedirect(route('educateur.activities'));

        $this->assertDatabaseHas('activities', [
            'name' => 'Sortie aquarium',
            'status' => ActivityStatus::PendingApproval->value,
            'requested_by' => $educator->id,
        ]);
    }

    public function test_admin_approves_activity_and_notifies_enrolled_parents(): void
    {
        Notification::fake();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $parent = User::factory()->create(['tenant_admin_id' => $admin->id]);
        $parent->assignRole('parent');

        $child = Child::factory()->create(['parent_id' => $parent->id]);

        $activity = Activity::create([
            'name' => 'Atelier peinture',
            'scheduled_date' => now()->addDays(3),
            'scheduled_time' => '14:00',
            'educator_id' => Teacher::factory()->create()->id,
            'status' => ActivityStatus::PendingApproval->value,
            'max_participants' => 20,
        ]);
        $activity->children()->attach($child->id);

        $this->actingAs($admin)
            ->post(route('admin.activities.approve', $activity))
            ->assertRedirect(route('admin.activities.index'));

        $activity->refresh();
        $this->assertEquals(ActivityStatus::Approved, $activity->status);
        $this->assertEquals($admin->id, $activity->approved_by);

        Notification::assertSentTo($parent, ActivityApprovedNotification::class);
    }

    public function test_admin_rejects_activity_with_reason_notifies_requester(): void
    {
        Notification::fake();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $educator = User::factory()->create(['tenant_admin_id' => $admin->id]);
        $educator->assignRole('educateur');

        $activity = Activity::create([
            'name' => 'Sortie risquée',
            'scheduled_date' => now()->addDays(5),
            'scheduled_time' => '09:00',
            'educator_id' => Teacher::factory()->create()->id,
            'requested_by' => $educator->id,
            'status' => ActivityStatus::PendingApproval->value,
            'max_participants' => 20,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.activities.reject', $activity), [
                'rejection_reason' => 'Conditions météo',
            ])
            ->assertRedirect(route('admin.activities.index'));

        $activity->refresh();
        $this->assertEquals(ActivityStatus::Rejected, $activity->status);
        $this->assertEquals('Conditions météo', $activity->rejection_reason);

        Notification::assertSentTo($educator, ActivityRejectedNotification::class);
    }
}
