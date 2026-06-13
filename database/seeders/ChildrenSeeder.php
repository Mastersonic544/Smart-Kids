<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder for children records.
 */
class ChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $parents = User::role('parent')->get();
        $classrooms = Classroom::all();

        if ($parents->isEmpty() || $classrooms->isEmpty()) {
            return;
        }

        // Create 35 children
        for ($i = 0; $i < 35; $i++) {
            Child::factory()->create([
                'parent_id' => $parents->random()->id,
                'classroom_id' => $classrooms->random()->id,
            ]);
        }
    }
}
