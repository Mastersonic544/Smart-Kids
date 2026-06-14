<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasscodeLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_passcode_login_screen_renders(): void
    {
        $this->get('/login/code')->assertStatus(200);
    }

    public function test_parent_can_authenticate_with_valid_passcode(): void
    {
        $parent = User::factory()->create(['passcode' => '123456']);
        $parent->assignRole('parent');

        $this->post('/login/code', ['passcode' => '123456'])
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($parent);
    }

    public function test_educator_can_authenticate_with_valid_passcode(): void
    {
        $edu = User::factory()->create(['passcode' => '987654']);
        $edu->assignRole('educateur');

        $this->post('/login/code', ['passcode' => '987654']);
        $this->assertAuthenticatedAs($edu);
    }

    public function test_admin_cannot_authenticate_via_passcode_login(): void
    {
        // Admin auth is supposed to go through email/password (Supabase in prod).
        $admin = User::factory()->create(['passcode' => '111111']);
        $admin->assignRole('admin');

        $this->post('/login/code', ['passcode' => '111111'])
            ->assertSessionHasErrors('passcode');

        $this->assertGuest();
    }

    public function test_invalid_passcode_rejected(): void
    {
        $this->post('/login/code', ['passcode' => '000000'])
            ->assertSessionHasErrors('passcode');

        $this->assertGuest();
    }

    public function test_non_six_digit_passcode_rejected_by_validation(): void
    {
        $this->post('/login/code', ['passcode' => 'abc'])
            ->assertSessionHasErrors('passcode');
    }
}
