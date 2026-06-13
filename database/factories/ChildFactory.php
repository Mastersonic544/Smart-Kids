<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Child>
 */
class ChildFactory extends Factory
{
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tunisianFirstNames = [
            'Ahmed', 'Mohamed', 'Yassine', 'Amine', 'Omar', 'Ali', 'Hamza', 'Sami', 'Youssef', 'Adem',
            'Sarra', 'Mariem', 'Fatma', 'Nour', 'Lina', 'Eya', 'Salma', 'Ines', 'Malek', 'Hela'
        ];

        $tunisianLastNames = [
            'Trabelsi', 'Ben Ali', 'Gharbi', 'Mansour', 'Jlassi', 'Ayari', 'Dridi', 'Hamdi', 'Saidi', 'Masmoudi',
            'Bouaziz', 'Rezgui', 'Abidi', 'Sellami', 'Cherif', 'Hajri', 'Mejri', 'Tounsi', 'Mahmoudi', 'Kallel'
        ];

        $allergiesList = ['Arachides', 'Lait', 'Gluten', 'Œufs', 'Soja', 'Pollen', 'Poussière'];

        return [
            'nom' => $this->faker->randomElement($tunisianLastNames),
            'prenom' => $this->faker->randomElement($tunisianFirstNames),
            'date_naissance' => $this->faker->dateTimeBetween('-5 years', '-2 years')->format('Y-m-d'),
            'allergies' => $this->faker->boolean(20) ? $this->faker->randomElement($allergiesList) : null,
            'parent_id' => User::factory(), // This will be overridden in the seeder
            'classroom_id' => Classroom::factory(), // This will be overridden in the seeder
        ];
    }
}
