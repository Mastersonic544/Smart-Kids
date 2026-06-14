<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Class RoleSeeder
 *
 * Seeds the database with the initial roles and test users.
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        Role::firstOrCreate(['name' => 'superadmin']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'educateur']);
        Role::firstOrCreate(['name' => 'parent']);

        // System user used as the "SmartKids" sender for automated messages
        // (tuition changes, activity approvals, payment-due reminders, ...).
        User::firstOrCreate(
            ['email' => 'system@smartkids.local'],
            [
                'name' => 'SmartKids',
                'password' => Hash::make(\Illuminate\Support\Str::random(40)),
                'is_system' => true,
            ]
        );

        // Create SuperAdmin user (SaaS owner)
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@smartkids.tn'],
            [
                'name' => 'SmartKids SaaS Owner',
                'password' => Hash::make('password'),
            ]
        );
        if (! $superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
        }

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartkids.tn'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'subscription_status' => 'active',
                'billing_period' => 'monthly',
                'subscription_started_at' => now(),
                'subscription_due_at' => now()->addMonth(),
            ]
        );
        if (! $admin->hasRole('admin')) {
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
        if (! $educateur->hasRole('educateur')) {
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
        if (! $parent->hasRole('parent')) {
            $parent->assignRole('parent');
        }
    }
}
