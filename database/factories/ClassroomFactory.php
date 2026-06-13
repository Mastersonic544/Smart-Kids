<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = [
            ['nom' => 'Pépinière A', 'niveau' => 'pépinière'],
            ['nom' => 'Petite Section B', 'niveau' => 'petite_section'],
            ['nom' => 'Moyenne Section C', 'niveau' => 'moyenne_section'],
            ['nom' => 'Grande Section D', 'niveau' => 'grande_section'],
        ];

        $level = $this->faker->randomElement($levels);

        return [
            'nom' => $level['nom'],
            'niveau' => $level['niveau'],
            'capacite' => 20,
        ];
    }
}
