<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehicule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::inRandomOrder()->first()->id,
            'immatriculation' => fake()->unique()->regexify('[A-Z]{2}-[0-9]{3}-[A-Z]{2}'),
            'marque' => fake()->word(),
            'modele' => fake()->word(),
            'motorisation' => fake()->randomElement(['essence', 'diesel', 'hybride', 'electrique']),
            'nb_portes' => fake()->randomElement([3, 5]),
            'nb_places' => fake()->randomElement([4, 5, 7]),
            'type_boite_vitesse' => fake()->randomElement(['manuelle', 'automatique']),
            'prix_journalier' => fake()->randomFloat(2, 50, 500),
            'image_url' => fake()->imageUrl(640, 480, 'cars', true),
            'age_minimum' => fake()->randomElement([18, 21, 25]),
        ];
    }
}
