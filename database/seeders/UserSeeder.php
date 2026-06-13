<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder for users including Admin, Educators, and Parents.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@smartkids.tn'],
            [
                'name' => 'Admin SmartKids',
                'password' => Hash::make('password'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 2. Educators (4)
        $educatorData = [
            ['name' => 'Anis Ben Amor', 'email' => 'anis@smartkids.tn'],
            ['name' => 'Kaouther Ghariani', 'email' => 'kaouther@smartkids.tn'],
            ['name' => 'Zied Letaief', 'email' => 'zied@smartkids.tn'],
            ['name' => 'Olfa Belhaj', 'email' => 'olfa@smartkids.tn'],
        ];

        foreach ($educatorData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('educateur');

            // Creating the associated teacher record
            $nameParts = explode(' ', $data['name']);
            Teacher::create([
                'user_id' => $user->id,
                'nom' => $nameParts[1] ?? '',
                'prenom' => $nameParts[0],
                'email' => $data['email'],
                'telephone' => '20' . rand(100000, 999999),
            ]);
        }

        // 3. Parents (20)
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 20; $i++) {
            $parent = User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => "parent$i@example.com",
                'phone' => '2' . $faker->randomNumber(7, true),
                'password' => Hash::make('password'),
            ]);
            $parent->assignRole('parent');
        }
    }
}
