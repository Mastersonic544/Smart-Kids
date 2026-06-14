<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder for weekly meal menus.
 */
class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::role('admin')->first();

        if (! $admin) {
            return;
        }

        // Create 4 weeks of menus
        for ($i = 0; $i < 4; $i++) {
            Meal::factory()->create([
                'week_start' => now()->subWeeks($i)->startOfWeek()->format('Y-m-d'),
                'created_by' => $admin->id,
            ]);
        }
    }
}
