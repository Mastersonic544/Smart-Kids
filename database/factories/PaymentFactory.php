<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'child_id' => Child::factory(),
            'montant' => $this->faker->randomElement([250.00, 350.00, 450.00]),
            'statut' => $this->faker->randomElement(['payé', 'en attente']),
            'pdf_path' => null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
