<?php

namespace Database\Seeders;

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
            RoleSeeder::class,      // Spatie roles + superadmin + SmartKids system user
            MealSeeder::class,      // 4 weeks of menus (tenant-agnostic)
            VisionSeeder::class,    // 2 admin tenants with full lifecycle dataset
        ]);
    }
}
