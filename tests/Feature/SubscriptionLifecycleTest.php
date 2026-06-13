<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\User;
use App\Notifications\SubscriptionDueSoonNotification;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriptionLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_due_soon_admins_get_notified(): void
    {
        Notification::fake();

        $admin = User::factory()->create([
            'subscription_status' => 'active',
            'billing_period' => 'monthly',
            'subscription_due_at' => now()->addDays(3),
        ]);
        $admin->assignRole('admin');

        $this->artisan('subscriptions:process')->assertSuccessful();

        Notification::assertSentTo($admin, SubscriptionDueSoonNotification::class);
    }

    public function test_overdue_admins_get_frozen(): void
    {
        $admin = User::factory()->create([
            'subscription_status' => 'active',
            'billing_period' => 'monthly',
            'subscription_due_at' => now()->subDay(),
        ]);
        $admin->assignRole('admin');

        $this->artisan('subscriptions:process')->assertSuccessful();

        $admin->refresh();
        $this->assertEquals('frozen', $admin->subscription_status);
        $this->assertNotNull($admin->frozen_at);
    }

    public function test_frozen_admins_block_write_actions_for_their_parents(): void
    {
        $admin = User::factory()->create([
            'subscription_status' => 'frozen',
            'frozen_at' => now(),
        ]);
        $admin->assignRole('admin');

        $parent = User::factory()->create(['tenant_admin_id' => $admin->id]);
        $parent->assignRole('parent');

        $child = Child::factory()->create(['parent_id' => $parent->id]);
        $payment = $child->payments()->create([
            'montant' => 400,
            'statut' => 'en attente',
        ]);

        $this->actingAs($parent)
            ->post(route('parent.payments.pay', $payment))
            ->assertStatus(423); // Locked
    }

    public function test_admin_can_still_reach_subscription_page_when_frozen(): void
    {
        $admin = User::factory()->create([
            'subscription_status' => 'frozen',
            'frozen_at' => now(),
        ]);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get(route('admin.subscription.show'))
            ->assertOk();
    }

    public function test_paying_subscription_unfreezes_admin(): void
    {
        $admin = User::factory()->create([
            'subscription_status' => 'frozen',
            'frozen_at' => now(),
        ]);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->post(route('admin.subscription.pay'), ['billing_period' => 'monthly'])
            ->assertRedirect(route('admin.subscription.show'));

        $admin->refresh();
        $this->assertEquals('active', $admin->subscription_status);
        $this->assertNull($admin->frozen_at);
        $this->assertNotNull($admin->subscription_due_at);
        $this->assertDatabaseHas('saas_payments', [
            'admin_id' => $admin->id,
            'period' => 'monthly',
            'status' => 'paid',
        ]);
    }
}
