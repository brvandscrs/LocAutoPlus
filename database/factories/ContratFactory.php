<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Vehicule;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contrat>
 */
class ContratFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'vehicule_id' => Vehicule::inRandomOrder()->first()->id,
            'date_debut' => fake()->dateTimeBetween('-6 months', 'now'),
            'date_fin' => fake()->dateTimeBetween('now', '+6 months'),
            'montant' => fake()->randomFloat(2, 100, 1000),
            'etat_contrat' => fake()->randomElement(['actif', 'expire', 'suspendu']),
        ];
    }
}
