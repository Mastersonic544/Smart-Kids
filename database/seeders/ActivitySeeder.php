<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Child;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

/**
 * Seeder for kindergarten activities and participation records.
 */
class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $children = Child::all();

        if ($teachers->isEmpty() || $children->isEmpty()) {
            return;
        }

        // Create 10 activities
        $activities = Activity::factory()->count(10)->create([
            'educator_id' => fn () => $teachers->random()->id,
        ]);

        // Assign random children to each activity
        foreach ($activities as $activity) {
            $participants = $children->random(rand(5, 15));
            foreach ($participants as $child) {
                $activity->children()->attach($child->id, [
                    'attended' => rand(1, 100) > 10, // 90% attendance rate for signed-up children
                ]);
            }
        }
    }
}
