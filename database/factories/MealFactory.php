<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dishes = [
            'Couscous aux légumes', 'Pâtes à la sauce bolognaise', 'Riz cantonais',
            'Gratin de pâtes', 'Purée de pommes de terre et poisson',
            'Soupe de lentilles (Chorba)', 'Ojja aux œufs', 'Escalope de poulet grillée',
            'Salade tunisienne', 'Fruits de saison', 'Yaourt nature'
        ];

        return [
            'week_start' => $this->faker->dateTimeBetween('-4 weeks', 'now')->modify('monday this week')->format('Y-m-d'),
            'monday' => json_encode(['plat' => $this->faker->randomElement($dishes), 'dessert' => 'Fruit']),
            'tuesday' => json_encode(['plat' => $this->faker->randomElement($dishes), 'dessert' => 'Yaourt']),
            'wednesday' => json_encode(['plat' => $this->faker->randomElement($dishes), 'dessert' => 'Fruit']),
            'thursday' => json_encode(['plat' => $this->faker->randomElement($dishes), 'dessert' => 'Yaourt']),
            'friday' => json_encode(['plat' => $this->faker->randomElement($dishes), 'dessert' => 'Fruit']),
            'created_by' => User::factory(), // Will be admin in seeder
        ];
    }
}
