<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tunisianFirstNames = ['Anis', 'Zied', 'Mounir', 'Kaouther', 'Olfa', 'Sonia', 'Hafedh', 'Leila'];
        $tunisianLastNames = ['Ben Amor', 'Ghariani', 'Letaief', 'Belhaj', 'Ghodbane', 'Bouhlel'];

        $nom = $this->faker->randomElement($tunisianLastNames);
        $prenom = $this->faker->randomElement($tunisianFirstNames);

        return [
            'user_id' => User::factory(),
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => strtolower($prenom.'.'.str_replace(' ', '', $nom).'@smartkids.tn'),
            'telephone' => $this->faker->regexify('[259][0-9]{7}'), // Tunisian phone style
            'document_contractuel' => null,
        ];
    }
}
