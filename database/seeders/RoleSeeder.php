<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

/**
 * Class RoleSeeder
 * 
 * Seeds the database with the initial roles and test users.
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Define roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'educateur']);
        Role::firstOrCreate(['name' => 'parent']);

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartkids.tn'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create Educator user
        $educateur = User::firstOrCreate(
            ['email' => 'educateur@smartkids.tn'],
            [
                'name' => 'Educateur User',
                'password' => Hash::make('password'),
            ]
        );
        if (!$educateur->hasRole('educateur')) {
            $educateur->assignRole('educateur');
        }

        // Create Parent user
        $parent = User::firstOrCreate(
            ['email' => 'parent@smartkids.tn'],
            [
                'name' => 'Parent User',
                'password' => Hash::make('password'),
            ]
        );
        if (!$parent->hasRole('parent')) {
            $parent->assignRole('parent');
        }
    }
}
