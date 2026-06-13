<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Seeder;

/**
 * Seeder for classroom levels.
 */
class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $levels = [
            ['nom' => 'Nursery (Pépinière)', 'niveau' => 'pépinière'],
            ['nom' => 'Petite Section', 'niveau' => 'petite_section'],
            ['nom' => 'Moyenne Section', 'niveau' => 'moyenne_section'],
            ['nom' => 'Grande Section', 'niveau' => 'grande_section'],
        ];

        foreach ($levels as $level) {
            Classroom::create($level);
        }
    }
}
