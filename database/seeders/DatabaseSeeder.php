<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // Spatie roles (admin, educateur, parent)
            UserSeeder::class,      // Users and associated Teacher profiles
            ClassroomSeeder::class, // Defined sequence of stages
            ChildrenSeeder::class,  // 35 children linked to parents and classrooms
            AttendanceSeeder::class, // 3 months of history
            PaymentSeeder::class,    // 2 months of history
            ActivitySeeder::class,   // Activities with participants
            MealSeeder::class,       // 4 weeks of menus
        ]);
    }
}
