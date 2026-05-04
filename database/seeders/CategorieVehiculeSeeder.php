<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategorieVehicule;

class CategorieVehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Citadine',    'description' => 'Petite voiture idéale en ville',         'tarif_base_jour' => 35.00],
            ['nom' => 'Berline',     'description' => 'Confort et espace pour longs trajets',    'tarif_base_jour' => 55.00],
            ['nom' => 'SUV',         'description' => 'Polyvalent, spacieux et surélevé',        'tarif_base_jour' => 75.00],
            ['nom' => 'Utilitaire',  'description' => 'Véhicule de transport de marchandises',   'tarif_base_jour' => 65.00],
            ['nom' => 'Luxe',        'description' => 'Véhicule haut de gamme premium',          'tarif_base_jour' => 120.00],
        ];

        foreach ($categories as $categorie) {
            CategorieVehicule::create($categorie);
        }
    }
}
