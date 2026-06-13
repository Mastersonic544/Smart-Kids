<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activities = [
            ['name' => 'Peinture au doigt', 'desc' => 'Expression artistique utilisant les doigts pour stimuler la sensorialité.'],
            ['name' => 'Éveil musical', 'desc' => 'Découverte des sons et des rythmes à travers des instruments simples.'],
            ['name' => 'Lecture de contes', 'desc' => 'Immersion dans le monde imaginaire à travers des histoires adaptées.'],
            ['name' => 'Sortie au jardin', 'desc' => 'Exploration de la nature et observation des plantes et des insectes.'],
            ['name' => 'Psychomotricité', 'desc' => 'Parcours d\'obstacles pour développer la coordination et l\'équilibre.'],
            ['name' => 'Atelier cuisine', 'desc' => 'Préparation de petits gâteaux simples pour apprendre les mélanges.'],
        ];

        $activity = $this->faker->randomElement($activities);

        return [
            'name' => $activity['name'],
            'description' => $activity['desc'],
            'scheduled_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'scheduled_time' => $this->faker->time('H:i'),
            'educator_id' => Teacher::factory(),
            'max_participants' => 15,
        ];
    }
}
